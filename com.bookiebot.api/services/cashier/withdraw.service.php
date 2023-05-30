<?php


if (!defined('APP')) {
    die();
}

ini_set("display_errors",1);

class Withdraw extends Service
{


    /**
     * @param int $provider_id
     * @param int $amount
     * @param string $provider_name
     * @param bool $account_id
     * @param bool $account_password
     * @return array
     */
    public function initializeTransaction($provider_id = 0, $amount = 0, $provider_name = "", $account_id = false, $account_password = false)
    {




        $db = $this->db;

        $provider_id = (int)$provider_id;
        $amount = (int)$amount;
        $account_id = (int)$account_id;
        $account_password = $db->escape($account_password);

        //Check If Provided Password Is Correct
        //TODO This should be based on provider Not every provider should require account password
        if($account_id) {
            $session_service = $this->loadService("user/session");
            $is_password_correct = $session_service->checkPassword($account_password);
            if ($is_password_correct['code'] != 10) {
                return array("code" => -102, "msg" => "Account Password is Wrong!");
            }
        }



        if ($provider_id == 0 || $amount == 0) {
            return array("code" => 50);
        }

        $user_in_session = $this->checkUserAccess();

        if ($user_in_session) {

            $user_id = $user_in_session['id'];
            $core_currencies_id = $user_in_session['core_currencies_id'];


            // CHECK Verification & Money Left in Account
            // -1. User Balance
            // -0.5 Check KYC(Know Your Customer Policy)
            // 0. Minimum Withdraw
            // 1. Check Email confirmation
            // 2. Check Money Account Verification
            // 3. Check Money left in Account
            $check = $this->CheckUserCanWithdraw($user_in_session,$account_id,$amount,$provider_id);
            if ( $check['code'] != 10 ) {
                return $check;
            }


            //Get User Details
            $user_info = $this->loadService("user/settings")->getUserInfo();
            $user_data = $user_info['data'];

//            //Apco Ecopayz Can withdraw Automatically
//            if($provider_name =='apco' && $provider_id == 16) {
//                $transaction = $this->automaticTransfer( $user_data, $amount, $provider_id, $provider_name, $account_id );
//                return $transaction;
//            }

            //Check Here What Money Should Go With What Account
            $db->where("core_users_id", $user_id);
            $db->where("money_accounts_id", $account_id);
            $user_left_money = $db->getOne("money_user_deposits_left_in_system", "amount");




            //If User Had Some Money On Account Which was chosen for withdrawal We Can Withdraw Immediatelly
            if ($user_left_money && isset($user_left_money['amount']) && $user_left_money['amount']>0) {

                $left_amount = $user_left_money['amount'];


                //If requested less amount than was deposited Its withdraw ed Automatically
                if ($left_amount >= $amount) {
                    $transaction = $this->automaticTransfer( $user_data, $amount, $provider_id, $provider_name, $account_id );
                    return $transaction;
                }

                //If Requested Money Is More Than Left in money account
                else {
                    $transaction = $this->automaticTransfer( $user_data, $left_amount, $provider_id, $provider_name, $account_id, true, $amount-$left_amount );
                    return $transaction;
                }
            }

            //FULL AMOUNT GOES FOR WIRE TRANSFER
            else {
                $transfer = $this->wireTransfer( $user_data, $amount, $account_id );
                return $transfer;
            }

        //User Session is not valid return error
        } else {
            return array("code" => 20,"msg"=>"no user");
        }

    } // function initializeTransaction()





