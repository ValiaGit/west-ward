<?php


if (!defined('APP')) {
    die();
}
echo "<pre>";

/**
 * Is Responsible For Betting Data To Get For Example How Many Bets Was Made On Certain Odd
 * Class Bets
 */
class _Resulting extends Service
{


    /**
     * Save Results For Matches That are ion resulting queue
     */
    public function result()
    {

        //Database Object
        $db = $this->db;

        //Get Resulting Queue
        $result_queue = $db->rawQuery(
            "SELECT DISTINCT(id) as queue_id, event_id as match_id FROM betting_resulting_queue WHERE status=0 AND type=1"
        );


        //Iterate Over Resulting Queue
        foreach ($result_queue as $match) {

            $queue_id = $match['queue_id'];
            $match_id = $match['match_id'];

            //Save Result On Match
            $save_results = $this->saveResults($match_id, $queue_id);

            //If Results Where Saved Successfully Delete Match Resulting Queue
            if ($save_results) {
                $db->where("id", $queue_id);
                echo $db->update("betting_resulting_queue", array("status" => 1));
            }

        }

    }


    /**
     * @param $match_id
     * @param $queue_id
     * @return array
     */
    private function saveResults($match_id, $queue_id)
    {

        //Save Results For Match Odds That Had Matched Bets
        $updated_matched = $this->saveMatchedBetResults($match_id);

        //Settle Bets That Where Not Matched And Return Money Back Status=0
        $update_unmatched = $this->saveUnmatchedBetResults($match_id);


        var_dump($updated_matched);
        var_dump($update_unmatched);


        return $updated_matched && $update_unmatched;
    }


