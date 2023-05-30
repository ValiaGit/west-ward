<?php


if(!defined('APP')) {
    die();
}


use Carbon\Carbon;

class Deposit extends Service {


    /**
     * @param int $provider_id
     * @param int $amount
     * @param string $provider_name
     * @return array
     */
    public function initializeTransaction($provider_id = 0,$amount = 0, $provider_name = "",$account_id = false, $security_code =false) {


        //Get Parameters And sanitise valuess
        $provider_id = (int) $provider_id;
        $amount = (int) $amount;
        $account_id = (int) $account_id;
        $security_code = (int) $security_code;


        if($provider_id==0 || $amount==0) {
            return array("code"=>50);
        }



        //CHeck If User Session is Alive
        $user_data = $this->checkUserAccess();
        if ($user_data) {


            $db = $this->db;

            $user_id = $user_data['id'];
            $core_currencies_id = $user_data['core_currencies_id'];


            //Check If User Has Self Added Limits
            $limit_protection_info = $this->_checkLimitProtection($user_id,$amount);
            if($limit_protection_info['code'] == 10) {
                return array(
                    "code"=>-1008,
                    "msg"=>"Your account is protected with deposit limit!",
                    "protection"=>$limit_protection_info
                );
            }


            //Check if Provided Money Account Id Has Limits
            //For Example if user deposits more then 500Euros from card X we should return message to provider scanned copy
            $check_deposit_limits = $this->CheckLimitByAccountId($provider_id,$account_id,$user_id,$amount);
            if($check_deposit_limits['code']!=10) {
                return $check_deposit_limits;
            }


            //Generate New Transaction To Insert
            $transaction_unique_id = $this->generatePaymentGUID();

            //Insert New Transaction With Init Status
            $insert_data = array(
                "core_users_id"=>$user_id,
                "money_providers_id"=>$provider_id,
                "transaction_unique_id"=>$transaction_unique_id,
                "amount"=>$amount,
                "core_currencies_id"=>$core_currencies_id,
                "type"=>1,
                "ip"=>ip2long(IP)
            );

            if($account_id) {
                $insert_data['money_accounts_id'] = $account_id;
            }


            //If Saved New Transaction
            $inserted_deposit_transaction = $db->insert("money_transactions",$insert_data);
            if($inserted_deposit_transaction) {

                //Dynamically Load Provider Class for andling Deposits
                $deposit_provider_service = $this->loadPaymentProvider("deposit/".$provider_name);

                //If Provider Class Was not cfound
                if(!$deposit_provider_service) {
                    return array("code"=>-30);
                }

                //Get detaled Info about user
                $user_data = $this->loadService("user/settings")->getUserInfo();


                //If Received Data From User
                if($user_data['code'] == 10) {


                    //Check If User Has Confirmed Identity
                    //If user is depositing more then 2330 Euro
                    //TODO This should be check on currency
                    if($amount/100 > 2330 && !$user_data['data']['is_email_confirmed']) {
                        return array("code"=>-54,"msg"=>"Please send us identification document to process your request! You can not deposit amount greater then 2330 Euros");
                    }

                    //User with uncofirmed email cant deposit
                    if(!$user_data['data']['is_email_confirmed']) {
                        return array("code"=>-54,"msg"=>"You must confirm email to make deposit! <br/>Check email or go in settings to resend confirmation!");
                    }


                    //Execute Deposit Init on Payment provider Class Instance
                    $provider_deposit_response = $deposit_provider_service->init($transaction_unique_id,$amount,$user_data['data'],$account_id,$security_code,$provider_id);



                    //If Deposit Provider Returns has fields ClientSide should open popup window like on Apco()
                    if(isset($provider_deposit_response['has_fields']) && $provider_deposit_response['has_fields']) {
                        $return = $provider_deposit_response;

                        //Update Transaction
                        $db->where("id",$inserted_deposit_transaction);
                        $update_transaction = $db->update("money_transactions",array(
                            "cut_amount"=>$provider_deposit_response['cut_amount'],
                            "commission"=>$provider_deposit_response['commission']
                        ));


                    }



                    else {

                        //If provider deposited successfully and doesn't need additional steps
                        if($provider_deposit_response['code'] == 10) {

                            $db->startTransaction();

                                //Update Balance
                                $db->where("id",$user_id);
                                $update_balance = $db->update("core_users",array(
                                    "balance"=>$db->inc($provider_deposit_response['amount'])
                                ));


                                //Update Transaction Status and some fields
                                $db->where("id",$inserted_deposit_transaction);
                                $update_transaction = $db->update("money_transactions",array(
                                    "status"=>1,
                                    "cut_amount"=>$provider_deposit_response['cut_amount'],
                                    "commission"=>$provider_deposit_response['commission'],
                                    "bank_transaction_id"=>@$provider_deposit_response['bank_transaction_id'],
                                    "bank_transaction_date"=>@$provider_deposit_response['bank_transaction_date'],
                                    "bank_status"=>@$provider_deposit_response['bank_status']
                                ));


                                //Save Info About Deposit from provided Account
                                //money_user_deposits_left_in_system
                                $deposit_amount = $provider_deposit_response['amount'];
                                $insert_money_info = $db->rawQuery("INSERT INTO money_user_deposits_left_in_system(core_users_id,money_accounts_id,amount) VALUES('$user_id','$account_id','$deposit_amount')  ON DUPLICATE KEY UPDATE amount=amount+$deposit_amount");

                                //If Everything Succeed Commit Transaction on multi table
                                if($update_balance && $insert_money_info!==false && $update_transaction) {
                                    $db->commit();
                                    $return['code'] = 10;
                                }

                                //If Anything failed rollback all actions
                                else {
                                    $db->rollback();
                                    $return['code'] = $provider_deposit_response['bank_status'];
                                }




                        }

                        //Immediate Deposit Didn't succeed
                        else {


                            $db->where("id",$inserted_deposit_transaction);
                            $db->update("money_transactions",array(
                                "status"=>$provider_deposit_response['status']
                            ));
                            $return['data'] = $provider_deposit_response;
                            $return['code'] = 30;
                            $return['msg'] = "Cant make deposit right now, please try again!";
                        }
                    }





                    return $return;
                }

                //If we can't get user detailed info
                else {
                    return array("code"=>-40);
                }

            }
            else {
                echo $db->getLastError()."Here";
                return array("code"=>-30);
            }



        }


        //User Not Authenticated
        else {
            return array("code"=>40);
        }
    }