    /**
     * @param $user_data, $amount, $account_id
     * @return array
     */
    private function automaticTransfer( $user_data, $amount, $provider_id, $provider_name, $account_id = false, $is_split = false, $additional = 0 )
    {
        $db = $this->db;

        $transaction_insert_data = array(
            "core_users_id" => $user_data['userId'],
            "core_currencies_id" => $user_data["core_currencies_id"],
            "money_providers_id" => $provider_id,
            "amount" => $amount,
            "type" => 2,
            "transfer_type"=>1,
            "ip" => ip2long(IP)
        );

        if($account_id) {
            $transaction_insert_data['money_accounts_id'] = $account_id;
        }

        $insert_response = $this->InsertNewTransaction($transaction_insert_data);

        if($insert_response['code'] == 10) {

            //Send Refund Request
            $withdraw_provider = $this->loadPaymentProvider("withdraw/" . $provider_name);
            //Withdraw Response FROM Provider
            $provider_withdraw_response = $withdraw_provider->init($insert_response['unique_id'], $amount, $user_data, $account_id,false,$provider_id);

            if ($provider_withdraw_response['code'] == 10)
            {

                $db->where("core_users_id", $user_data['userId']);
                $db->where("money_accounts_id", $account_id);
                $update_left_money = $db->update("money_user_deposits_left_in_system", array("amount"=>$db->dec($amount)));

                // if it is apco
                if ( $provider_name == 'apco' ) {


                    if ( $is_split ){
                        $provider_withdraw_response ["is_split"] = true;
                        $provider_withdraw_response ["msg"] = "Only ".($amount/100)." Euros were withdrawn with this payment method.<br/> Additional ".($additional/100)." Euros can be withdrawn via Wire Transfer";
                    }
                    return $provider_withdraw_response;

                // if it isnot apco
                } elseif (isset($provider_withdraw_response['has_fields']) && $provider_withdraw_response['has_fields']) {

                    //Set Transaction cut amount
                    $db->where("id", $insert_response['trans_id']);
                    $update_transaction = $db->update("money_transactions", array(
                        "cut_amount" => $provider_withdraw_response['amount'],
                        "commission" => $provider_withdraw_response['commission'],
                    ));

                    if ( $update_transaction ) {
                        if ( $is_split ){
                            $provider_withdraw_response ["is_split"] = true;
                            $provider_withdraw_response ["msg"] = "Only ".($amount/100)." Euros were withdrawn with this payment method.<br/> Additional ".($additional/100)." Euros can be withdrawn via Wire Transfer";
                        }
                        return $provider_withdraw_response;
                    }
                    else
                        return array("code" => 20,"msg"=>$db->getLastError());

                }
                // has fields end
                // has no fields start
                else {

                    $db->startTransaction();


                    //Update Balance
                    $db->where("id", $user_data['userId']);
                    $update_balance = $db->update("core_users", array(
                        "balance" => $db->dec($amount)
                    ));

                    //Update Transaction as successfull
                    $db->where("id", $insert_response['trans_id']);
                    $update_transaction = $db->update("money_transactions", array(
                        "status" => 1,
                        "cut_amount" => $provider_withdraw_response['cut_amount'],
                        "commission" => $provider_withdraw_response['commission'],
                        "bank_transaction_id" => $provider_withdraw_response['bank_transaction_id'],
                        "bank_transaction_date" => $provider_withdraw_response['bank_transaction_date'],
                        "bank_status" => $provider_withdraw_response['bank_status']
                    ));


                    //Decrease Amount of money left table for currenct Withdrawal Option
                    $db->where("core_users_id", $user_data['userId']);
                    $db->where("money_accounts_id", $account_id);
                    $update_left_money = $db->update("money_user_deposits_left_in_system", array("amount"=>$db->dec($amount)));


                    //If Everything Succeed
                    if ($update_transaction && $update_balance && $update_left_money) {
                        $db->commit();

                        if ( $is_split ){
                            return array("code"=>10,"is_split"=>true,"msg"=>"Only ".($amount/100)." Euros were withdrawn with this payment method.<br/> Additional ".($additional/100)." Euros can be withdrawn via Wire Transfer");
                        } else {
                            return array("code" => 10);
                        }

                    }

                    else {
                        $db->rollback();
                        return array("code" => 20,"msg"=>$db->getLastError());
                    }
                }
                // has no fields end
            }
            else {
                return array("code" => 30,"msg"=>"Here".json_encode($provider_withdraw_response));
            }
        }
        else {
            return array("code" => 30,"msg"=>"Here 2".json_encode($insert_response));
        }
    } // function automaticTransfer()




    /**
     * @param $user_data, $amount, $account_id
     * @return array
     */
    private function wireTransfer( $user_data, $amount, $account_id )
    {
        //TODO rollback

        $db = $this->db;

        $transaction_insert_data = array(
            "core_users_id" => $user_data['userId'],
            "core_currencies_id" => $user_data["core_currencies_id"],
            "amount" => $amount,
            "type" => 2,
            "status"=>5,
            "transfer_type"=>2,//Wire Transfer Flag
            "money_accounts_id" => $account_id,
            "ip" => ip2long(IP)
        );

        $insert_response = $this->InsertNewTransaction($transaction_insert_data);

        if($insert_response['code'] == 10) {
            //Update User balance
            $db->where("id", $user_data['userId']);
            $update_balance = $db->update("core_users", array(
                "balance" => $db->dec($amount)
            ));

            if($update_balance) {
                return array("code" => 10,"msg"=>"Money Was Transferred By Wire Transfer It will take few days to settle!");
            } else {
                $db->where('id', $insert_response['trans_id']);
                $db->delete('money_transactions');
                return array("code"=>20,"msg"=>'No Update balance');
            }
        } else {
            return array("code" => 20,"msg"=>'Not inserted transaction');
        }
    } // function wireTransfer()



