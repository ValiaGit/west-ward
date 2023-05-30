<?php


if(!defined('APP')) {
    die();
}

use Carbon\Carbon;

class Affiliate extends Service
{

    public function terms($type = false){
        global $db;

        $user = $this->checkUserAccess();


        $user_id = $user['id'];

        if($user && !$type) {

            $db->where('id',$user['id']);
            $u = $db->getOne('core_users',"*");

            return [
                'code'=>10,
                'type' => $u['affiliate_type'],
            ];

        }


        elseif( $user && $type ) {


            // The data to send to the API
            $postData = array(
                'user_id' => $user_id,
                'agreement_type' => $type,
                'hash' => hash('sha256',"$user_id$type"."iXvniskarta saaxalwlo sufraze")
            );

            // Setup cURL
            $ch = curl_init('http://affiliates.betplanet.win/api/updateAffiliateType');
            curl_setopt_array($ch, array(
                CURLOPT_POST => TRUE,
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
                CURLOPT_POSTFIELDS => json_encode($postData)
            ));

            // Send the request
            $response = curl_exec($ch);


            $type = (int)$type;

            $db->where('id',$user['id']);
            $db->update("core_users", array(
                "affiliate_type" => $type
            ));

            return true;

        } else {
            return [
                'code'=>20,
                'msg' => 'user not found'
            ];
        }
    }


    public function transaction($type){
        global $db;

        if($type == 1) {
            $amountToCut = 100000;
        }

        else if($type ==2) {
            $amountToCut = 50000;
        }

        else {
            $amountToCut = 4000;
        }

        $user = $this->checkUserAccess();

        if($user) {

            if ( $user['balance'] < $amountToCut ) {
                return [
                    'code'=>-1,
                    'msg' => 'Balance is not enough'
                ];
            }

            else {

                $db->startTransaction();

                $db->where("id", $user['id']);
                $update_balance = $db->update("core_users", array(
                    "balance" => $db->dec($amountToCut)
                ));

                $userId = $user['id'];

                $transaction_id = $db->insert("money_affiliate_transactions", array(
                    'user_id'       => $userId,
                    'amount'        => $amountToCut,
                    'type'          => $type,
                    'ip'            => $_SERVER['REMOTE_ADDR'],
                    'created_at'    => date('Y-m-d H:i:s')
                ));

                if ( $update_balance && $transaction_id ) {
                    $db->commit();



                    //Here We Send Info To Affiliates System About Profit Made only From 40 Euros
                    if($amountToCut == 4000) {
                        // The data to send to the API
                        $postData = array(
                            'user_id' => $userId,
                            'product_id' => 6,
                            'amount' => $amountToCut,
                            'transaction_id' => $transaction_id,
                            'hash' => hash('sha256',"$userId"."6"."$amountToCut$transaction_id"."iXvniskarta saaxalwlo sufraze")
                        );

                        // Setup cURL
                        $ch = curl_init('http://affiliates.betplanet.win/api/add_log');
                        curl_setopt_array($ch, array(
                            CURLOPT_POST => TRUE,
                            CURLOPT_RETURNTRANSFER => TRUE,
                            CURLOPT_HTTPHEADER => array(
                                'Content-Type: application/json'
                            ),
                            CURLOPT_POSTFIELDS => json_encode($postData)
                        ));

                        // Send the request
                        $response = curl_exec($ch);
                        $response = json_decode($response, true);
                        if ($response['code'] == 10) {
                            $profits = $response['profits'];
                            if (count($profits)) {

                                foreach ($profits as $profit) {

                                    //Here We Should Check If User Has Active Affiliation Subscription
                                    $parent_user = $profit['user_id'];
                                    $parent_profit = $profit['amount'];

                                    $db->startTransaction();

                                    $insert_affiliation_transaction = $db->insert('money_affiliate_transactions',array(
                                        "user_id"=>$parent_user,
                                        "amount"=>$parent_profit,
                                        "type"=>3//Received Money From Affiliation Aboniment
                                    ));

                                    $db->where('id',$parent_user);
                                    $update_user_balance = $db->update('core_users',array(
                                        "balance" => $db->inc($parent_profit)
                                    ));


                                    if($insert_affiliation_transaction && $update_user_balance) {

                                        //$this->saveLog("User $user_id; Generated Profit: $amount; His Parent: $parent_user; Was Credited By Amount: $parent_profit");

                                        $db->commit();
                                    }
                                    else {
                                        //$this->saveLog("Error Happened - User $user_id; Generated Profit: $amount; His Parent: $parent_user; Was Credited By Amount: $parent_profit");

                                        $db->rollback();
                                    }


                                }
                            }
                        }


                    }

                    return [
                        'code'=>10,
                        'msg' => 'Success'
                    ];
                } else {
                    $db->rollback();
                    return [
                        'code'=>-2,
                        'msg' => 'Transaction Failed'
                    ];
                }



            }


        } else {
            return [
                'code'=>20,
                'msg' => 'user not found'
            ];
        }
    }