    /**
     * @param $user_id
     * @param $amount
     * @return array
     */
    private function _checkLimitProtection($user_id,$amount) {

        $db = $this->db;

        //CAST
        $user_id = (int) $db->escape($user_id);
        $amount = (int) $db->escape($amount);

        $protections_service = $this->loadService("user/protection");
        $protections = $protections_service->_checkProtection($user_id);
        if($protections['code'] == 10) {
            if(isset($protections['protections'][2])) {


                $protection_data = $protections['protections'][2];

                $protection_amount = $protection_data['amount'];

                $create_time = $protection_data['create_time'];
                $expire_date = $protection_data['expire_date'];
                $period_minutes = $protection_data['period_minutes'];


                $protection_create_time = $protection_data['create_time'];

                //Check What Amount Has Deposited From Start Of Limit
                $db->where("core_users_id",$user_id);
                $db->where("type",1);
                $db->where("status",1);
                $db->where ('transaction_date', $protection_create_time, ">=");

                $deposits_amount = $db->get("money_transactions",null,"SUM(amount) as total_deposits");

                if(count($deposits_amount)) {

                    $already_deposited = (float)$deposits_amount[0]['total_deposits'];
                    if(($already_deposited+$amount) >= $protection_amount) {
                        return array(
                            "code"=>10,
                            "available_amount_to_deposit"=>($protection_amount-$already_deposited),
                            "create_time"=>$create_time,
                            "period_minutes"=>$period_minutes,
                            "expire_date"=>$expire_date
                        );
                    } else {
                        return array("code"=>-10);
                    }


                } else {

                    if($amount>=$protection_amount) {
                        return array("code"=>10,"available_amount_to_deposit"=>($protection_amount-$already_deposited),"protection"=>$protections['protections'][2]);
                    }


                    return array("code"=>-10);
                }



            } else {
                return array("code"=>-10);
            }
        } else {
            return array("code"=>-10);
        }

    }


    /**
     * Generate Unique Identifier For Payment
     * @return string
     */
    protected function generatePaymentGUID() {
        return md5(sha1(time().session_id()."P2Im#nT0KeN"));
    }


    /**
     * @param $provider_id
     * @param $account_id
     * @param $user_id
     * @param $amount
     * @return array
     */
    protected function CheckLimitByAccountId($provider_id,$account_id,$user_id,$amount) {
        global $db;

        if($account_id) {
            $db->where('core_users_id',$user_id);
            $db->where('money_accounts_id',$account_id);
            $db->where('type',1);
            $db->where('status',1);
            $db->orWhere('status',5);
            $already_deposited = $db->getOne("money_transactions",'SUM(amount) as total_amount');
            $already_deposited_amount = $already_deposited['total_amount'];

            //if Already Deposited With This Account more then 500 Euros
            if($already_deposited_amount/100>=500 || $amount/100>=500) {

                $db->where('id',$account_id);
                $account_status = $db->getOne('money_accounts',"ConfirmationStatus");
                $money_account_confirmation = $account_status['ConfirmationStatus'];
                if($money_account_confirmation!=1) {

                    $messageAdd = "Send us copy of credit/debit card at support@bookiebot.com from your registration email.";
                    if($provider_id == 2) {
                        $messageAdd = "Send us copy of bank statement at support@bookiebot.com with account number and account holders name.";
                    }

                    return array("code"=>-59,"msg"=>"Your total deposits exceed 500 Euros you should confirm this payment account to proceed!<br/> <br/>$messageAdd ");
                }

            } else {
                return array("code"=>10);
            }
        }



        return array("code"=>10);
    }



}



?>