    /**
     * @param $user_in_session, $account_id, $amount, $provider_id
     * @return array
     */
    private function CheckUserCanWithdraw($user_in_session,$account_id,$amount,$provider_id)
    {
        $db = $this->db;


        // check user balance start
        $user_balance = $this->loadService("user/session")->getBalance();
        if ($user_balance['code'] == 10) {

            //Money That User Has On Balance
            $balance_value = $user_balance['balance'];

            //If Is Enough For Withdraw
            if ($balance_value < $amount) {
                return array("code" => 30, "msg" => "You don't have enough balance");
            }
        } else {
            return array("code" => 20,'msg'=>'cant get balance');
        }
        // check user balance end


        // check passport startTransaction
        if ( !$user_in_session['is_passport_confirmed'] ){
            return array("code" => 809, "msg" => "Your account is unverified! Please provide personal documents, to withdraw money!");
        }
        //check passport end

        //Check If User Has Confirmed Identity
        if(!$user_in_session['is_email_confirmed']) {
            return array("code"=>-54,"msg"=>"Please send us identification document to process your request!");
        }


        //Check Total Withdrawals For User
        $db->where('core_users_id',$user_in_session['id']);
        $db->where('money_accounts_id',$account_id);
        $db->where('type',2);
        $already_withdrawn = $db->getOne("money_transactions",'SUM(amount) as total_amount');
        $already_withdrawn_amount = $already_withdrawn['total_amount'];


        //If User Has Withdrawed 500 Euros Accumulated We should check verification status of withdrawal option
        if($already_withdrawn_amount/100>=500 || $amount/100>=500) {

            $db->where('id',$account_id);
            $account_status = $db->getOne('money_accounts',"ConfirmationStatus");
            $money_account_confirmation = $account_status['ConfirmationStatus'];

            //If Payment option was not confirmed Return Error Message With instructions
            if($money_account_confirmation!=1) {
                $messageAdd = "Send us copy of credit/debit card at support@bookiebot.com from your registration email.";
                if($provider_id == 2) {
                    $messageAdd = "Send us copy of bank statement at support@bookiebot.com with account number and account holders name.";
                }
                return array("code"=>-59,"msg"=>"Your total withdrawals exceed 500 Euros you should confirm this payment account to proceed!<br/> <br/>$messageAdd ");
            }
        }


        // if user can withdrow money by this account
        if($provider_id!=2) {

            //Check If This Withdraw Method Can Be Accepted; We should check how much money user deposited from provided pament account;
            $left_deposited_money_with_provided_withdraw_accoount = $this->CheckUserHasActiveDeposits($user_in_session['id'],$account_id);


            if(count($left_deposited_money_with_provided_withdraw_accoount)) {
                $calculation = $left_deposited_money_with_provided_withdraw_accoount[0];

                //If user deposited Less amount then he/she tries to withdraw on provided payment account
                if($calculation['amount']<=0) {
                    $amount = $calculation['amount']/100;
                    return array("code" => -807,"max_amount"=>$amount,"msg"=>"You can not make withdraw with chosen payment method!<br/><br/> Maximum withdrawable amount for this method is: $amount Euros<br/><br/> To Check withdraw able amounts per accounts check 'Payment Accounts'<br/><br/> You can choose Bank Transfer as payment method.");
                }


            }

            //User cant withdraw money on thsis payment option because deposit was not done from this account
            else {
                return array("code" => -807,"max_amount"=>$amount,"msg"=>"You can not make withdraw with chosen payment method!<br/><br/> Maximum withdrawable amount for this method is: 0 Euros<br/><br/> To Check withdraw able amounts per accounts check 'Payment Accounts'<br/><br/> You can choose Bank Transfer as payment method.");
            }
        }

        // if everything is ok
        return array("code" => 10);

    } // function CheckUserHasVerifiedAccount()





    /**
     * @param array $InsertData
     * @return array
     */
    private function InsertNewTransaction($InsertData = array()) {
        $transaction_unique_id = $this->generatePaymentGUID();
        $db = $this->db;

        $InsertData["transaction_unique_id"] = $transaction_unique_id;

        //If Transaction Was Saved
        $inserted_transaction_id = $db->insert("money_transactions", $InsertData);

        if ($inserted_transaction_id) {
            return array("code"=>10,"trans_id"=>$inserted_transaction_id,"unique_id"=>$transaction_unique_id);
            //Cut Money From Balance
        } else {
            return array("code" => 30, "msg" => "Cant save transaction try again!".$db->getLastError());
        }
    } // function InsertNewTransaction()


    /**
     * @param $user_id
     * @return array
     */
    private function CheckUserHasActiveDeposits($user_id,$account_id = false)
    {
        $db = $this->db;
        $user_id = (int)$user_id;

        $db->where("core_users_id", $user_id);

        if($account_id) {
            $db->where("money_accounts_id", (int)$account_id);
        }

        $user_has_deposits_data = $db->get("money_user_deposits_left_in_system", null, "amount,money_accounts_id");
        return $user_has_deposits_data;

    } // function CheckUserHasActiveDeposits()


    /**
     * @return string
     */
    protected function generatePaymentGUID()
    {
        return md5(sha1(time() . session_id() . "P2Im#nT0KeN"));
    }


}


?>