    /**
     *
     * @param $event_id
     * @return array
     */
    private function saveUnmatchedBetResults($event_id)
    {

        $db = $this->db;

        //Raw Query
        $data = $db->rawQuery("
                                SELECT
                                  bets.id,
                                  bets.unmatched_amount,
                                  bets.core_users_id
                                FROM
                                  betting_bets bets,
                                  betting_match_odds match_odds
                                WHERE
                                  bets.status=0
                                    AND
                                  bets.betting_match_odds_id=match_odds.id
                                    AND
                                  match_odds.betting_match_id = $event_id
                              ");

        $updated_status = true;

        if (count($data)) {
            $updated_status = false;

            $db->startTransaction();

            foreach ($data as $bet_node) {

                $db->where("id", $bet_node['id']);

                $updated_bet_as_returned = $db->update("betting_bets", array("status" => 10, "unmatched_amount" => 0));
                if ($updated_bet_as_returned !== false) {

                    //Return money back
                    $db->where("id", $bet_node['core_users_id']);
                    $update_user_balance = $db->update("core_users", array("balance" => $db->inc($bet_node['unmatched_amount'])));
                    if ($update_user_balance !== false) {

                        $this->saveLog("Update Unmatched BetStatus As NotMatched ReturnedMoneyBack: <br/> Bet_id:" . $bet_node['id']);
                        $this->saveLog("Update UnMatched User balance, UnmatchedBetId:$bet_node[id], Amount:$bet_node[unmatched_amount], User:$bet_node[core_users_id]");

                        $db->commit();
                        $updated = "Committed!";
                        $updated_status = true;
                    } else {
                        $db->rollback();
                        $updated = "Rollback!";
                        $updated_status = false;
                    }
                }

            }
        }

        return $updated_status;

    }


    /**
     *
     * @param $event_id
     * @return array
     */
    private function saveMatchedBetResults($event_id)
    {

        $db = $this->db;
        $event_id = (int)$event_id;

        $qs = "SELECT
                                  matched_bets.id as matching_row_id,

                                  matched_bets.betting_lay_id  as lay_bet_id,
                                  matched_bets.betting_back_id as back_bet_id,


                                  matched_bets.back_amount_in_pot as back_amount_in_pot,
                                  matched_bets.lay_amount_in_pot as lay_amount_in_pot,


                                  matched_bets.betting_pot_amount,


                                  matched_bets.backer_user_id,
                                  matched_bets.layer_user_id,


                                  match_odds.status as match_odd_status # 2 - Lost, 3 - WOn

                                FROM
                                    betting_matched_bets matched_bets


                                INNER JOIN
                                  betting_match_odds match_odds
                                ON
                                match_odds.id = matched_bets.odd_id

                                WHERE
                                  matched_bets.event_id = $event_id
                                  AND
                                  matched_bets.settle_status = 0";

        //Raw Query
        $data = $db->rawQuery($qs);

        $updated_status = true;

        if (count($data)) {
            $updated_status = false;
            echo "Started<br/>";
            foreach ($data as $bet_node) {


                $backer_user_id = $bet_node['backer_user_id'];
                $layer_user_id = $bet_node['layer_user_id'];


                //If Layer Won Change 3%
                if ($bet_node['match_odd_status'] == 2) {


                    $db->startTransaction();


                    //Update User Balance With Won Amount
                    $db->where("id", $bet_node['layer_user_id']);
                    $commission = $bet_node['back_amount_in_pot'] * 3 / 100;
                    $winning_money = $bet_node['betting_pot_amount'] - $commission;
                    $add_balance_to_user = $db->update("core_users", array("balance" => $db->inc($winning_money)));

                    $this->saveLog("User:$bet_node[layer_user_id], Won Lay Bet And received amount:$winning_money, BetMatchingId:$bet_node[matching_row_id]");


                    //Update Loser Bet As Lost, Decrement Profit With Back Amount In Pot
                    $loser_update = array(
                        "status" => 4,
                        "resulted" => 1,
                        "profit_lose" => -$bet_node['back_amount_in_pot'],
                        "deducted_commission" => 0
                    );

                    $balance_after_settlement = 0;
                    $db->where('id', $bet_node['backer_user_id']);
                    $user_balance_updated = $db->getOne("core_users", 'balance');
                    if ($user_balance_updated) {
                        $balance_after_settlement = $user_balance_updated['balance'];
                    }

                    if ($balance_after_settlement) {
                        $loser_update['balance_after_settlement'] = $balance_after_settlement;
                    }

                    $db->where('id', $bet_node['back_bet_id']);
                    $update_loser_bet = $db->update("betting_bets", $loser_update);


                    //Update Winner Bet As Won
                    $balance_after_settlement = 0;
                    $db->where('id', $bet_node['layer_user_id']);
                    $user_balance_updated = $db->getOne("core_users", 'balance');
                    if ($user_balance_updated) {
                        $balance_after_settlement = $user_balance_updated['balance'];
                    }

                    $bt_update = array(
                        "status" => 3,
                        "resulted" => 1,
                        "profit_lose" => $winning_money,
                        "deducted_commission" => $commission
                    );

                    if ($balance_after_settlement) {
                        $bt_update['balance_after_settlement'] = $balance_after_settlement;
                    }

                    $db->where("id", $bet_node['lay_bet_id']);
                    $update_winner_bet = $db->update("betting_bets", $bt_update);


                    //Update Matched Bets As Settled
                    $db->where("id", $bet_node['matching_row_id']);
                    $update_data = array("settle_status" => 1);
                    $update_matching_row = $db->update("betting_matched_bets", $update_data);


                    //Save Info About Commission That We Resulted As Revenue
                    $save_commission_info = $db->insert("betting_commissions", array(
                        "amount" => $commission,
                        "betting_matched_bets_id" => $bet_node['matching_row_id'],
                        "winner_bet_id" => $bet_node['lay_bet_id'],
                        "loser_bet_id" => $bet_node['back_bet_id']
                    ));


                    //This Amount is considered As Net Profit After Taxes
                    //We Assume this Amount is Affiliate Made Proft For Us
                    $net_revenue = $commission * 90 / 100;
                    $this->depositMoneyIfAffiliateMadeProfitForUs($bet_node['backer_user_id'],$net_revenue,$bet_node['matching_row_id'],1);

                    //Save Info About Loser and Winner Money Laundring
                    $save_laundring_info = $db->insert("laundring_transfer_between_users", array(
                        "loser_user" => $backer_user_id,
                        "winer_user" => $layer_user_id,
                        "amount" => $winning_money
                    ));


                    if ($update_loser_bet && $save_commission_info && $save_laundring_info && $update_winner_bet && $update_matching_row && $add_balance_to_user) {
                        $db->commit();
                        $updated = "Committed!";
                        $updated_status = true;
                        $this->saveLog("Success Update Results For Matching Bet: $bet_node[matching_row_id]!", 0, 1);
                    } else {
                        echo "Cant Update";
                        echo $db->getLastError();
                        $db->rollback();
                        $updated = "Rollback!";
                        $updated_status = false;
                        $this->saveLog("Cant update: $bet_node[matching_row_id] See Immediately!", 0, 1);
                    }

                }


                //If Backer Won Charge 5%
                if ($bet_node['match_odd_status'] == 3) {
                    $db->startTransaction();

                    //Update User Balance With Won Amount
                    $db->where("id", $bet_node['backer_user_id']);
                    $commission = $bet_node['lay_amount_in_pot'] * 5 / 100;
                    $winning_money = $bet_node['betting_pot_amount'] - $commission;
                    $add_balance_to_user = $db->update("core_users", array("balance" => $db->inc($winning_money)));
                    $this->saveLog("User:$bet_node[backer_user_id], Won Back Bet And received Amount:$winning_money, BetMatchingId:$bet_node[matching_row_id]");


                    //Update Back As Winner, And Increase Profit pot amount


                    $balance_after_settlement = 0;
                    $db->where('id', $bet_node['backer_user_id']);
                    $user_balance_updated = $db->getOne("core_users", 'balance');
                    if ($user_balance_updated) {
                        $balance_after_settlement = $user_balance_updated['balance'];
                    }

                    $bt_data = array(
                        "status" => 3,
                        "resulted" => 1,
                        "profit_lose" => $winning_money,
                        "deducted_commission" => $commission
                    );

                    if ($balance_after_settlement) {
                        $bt_data['balance_after_settlement'] = $balance_after_settlement;
                    }

                    $db->where('id', $bet_node['back_bet_id']);
                    $update_winner_bet = $db->update("betting_bets", $bt_data);


                    //Update Lay As Loser, And Decrease Profit

                    //Update Balance For Loser User

                    $balance_after_settlement = 0;
                    $db->where('id', $bet_node['layer_user_id']);
                    $user_balance_updated = $db->getOne("core_users", 'balance');
                    if ($user_balance_updated) {
                        $balance_after_settlement = $user_balance_updated['balance'];
                    }
                    $loser_update_data = array(
                        "status" => 4,
                        "resulted" => 1,
                        "profit_lose" => (0 - $bet_node['lay_amount_in_pot']),
                        "deducted_commission" => 0
                    );
                    if ($balance_after_settlement) {
                        $loser_update_data['balance_after_settlement'] = $balance_after_settlement;
                    }

                    $db->where("id", $bet_node['lay_bet_id']);
                    $update_loser_bet = $db->update("betting_bets", $loser_update_data);


                    //Update Matched Bets As Settled
                    $db->where("id", $bet_node['matching_row_id']);
                    $update_data = array("settle_status" => 1);

                    $update_matching_row = $db->update("betting_matched_bets", $update_data);


                    //Insert Commission Info
                    $save_commission_info = $db->insert("betting_commissions", array(
                        "amount" => $commission,
                        "betting_matched_bets_id" => $bet_node['matching_row_id'],
                        "winner_bet_id" => $bet_node['back_bet_id'],
                        "loser_bet_id" => $bet_node['lay_bet_id']
                    ));


                    //This Amount is considered As Net Profit After Taxes
                    //We Assume this Amount is Affiliate Made Proft For Us
                    $net_revenue = $commission * 90 / 100;
                    $this->depositMoneyIfAffiliateMadeProfitForUs($bet_node['layer_user_id'],$net_revenue,$bet_node['matching_row_id'],1);


                    //Save Info About Loser and Winner Money Laundring
                    $save_laundring_info = $db->insert("laundring_transfer_between_users", array(
                        "loser_user" => $backer_user_id,
                        "winer_user" => $layer_user_id,
                        "amount" => $winning_money
                    ));


                    if ($update_loser_bet && $update_winner_bet && $save_laundring_info && $save_commission_info && $update_matching_row && $add_balance_to_user) {
                        $db->commit();
                        $updated = "Committed!";
                        $updated_status = true;
                        $this->saveLog("Success Update Results For Matching Bet: $bet_node[matching_row_id]!", 0, 1);
                    } else {
                        $db->rollback();
                        $updated = "Rollback!";
                        $updated_status = false;
                        $this->saveLog("Cant update: $bet_node[matching_row_id] See Immediately!", 0, 1);
                    }
                }


                //Check Unmatched Amounts For Back And Lay Bets
                $db->where("id", $bet_node['back_bet_id']);
                $back_data = $db->getOne("betting_bets", "unmatched_amount,core_users_id");
                if (isset($back_data['unmatched_amount'])) {
                    if ($back_data['unmatched_amount'] > 0) {
                        $db->startTransaction();


                        //Return Money
                        $db->where("id", $back_data['core_users_id']);
                        $return_unmatched_to_layer = $db->update("core_users", array("balance" => $db->inc($back_data['unmatched_amount'])));

                        //Make Unmatched Zero
                        $balance_after_settlement = 0;
                        $db->where('id', $bet_node['backer_user_id']);
                        $user_balance_updated = $db->getOne("core_users", 'balance');
                        if ($user_balance_updated) {
                            $balance_after_settlement = $user_balance_updated['balance'];
                        }


                        $update_data = array(
                            "unmatched_amount" => 0,
                            "returned_unmatched_amount" => $back_data['unmatched_amount']
                        );

                        if ($balance_after_settlement) {
                            $update_data['balance_after_settlement'] = $balance_after_settlement;
                        }

                        $db->where('id', $bet_node['back_bet_id']);
                        $make_unmatched_zero = $db->update("betting_bets", $update_data);


                        if ($return_unmatched_to_layer && $make_unmatched_zero) {
                            $db->commit();
                            echo "With back matched bet, User:" . $back_data['core_users_id'] . ", Refunded Unmatched Amount: " . $back_data['unmatched_amount'] . "<br/>";
                            $this->saveLog("With back matched bet, User:" . $back_data['core_users_id'] . ", Refunded Unmatched Amount: " . $back_data['unmatched_amount']);
                        } else {
                            echo "Cant Returned Unmatched And Make Amount in bet ZERO - Backer Bet<br/>";
                            $this->saveLog("Cant Returned Unmatched And Make Amount in bet ZERO - Backer Bet");
                            $db->rollback();
                        }

                    }
                }


                //If Layer Had Left Unmatched Part We Return On User Account Back
                $db->where("id", $bet_node['lay_bet_id']);
                $lay_data = $db->getOne("betting_bets", "unmatched_amount,core_users_id");
                if (isset($lay_data['unmatched_amount'])) {
                    if ($lay_data['unmatched_amount'] > 0) {
                        $db->startTransaction();


                        //Return Money
                        $db->where("id", $lay_data['core_users_id']);
                        $return_unmatched_to_layer = $db->update("core_users", array("balance" => $db->inc($lay_data['unmatched_amount'])));

                        //Make Unmatched Zero

                        $balance_after_settlement = 0;
                        $db->where('id', $bet_node['lay_bet_id']);
                        $user_balance_updated = $db->getOne("core_users", 'balance');
                        if ($user_balance_updated) {
                            $balance_after_settlement = $user_balance_updated['balance'];
                        }

                        $update_data = array("unmatched_amount" => 0, "returned_unmatched_amount" => $lay_data['unmatched_amount']);
                        if ($balance_after_settlement) {
                            $update_data['balance_after_settlement'] = $balance_after_settlement;
                        }

                        $db->where('id', $bet_node['lay_bet_id']);
                        $make_unmatched_zero = $db->update("betting_bets", $update_data);

                        if ($return_unmatched_to_layer && $make_unmatched_zero) {
                            $db->commit();
                            $this->saveLog("With lay matched bet, User:" . $lay_data['core_users_id'] . ", Refunded Unmatched Amount: " . $lay_data['unmatched_amount']);
                        } else {
                            $this->saveLog("Cant Returned Unmatched And Make Amount in bet ZERO - Backer Bet");
                            $db->rollback();
                        }

                    }
                }


            }

        } else {
            echo "No Count";
        }

        return $updated_status;


    }


    /**
     * @param $user_id
     * @param $amount
     * @param $transaction_id
     * @param int $product_id
     */
    private function depositMoneyIfAffiliateMadeProfitForUs($user_id, $amount, $transaction_id = 0, $product_id = 1)
    {

        $db = $this->db;


        // The data to send to the API
        $postData = array(
            'user_id' => $user_id,
            'product_id' => $product_id,
            'amount' => $amount,
            'transaction_id' => $transaction_id,
            'hash' => hash('sha256',"$user_id$product_id$amount$transaction_id"."iXvniskarta saaxalwlo sufraze")
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

        // Check for errors
        if ($response === FALSE) {
            die(curl_error($ch));
        }



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
                        "type"=>4//From betExchange Activity Of Child
                    ));

                    $db->where('id',$parent_user);
                    $update_user_balance = $db->update('core_users',array(
                            "balance" => $db->inc($parent_profit)
                    ));


                    if($insert_affiliation_transaction && $update_user_balance) {

                        $this->saveLog("User $user_id; Generated Profit: $amount; His Parent: $parent_user; Was Credited By Amount: $parent_profit");

                        $db->commit();
                    }
                    else {
                        $this->saveLog("Error Happened - User $user_id; Generated Profit: $amount; His Parent: $parent_user; Was Credited By Amount: $parent_profit");

                        $db->rollback();
                    }


                }
            }
        }
    }



    private function checkHasAffiliationFeePayed($user_id) {

        global $db;

        $db->where('id',$user_id);
        $affiliate_type = $db->getOne("core_users", 'affiliate_type');
        $affiliate_type = $affiliate_type['affiliate_type'];

        //Check If User Has Payed 40 Euros of subscription then deposit otherwise
        //General Partner
        if($affiliate_type == 1 || $affiliate_type == '1') {
            $becomingAffiliationFee = 100000;
            $db->where('user_id',$user_id);
            $db->where('amount',$becomingAffiliationFee);
            $purchased = $db->getOne('money_affiliate_transactions',"*");
        }
        //Instructor
        elseif ($affiliate_type == 2 || $affiliate_type == '2') {
            $becomingAffiliationFee = 50000;

            $db->where('user_id',$user_id);
            $db->where('amount',$becomingAffiliationFee);
            $purchased = $db->getOne('money_affiliate_transactions',"*");
        }

        //Normal Affiliate
        else {
            $becomingAffiliationFee = 4000;

            $db->where('user_id',$user_id);
            $db->where('amount',$becomingAffiliationFee);
            $db->orderBy("id","desc");
            $purchased = $db->getOne('money_affiliate_transactions',"*");

        }

        if ( $purchased ) {



            //Check Last Subscription Payment
            if($affiliate_type == 1 || $affiliate_type == 2) {

                //Check If One month have passed after first payment
                $subscriptionStartedDate = $purchased['created_at'];
                $subscriptionExpiresDate = \Carbon\Carbon::parse($subscriptionStartedDate)->addDays(30);

                if($subscriptionExpiresDate<\Carbon\Carbon::now()) {

                    //Check If Payment For Subscription Is Payed
                    $becomingAffiliationFee = 4000;
                    $db->where('user_id',$user_id);
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
                    $subscriptionExpiresDate = \Carbon\Carbon::parse($subscriptionExpiresDateInternal)->addDays(30);
                    if($subscriptionExpiresDate<\Carbon\Carbon::now()) {
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

                $subscriptionExpiresDate = \Carbon\Carbon::parse($subscriptionStartedDate)->addDays(30);

                if($subscriptionExpiresDate<\Carbon\Carbon::now()) {
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



        }
    }

}