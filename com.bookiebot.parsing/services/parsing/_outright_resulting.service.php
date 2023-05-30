<?php


if (!defined('APP')) {
    die();
}
echo "<pre>";

/**
 * Is Responsible For Betting Data To Get For Example How Many Bets Was Made On Certain Odd
 * Class Bets
 */
class _Outright_resulting extends Service
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
            "SELECT DISTINCT(id) as queue_id, event_id as match_id FROM betting_resulting_queue WHERE status=0 AND type=2"
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


        var_export($updated_matched);
        var_export($update_unmatched);


        return $updated_matched&&$update_unmatched;
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
                                  betting_outright_odds outright_odds
                                WHERE
                                  bets.status=0
                                    AND
                                  bets.betting_outright_odds_id=outright_odds.id
                                    AND
                                  outright_odds.betting_outright_id = $event_id
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

                        $this->saveLog("Update Unmatched BetStatus As NotMatched ReturnedMoneyBack: <br/> Bet_id:".$bet_node['id']);
                        $this->saveLog("Update User balance, Amount:$bet_node[unmatched_amount], User:$bet_node[core_users_id]");

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


                                  outright_odds.status as match_odd_status # 2 - Lost, 3 - WOn

                                FROM
                                    betting_matched_bets matched_bets


                                INNER JOIN
                                  betting_outright_odds outright_odds
                                ON
                                outright_odds.id = matched_bets.odd_id

                                WHERE
                                  matched_bets.event_id = $event_id
                                  AND
                                  matched_bets.settle_status = 0";

        //Raw Query
        $data = $db->rawQuery($qs);

        $updated_status = true;

        if (count($data)) {
            $updated_status = false;

            foreach ($data as $bet_node) {


                $backer_user_id = $bet_node['backer_user_id'];
                $layer_user_id = $bet_node['layer_user_id'];


                //If Layer Won Change 3%
                if($bet_node['match_odd_status'] == 2) {


                    $db->startTransaction();


                    //Update User Balance With Won Amount
                    $db->where("id",$bet_node['layer_user_id']);
                    $commission = $bet_node['back_amount_in_pot']*3/100;
                    $winning_money = $bet_node['betting_pot_amount'] - $commission;
                    $add_balance_to_user = $db->update("core_users",array("balance"=>$db->inc($winning_money)));


                    //Update Loser Bet As Lost, Decrement Profit With Back Amount In POt
                    $db->where('id',$bet_node['back_bet_id']);
                    $update_loser_bet = $db->update("betting_bets",array(
                        "status"=>4,
                        "resulted"=>1,
                        "profit_lose"=>-$bet_node['back_amount_in_pot'],
                        "deducted_commission"=>0
                    ));


                    //Update Winner Bet As Won
                    $db->where("id",$bet_node['lay_bet_id']);
                    $update_winner_bet = $db->update("betting_bets",array(
                        "status"=>3,
                        "resulted"=>1,
                        "profit_lose"=>$winning_money,
                        "deducted_commission"=>$commission
                    ));


                    //Update Matched Bets As Settled
                    $db->where("id",$bet_node['matching_row_id']);
                    $update_matching_row = $db->update("betting_matched_bets",array("settle_status"=>1));



                    $this->saveLog("User Won Lay Bet And received amount:$winning_money, BetMatchingId:$bet_node[matching_row_id]");

                    //Save Info About Commission That We Resulted As Revenue
                    $save_commission_info = $db->insert("betting_commissions",array(
                        "amount"=>$commission,
                        "betting_matched_bets_id"=>$bet_node['matching_row_id'],
                        "winner_bet_id"=>$bet_node['lay_bet_id'],
                        "loser_bet_id"=>$bet_node['back_bet_id']
                    ));


                    //Save Info About Loser and Winner Money Laundring
                    $save_laundring_info = $db->insert("laundring_transfer_between_users",array(
                        "loser_user"=>$backer_user_id,
                        "winer_user"=>$layer_user_id,
                        "amount"=>$winning_money
                    ));


                    if($update_loser_bet && $save_commission_info && $save_laundring_info && $update_winner_bet && $update_matching_row && $add_balance_to_user) {
                        $db->commit();
                        $updated = "Committed!";
                        $updated_status = true;
                        $this->saveLog("Success Update Results For Matching Bet: $bet_node[matching_row_id]!",0,1);
                    }else {
                        echo "Cant Update";
                        echo $db->getLastError();
                        $db->rollback();
                        $updated = "Rollback!";
                        $updated_status = false;
                        $this->saveLog("Cant update: $bet_node[matching_row_id] See Immediately!",0,1);
                    }

                }


                //If Backer Won Charge 5%
                if($bet_node['match_odd_status'] == 3) {
                    $db->startTransaction();

                    //Update User Balance With Won Amount
                    $db->where("id",$bet_node['backer_user_id']);
                    $commission = $bet_node['lay_amount_in_pot']*5/100;
                    $winning_money = $bet_node['betting_pot_amount'] - $commission;
                    $add_balance_to_user = $db->update("core_users",array("balance"=>$db->inc($winning_money)));
                    $this->saveLog("User Won Back Bet And received amount:$winning_money, BetMatchingId:$bet_node[matching_row_id]");

                    //Update Back As Winner, And Increase Profit pot amount
                    $db->where('id',$bet_node['back_bet_id']);
                    $update_loser_bet = $db->update("betting_bets",array(
                        "status"=>3,
                        "resulted"=>1,
                        "profit_lose"=>$winning_money,
                        "deducted_commission"=>$commission
                    ));

                    //Update Lay As Loser, And Decrease Profit
                    $db->where("id",$bet_node['lay_bet_id']);
                    $update_winner_bet = $db->update("betting_bets",array(
                        "status"=>4,
                        "resulted"=>1,
                        "profit_lose"=>(0-$bet_node['lay_amount_in_pot']),
                        "deducted_commission"=>0
                    ));


                    //Update Matched Bets As Settled
                    $db->where("id",$bet_node['matching_row_id']);
                    $update_matching_row = $db->update("betting_matched_bets",array("settle_status"=>1));




                    //Insert Commission Info
                    $save_commission_info = $db->insert("betting_commissions",array(
                        "amount"=>$commission,
                        "betting_matched_bets_id"=>$bet_node['matching_row_id'],
                        "winner_bet_id"=>$bet_node['back_bet_id'],
                        "loser_bet_id"=>$bet_node['lay_bet_id']
                    ));



                    //Save Info About Loser and Winner Money Laundring
                    $save_laundring_info = $db->insert("laundring_transfer_between_users",array(
                        "loser_user"=>$backer_user_id,
                        "winer_user"=>$layer_user_id,
                        "amount"=>$winning_money
                    ));



                    if($update_loser_bet && $update_winner_bet && $save_laundring_info && $save_commission_info && $update_matching_row && $add_balance_to_user) {
                        $db->commit();
                        $updated = "Committed!";
                        $updated_status = true;
                        $this->saveLog("Success Update Results For Matching Bet: $bet_node[matching_row_id]!",0,1);
                    }
                    else {
                        $db->rollback();
                        $updated = "Rollback!";
                        $updated_status = false;
                        $this->saveLog("Cant update: $bet_node[matching_row_id] See Immediately!",0,1);
                    }
                }



                //Check Unmatched Amounts For Back And Lay Bets
                $db->where("id",$bet_node['back_bet_id']);
                $back_data = $db->getOne("betting_bets","unmatched_amount,core_users_id");
                if(isset($back_data['unmatched_amount'])) {
                    if($back_data['unmatched_amount']>0) {
                        $db->startTransaction();


                        //Return Money
                        $db->where("id",$back_data['core_users_id']);
                        $return_unmatched_to_layer = $db->update("core_users",array("balance"=>$db->inc($back_data['unmatched_amount'])));

                        //Make Unmatched Zero
                        $db->where('id',$bet_node['back_bet_id']);
                        $make_unmatched_zero = $db->update("betting_bets",array("unmatched_amount"=>0,"returned_unmatched_amount"=>$back_data['unmatched_amount']));



                        if($return_unmatched_to_layer && $make_unmatched_zero) {
                            $db->commit();
                            $this->saveLog("With back matched bet, User:".$back_data['core_users_id'].", Refunded Unmatched Amount: ".$back_data['unmatched_amount']);
                        } else {
                            $this->saveLog("Cant Returned Unmatched And Make Amount in bet ZERO - Backer Bet");
                            $db->rollback();
                        }

                    }
                }


                //If Layer Had Left Unmatched Part We Return On User Account Back
                $db->where("id",$bet_node['lay_bet_id']);
                $lay_data = $db->getOne("betting_bets","unmatched_amount,core_users_id");
                if(isset($lay_data['unmatched_amount'])) {
                    if($lay_data['unmatched_amount']>0) {
                        $db->startTransaction();


                        //Return Money
                        $db->where("id",$lay_data['core_users_id']);
                        $return_unmatched_to_layer = $db->update("core_users",array("balance"=>$db->inc($lay_data['unmatched_amount'])));

                        //Make Unmatched Zero
                        $db->where('id',$bet_node['lay_bet_id']);
                        $make_unmatched_zero = $db->update("betting_bets",array("unmatched_amount"=>0,"returned_unmatched_amount"=>$lay_data['unmatched_amount']));

                        if($return_unmatched_to_layer && $make_unmatched_zero) {
                            $db->commit();
                            $this->saveLog("With lay matched bet, User:".$lay_data['core_users_id'].", Refunded Unmatched Amount: ".$lay_data['unmatched_amount']);
                        } else {
                            $this->saveLog("Cant Returned Unmatched And Make Amount in bet ZERO - Backer Bet");
                            $db->rollback();
                        }

                    }
                }



            }
        }

        return $updated_status;



    }



}