    public function check(){
        global $db;

        $user = $this->checkUserAccess();

        $affiliate_type = $user['affiliate_type'];


        if($user) {

            //General Partner
            if($affiliate_type == 1 || $affiliate_type == '1') {
                $becomingAffiliationFee = 100000;

                $db->where('user_id',$user['id']);
                $db->where('amount',$becomingAffiliationFee);
                $purchased = $db->getOne('money_affiliate_transactions',"*");
            }
            //Instructor
            elseif ($affiliate_type == 2 || $affiliate_type == '2') {
                $becomingAffiliationFee = 50000;

                $db->where('user_id',$user['id']);
                $db->where('amount',$becomingAffiliationFee);
                $purchased = $db->getOne('money_affiliate_transactions',"*");
            }

            //Normal Affiliate
            else {
                $becomingAffiliationFee = 4000;

                $db->where('user_id',$user['id']);
                $db->where('amount',$becomingAffiliationFee);
                $db->orderBy("id","desc");
                $purchased = $db->getOne('money_affiliate_transactions',"*");

            }


            //Has Purchased Main Fee But Now Needs To Pay Subscription Fee

            if ( $purchased ) {



                //Check Last Subscription Payment
                if($affiliate_type == 1 || $affiliate_type == 2) {

                    //Check If One month have passed after first payment
                    $subscriptionStartedDate = $purchased['created_at'];
                    $subscriptionExpiresDate = Carbon::parse($subscriptionStartedDate)->addDays(30);

                    if($subscriptionExpiresDate<Carbon::now()) {

                        //Check If Payment For Subscription Is Payed
                        $becomingAffiliationFee = 4000;
                        $db->where('user_id',$user['id']);
                        $db->where('amount',$becomingAffiliationFee);
                        $db->orderBy("id","desc");
                        $purchasedSubscription = $db->getOne('money_affiliate_transactions',"*");

                        if(!$purchasedSubscription) {
                            return [
                                'code'=>10,
                                'purchased' => -1,
                                'msg' => 'Purchased but subscription expired'
                            ];
                        }

                        $subscriptionExpiresDateInternal = $purchasedSubscription['created_at'];
                        $subscriptionExpiresDate = Carbon::parse($subscriptionExpiresDateInternal)->addDays(30);
                        if($subscriptionExpiresDate<Carbon::now()) {
                            return [
                                'code'=>10,
                                'purchased' => -1,
                                'msg' => 'Purchased but subscription expired'
                            ];
                        }


                        return [
                            'code'=>10,
                            'purchased' => 1,
                            'msg' => 'Purchased'
                        ];
                    }


                }

                else {
                    $subscriptionStartedDate = $purchased['created_at'];

                    $subscriptionExpiresDate = Carbon::parse($subscriptionStartedDate)->addDays(30);

                    if($subscriptionExpiresDate<Carbon::now()) {
                        return [
                            'code'=>10,
                            'purchased' => -1,
                            'msg' => 'Purchased but subscription expired'
                        ];
                    }

                }


                return [
                    'code'=>10,
                    'purchased' => 1,
                    'msg' => 'Purchased'
                ];



            } else {
                return [
                    'code'=>10,
                    'purchased' => 0,
                    'msg' => 'Not Purchased'
                ];
            }

        } else {
            return [
                'code'=>20,
                'msg' => 'user not found'
            ];
        }
    }


}
