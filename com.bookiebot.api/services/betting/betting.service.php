<?php


if (!defined('APP')) {
    die();
}


use Carbon\Carbon;


class Betting extends Service
{

    /**
     * @param $user_id
     * @param $from_date
     */
    private function checkAlreadyLostAmountForPeriod($user_id,$from_date) {
        $user_id = (int)$user_id;

        $db = $this->db;
        $query_string = "SELECT SUM(bet_amount) as total_bets_amount FROM betting_bets WHERE status=4 AND core_users_id=$user_id AND bets_date>='$from_date'";
        $data = $db->rawQuery($query_string);
        if(count($data)) {
            return array("code"=>10,"amount"=>$data[0]['total_bets_amount']!=null?$data[0]['total_bets_amount']:0);
        } else {
            return array("code"=>60);
        }

    }


    /**
     * @param $user_id
     * @param $from_date
     * @return array
     */
    private function checkAlreadyBetAmountForPeriod($user_id,$from_date) {
        $user_id = (int)$user_id;

        $db = $this->db;
        $query_string = "SELECT SUM(bet_amount) as total_bets_amount FROM betting_bets WHERE core_users_id=$user_id AND bets_date>='$from_date'";
        $data = $db->rawQuery($query_string);
        if(count($data)) {
            return array("code"=>10,"amount"=>$data[0]['total_bets_amount']!=null?$data[0]['total_bets_amount']:0);
        } else {
            return array("code"=>60);
        }



    }

    /**
     * Place Bet Gets Bettings As Array
     * odds = [
     *              {
     *                  match_id:1,
     *                  odd_id:1,
     *                  bet_amount:1,
     *                  bet_odd:1,
     *                  bet_type:1,
     *                  type: 1 or 2 or 3
     *              },
     *              {
     *                  match_id:1,
     *                  odd_id:1,
     *                  bet_amount:1,
     *                  bet_odd:1,
     *                  bet_type:1,
     *                  type: 1 or 2 or 3
     *              },
     *              {
     *                  match_id:1,
     *                  odd_id:1,
     *                  bet_amount:1,
     *                  bet_odd:1,
     *                  bet_type:1,
     *                  type: 1 or 2 or 3
     *              }
     *       ]
     * @param $odds
     * @return array
     */
    public function placeBet($odds = array())
    {

        global $langPackage;

        if (!count($odds)) {
            return array("code" => 50);
        }


        $user_data = $this->checkUserAccess();

        if ($user_data) {
            $user_id = $user_data['id'];

            $session_id = isset($user_data['grantSession'])?$user_data['grantSession']:false;

            $db = $this->db;

            $ip = ip2long(IP);


            $total_bets_amount = 0;
            foreach ($odds as $bet) {

                $bet_type = (int)$bet['bet_type'];
                $bet_odd = (float)$bet['bet_odd'];
                $bet_amount = (float)$bet['bet_amount'] * 100;

                $total_bets_amount += $this->calculateNeededBalanceForBet($bet_type, $bet_amount, $bet_odd);
            }

            $session_data = $this->loadService("user/session")->checkSession();
            $is_email_confirmed = $session_data['user']['is_email_confirmed'];

            //If Email Isn't Confirmed Cant Make Bet
            if (!$is_email_confirmed) {
                return array("code" => -11, "msg" => $langPackage['please_confirm_email_to_make_bets']);
            }

            $this->Log("Place bet requested!", $odds);

            //Check if user is protected with timeout or self exclusion
            $protection_service = $this->loadService("user/protection");
            $protections = $protection_service->_checkProtection($user_id);
            if ($protections['has_protections'] == 1) {
                //Time Out
                if (isset($protections['protections'][1])) {
                    return array("code" => -75, "expires" => $protections['protections'][1]['expire_date'], "msg" => "Your account has time out protection!");
                }
                //Self Exclusion
                if (isset($protections['protections'][3])) {
                    return array("code" => -85, "expires" => $protections['protections'][3]['expire_date'], "msg" => "You are self excluded!");
                }


                //If User Has Bets Limit
                if (isset($protections['protections'][5])) {



                    //Amount Limit
                    $limit_amount = $protections['protections'][5]['amount'];
                    $limit_create_time = $protections['protections'][5]['create_time'];

                    //Check Lost Tickets Amount
                    $already_made_bets = $this->checkAlreadyBetAmountForPeriod($user_id,$limit_create_time);
                    if($already_made_bets['code'] !=10) {
                        return array("code"=>50,"msg"=>"General Error");
                    }


                    if(($already_made_bets['amount']+$total_bets_amount)>$limit_amount) {
                        $available_bet_amount = $limit_amount - $already_made_bets['amount'];
                        $amount_in_message = round($available_bet_amount/100,2);
                        if($amount_in_message<0) {
                            $amount_in_message = 0;
                        }
                        return array("code" => -85, "available_amount"=>$available_bet_amount, "expires" => $protections['protections'][5]['expire_date'], "msg" => "You have bets limit, which protects you to make bets!<br/>Available bet amount is: $amount_in_message €");
                    }

                }

                //If User Has Losing Limit
                if (isset($protections['protections'][4])) {

                    //Amount Limit
                    $limit_amount = $protections['protections'][4]['amount'];
                    $limit_create_time = $protections['protections'][4]['create_time'];


                    //Check Lost Tickets Amount
                    $already_lost_bets = $this->checkAlreadyLostAmountForPeriod($user_id,$limit_create_time);
                    if($already_lost_bets['code'] !=10) {
                        return array("code"=>50,"msg"=>"General Error");
                    }


                    if(($already_lost_bets['amount']+$total_bets_amount)>$limit_amount) {
                        $available_bet_amount = $limit_amount - $already_lost_bets['amount'];
                        $amount_in_message = round($available_bet_amount/100,2);
                        return array("code" => -85, "available_amount"=>$available_bet_amount,"data"=>$already_lost_bets, "expires" => $protections['protections'][4]['expire_date'], "msg" => "You have losing amount limit for specific periods of time, which protects you to make bet!<br/>Available bet amount is: $amount_in_message €");
                    }
                }
            }

            //Object To be Responded to client
            $response = array(
                "code" => 10,
                "success" => array(),
                "errors" => array()
            );

            //Iterate Over All Bets Tha
            foreach ($odds as $bet) {




                $odd_id = (int)$bet['odd_id'];

                $type = (int)$bet['type'];
                $bet_odd = (float)$bet['bet_odd'];
                $bet_amount = (float)$bet['bet_amount'] * 100;
                $bet_type = (int)$bet['bet_type'];

                $bet_receivers = isset($bet['bet_receivers']) ? (array)$bet['bet_receivers'] : false;

                $is_od_available = $this->IsOddAvailable($odd_id, $type);


                $event_id = $is_od_available;


                //Check For Collusion
                $date_now = Carbon::now();
                $twenty_four = $date_now->subHours(24)->toDateTimeString();

                /***
                 *
                 ***/
                $qs = "SELECT COUNT(DISTINCT(core_users_id)) as cnt FROM collusion_monitor WHERE ip=$ip AND affected_odd_id=$odd_id AND  action_date>='$twenty_four'";
                $check_collusion = $db->rawQuery($qs);
                $collusion_count = 0;
                if(count($check_collusion)) {
                    $collusion_count = $check_collusion[0]['cnt'];
                }

                if($collusion_count>=5) {
                    array_push($response['errors'], array(
                        "id" => $odd_id,
                        "errCode" => 408,
                        "msg" => "Detected Bet Collusion! Your wager was not accepted! Please contact help center!"
                    ));
                }

                else {
                    if ($odd_id && $bet_odd && $bet_amount && $bet_type) {

                        //Check If Match And Odd Is Available
                        if ($is_od_available) {

                            //This Returns Liability Or Bet Stake
                            $needed_balance_for_bet = $this->calculateNeededBalanceForBet($bet_type, $bet_amount, $bet_odd);

                            $session_service = $this->loadService("user/session");
                            $getBalance = $session_service->getBalance();
                            if ($getBalance['code'] == 10) {


                                if ($getBalance['balance'] >= $needed_balance_for_bet) {
                                    $db->startTransaction();

                                    $db->where("id", $user_id);
                                    $cutBalance = $db->update("core_users", array(
                                        'balance' => $db->dec($needed_balance_for_bet)
                                    ));


                                    /**
                                     *
                                     */
                                    $insert_bet_data = array(
                                        "core_users_id" => $user_id,
                                        "bet_type" => $bet_type,
                                        "is_private" => 0,
                                        "bet_amount" => $bet_amount,
                                        "bet_odd" => $bet_odd,
                                        "balance_before_bet"=>$getBalance['balance']
                                    );


                                    if(isset($session_id)) {
                                        if($session_id) {
                                            $insert_bet_data['session_id'] = $session_id;
                                        }
                                    }


                                    //If Bet Type Was Prematch Odd
                                    if ($type == 1) {
                                        $insert_bet_data['betting_match_odds_id'] = $odd_id;
                                        $insert_bet_data['type'] = 1;
                                    } //If BetType Was Outright Odd
                                    else if ($type == 2) {
                                        $insert_bet_data['betting_outright_odds_id'] = $odd_id;
                                        $insert_bet_data['type'] = 2;
                                    } //Bet Time Is Live
                                    else if ($type == 3) {
                                        $insert_bet_data['betting_live_odds_id'] = $odd_id;
                                        $insert_bet_data['type'] = 3;
                                    }


                                    //Calculate Lay Unmatched Amount
                                    if ($bet_type == 1) {
                                        $insert_bet_data['unmatched_amount'] = ($bet_odd * $bet_amount) - $bet_amount;
                                    } //Calculate Back Unmatched Amount
                                    else {
                                        $insert_bet_data['unmatched_amount'] = $bet_amount;
                                    }

                                    //Insert Odd In Database
                                    $inserted_bet_id = $db->insert("betting_bets", $insert_bet_data);



                                    $save_collusion_data = $db->insert("collusion_monitor", array(
                                        "ip"=>$ip,
                                        "core_users_id"=>$user_id,
                                        "affected_odd_id"=>$odd_id
                                    ));


                                    if ($inserted_bet_id && $cutBalance && $save_collusion_data) {

                                        //This Parameters Are Used To Find And Match Bet
                                        $ParamsForMatchMethod = array(
                                            "odd_id" => $odd_id,
                                            "bet_odd" => $bet_odd,
                                            "bet_amount" => $bet_amount,
                                            "bet_type" => $bet_type,
                                            "insert_bet_id" => $inserted_bet_id,
                                            "user_id" => $user_id,
                                            "event_id" => $event_id,
                                            "type" => $type
                                        );



                                        /**
                                         * If Sent In Private Mode
                                         */
//                                    print_r($bet_receivers);
                                        if ($bet_receivers) {
                                            if (count($bet_receivers)) {
                                                //If bBet Receiver Was Provided Check FriendShip
                                                $friends_service = $this->loadService("social/friends");
                                                foreach ($bet_receivers as $bet_receiver_id) {

                                                    $friendship = $friends_service->checkFriendShip($bet_receiver_id);

                                                    if ($friendship['code'] == 10) {
                                                        $saved_bet_send_response = $this->save_private_bet($inserted_bet_id, $bet_receiver_id, $user_id);

                                                        if ($saved_bet_send_response['code'] == 10) {
                                                            $db->where("id", $inserted_bet_id);
                                                            $db->update("betting_bets", array("is_private" => 1));

                                                        }
                                                    }
                                                }
                                            }
                                        }


                                        //Check If Matching Exists And save relationship
                                        $matched = $this->checkMatching($ParamsForMatchMethod);

                                        /**
                                         *
                                         */
                                        if (!$matched) {
                                            $matched = array("code" => 411, "message" => "not matched");
                                        }


                                        array_push($response['success'], array(
                                            "id" => $odd_id,
                                            "type" => $bet_type,
                                            "matched" => $matched,
                                            "code" => 10
                                        ));
                                        $db->commit();

                                    } else {
                                        if (!$cutBalance) {
                                            array_push($response['errors'], array(
                                                "id" => $odd_id,
                                                "errCode" => 401
                                            ));
                                        }
                                        $db->rollback();
                                    }
                                } else {
                                    array_push($response['errors'], array(
                                        "id" => $odd_id,
                                        "errCode" => 424,
                                        "msg" => "Don't have enough balance!"
                                    ));
                                }

                            } else {
                                array_push($response['errors'], array(
                                    "id" => $odd_id,
                                    "errCode" => 424,
                                    "msg" => "Cant detect balance!"
                                ));
                            }


                        } else {
                            array_push($response['errors'], array(
                                "id" => $odd_id,
                                "errCode" => 402,
                                "msg" => "Odd isn;t open for receiving bets"
                            ));
                        }
                    }

                    else {
                        array_push($response['errors'], array(
                            "id" => $odd_id,
                            "errCode" => 404,
                            "msg" => "Wrong Request"
                        ));
                    }
                }





            }

            return $response;


        } else {
            //http_response_code(401);
            return array("code" => 40);
        }
    }


    /**
     * @param $inserted_bet_id
     * @param $friend_id
     * @param $sender_id
     * @return array
     */
    private function save_private_bet($inserted_bet_id, $friend_id, $sender_id)
    {
        $inserted_bet_id = (int)$inserted_bet_id;
        $friend_id = (int)$friend_id;
        $sender_id = (int)$sender_id;

        $db = $this->db;
        $insert_id = $db->insert("core_users_has_betting_bets", array(
            "receiver_users_id" => $friend_id,
            "betting_bets_id" => $inserted_bet_id,
            "sender_users_id" => $sender_id
        ));

        //If Inserted Successfully
        if ($insert_id !== false) {
            return array("code" => 10);
        } else {
            return array("code" => 30);
        }

    }


    /**
     *
     */
    public function sms()
    {
        $db = $this->db;
        $db->where("has_sms", 0);
        $data = $db->get("core_users_has_betting_bets", null, "betting_bets_id,receiver_users_id");

        foreach ($data as $node) {


            $db->where("id", $node['receiver_users_id']);
            $phone = $db->getOne("core_users", "phone");
            if (count($phone)) {

//                $phone = $phone['phone'];
//                $text = "Bookiebot!+Accept+challenge!+You+received+private+bet+from+Test User!+Reply+'accept' or 'deny'!";
//                $sms_service_response = $this->loadService("common/_smssender")->send($phone, $text);
//                $db->where("betting_bets_id", $node['betting_bets_id']);
//                $db->where("receiver_users_id", $node['receiver_users_id']);
//                $db->update("core_users_has_betting_bets", array("has_sms" => 1));

            }


        }
    }

    /**
     * @param bool $bet_id
     * @param bool $liability_amount
     * @return array
     */
    public function acceptBet($bet_id = false, $event_id = false, $liability_amount = false)
    {
        $bet_id = (int)$bet_id;

        $liability_amount = (float)$liability_amount * 100;
        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            $db = $this->db;

            //Check If User WAS Bet Receiver
            $data = $db->rawQuery("
                SELECT
                  bets.bet_type,
                  bets.bet_amount,
                  bets.bet_odd,
                  bets.unmatched_amount,

                  IF(bets.betting_match_odds_id is null,bets.betting_outright_odds_id,bets.betting_match_odds_id) as odd_id,

                  bets.type,

                  bets.core_users_id as sender_user_id,

                  CONCAT(users.first_name,' ', users.last_name) as sender_name

                FROM
                  betting_bets bets,
                  core_users_has_betting_bets has_bets,
                  core_users users
                WHERE
                  has_bets.receiver_users_id = $user_id
                  AND
                  has_bets.betting_bets_id = bets.id
                  AND
                  users.id = has_bets.sender_users_id
                  AND
                  bets.id = $bet_id
            ");



            if (count($data)) {
                $data = $data[0];

                $received_bet_id = $bet_id;
                $bet_type = $data['bet_type'];
                $bet_odd = $data['bet_odd'];
                $odd_id = $data['odd_id'];
                $type = $data['type'];

                $is_od_available = $this->IsOddAvailable($odd_id,$type);

                if(!$is_od_available) {
                    return array("code"=>-1003,"msg"=>"This Match Was Started You Cant Accept this any more!");
                }

                //Lay Was Sent To Current User This Should be Back
                if ($bet_type == 1) {
                    $current_type = 2;//Current bet type for accepter user is Back
                    $received_bet_needs_amount_to_be_matched_with = $data['unmatched_amount'];
                }

                //Back Was Sent To Current User This Should Be Lay
                else {
                    $current_type = 1;//Current bet type For accepter user is Lay
                    $received_bet_needs_amount_to_be_matched_with = ($data['unmatched_amount'] * $data['bet_odd']) - $data['unmatched_amount'];
                }


                $balance = $this->loadService("user/session")->getBalance();
                if ($balance['code'] == 10) {
                    $has_balance = $balance['balance'];


                    //Doesn't Have Sufficient Balance TO Accept Bet With Requested Amount
                    if ($liability_amount > $has_balance) {
                        return array("code" => -100, "msg" => "Don't have sufficient balance to accept bet!");
                    } else {


                        //If Amount That Receiver Bet Needs Is Lower Or Equals To Provided
                        if ($received_bet_needs_amount_to_be_matched_with >= $liability_amount) {

                            //Both Fully Matched
                            if ($received_bet_needs_amount_to_be_matched_with == $liability_amount) {
                                $db->startTransaction();


                                /***********************************
                                 * 1) Cut Balance
                                 ***********************************/
                                $db->where('id', $user_id);
                                $cut_balance = $db->update("core_users", array("balance" => $db->dec($liability_amount)));


                                /***********************************
                                 * 2) INSERT NEW OPPOSITE BET TO BE MATCHED WITH RECEIVED BET
                                 ***********************************/
                                $opposite_bet_insert_data = array(
                                    "core_users_id" => $user_id,
                                    "bet_type" => $current_type,
                                    "bet_odd" => $bet_odd,
                                    "status" => 1,
                                    "is_private" => 1,
                                    "resulted" => 0,
                                    "unmatched_amount" => 0
                                );

                                //Pre match
                                if($type == 1) {
                                    $opposite_bet_insert_data['betting_match_odds_id'] = $odd_id;
                                }
                                //Outright
                                else {
                                    $opposite_bet_insert_data['betting_outright_odds_id'] = $odd_id;
                                }



                                //If Current Bet Should Be Saved As Lay
                                if ($current_type == 1) {
                                    $opposite_bet_insert_data['bet_amount'] = abs($liability_amount / (1 - $bet_odd));
                                }

                                //Back Stake Amount
                                elseif ($current_type == 2) {
                                    $opposite_bet_insert_data['bet_amount'] = $liability_amount;
                                }
                                $inserted_opposite_bet = $db->insert("betting_bets", $opposite_bet_insert_data);


                                /***********************************
                                 * 3) MATCH NEWLY SAVED AND RECEIVED BETS In Matching Table
                                 ***********************************/
                                if ($current_type == 1) {//Current is lay
                                    $layer_bet_id = $inserted_opposite_bet;
                                    $baker_bet_id = $received_bet_id;

                                    $baker_user_id = $data['sender_user_id'];
                                    $layer_user_id = $user_id;

                                    $back_amount_in_pot = $opposite_bet_insert_data['bet_amount'];
                                    $lay_amount_in_pot = $liability_amount;

                                } //If Current Is Back

                                elseif ($current_type == 2) {
                                    $layer_bet_id = $received_bet_id;
                                    $baker_bet_id = $inserted_opposite_bet;

                                    $baker_user_id = $user_id;
                                    $layer_user_id = $data['sender_user_id'];

                                    $back_amount_in_pot = abs($data['unmatched_amount'] / (1 - $bet_odd));
                                    $lay_amount_in_pot = $data['unmatched_amount'];
                                }

                                $data_to_insert_in_matching_table = array(
                                    "betting_lay_id" => $layer_bet_id,
                                    "betting_back_id" => $baker_bet_id,
                                    "betting_pot_amount" => $back_amount_in_pot + $lay_amount_in_pot,
                                    "back_amount_in_pot" => $back_amount_in_pot,
                                    "lay_amount_in_pot" => $lay_amount_in_pot,
                                    "backer_user_id" => $baker_user_id,
                                    "layer_user_id" => $layer_user_id,
                                    "odd_id" => $odd_id,
                                    "event_id" => $event_id,
                                    "bet_type"=>$bet_type,
                                    "settle_status" => 0,
                                );

                                $insert_matching = $db->insert("betting_matched_bets", $data_to_insert_in_matching_table);


                                /***********************************
                                 * 4) UPDATE RECEIVED BET AD FULLY MATCHED
                                 ***********************************/
                                $db->where("id", $received_bet_id);
                                $updated_received_as_fully_matched = $db->update("betting_bets", array("status" => 1, "unmatched_amount" => 0));


                                if ($cut_balance && $inserted_opposite_bet && $insert_matching && $updated_received_as_fully_matched) {
                                    $db->commit();
                                    return array("code"=>10);
                                }

                                else {
                                    echo $db->getLastError();
                                    $db->rollback();
                                    return array("code"=>-10);
                                }

                            }

                            //If Received Bet Is Partly Accepted and Matched
                            else {
                                return array("code" => -101, "msg" => "Friends bets cant be matched partially");
                            }





                        } else {
                            return array("code" => -101, "msg" => "Requested Amount is higher than this bet needs to matched with!");
                        }


                    }


                } else {
                    return array("code" => 20);
                }


            } else {
                return array("code" => 60);
            }

        }

    }


    /**
     * @param bool $bet_id
     */
    public function rejectBet($bet_id = false)
    {
        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];
            $db = $this->db;
            $db->where("receiver_users_id", $user_id);
            $db->where("betting_bets_id", $bet_id);
            $delete = $db->delete("core_users_has_betting_bets");
            if ($delete !== false) {
                return array("code" => 10);
            } else {
                return array("code" => 20);
            }

        } else {
            return array("code" => 20);
        }

    }


    /**
     * User Can Cancel Unmatched Bet And Receive Money On Balance
     * @param int $bet_id
     * @return array
     */
    public function cancelUnmatchedBet($bet_id = 0){


        if (!$bet_id) {
            return array("code" => 50);
        }

        $bet_id = (int)$bet_id;


        $this->Log("Requested Bet Cancelation!", array("bet_id" => $bet_id));
        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];


            $db = $this->db;

            $qs = "SELECT id, unmatched_amount, status FROM betting_bets WHERE id=$bet_id AND core_users_id = $user_id AND (status= 2 OR status = 0)";
            $getBet = $db->rawQuery($qs);

            if (count($getBet)) {

                $getBet = $getBet[0];

                $bet_id = $getBet['id'];
                $unmatched_amount = $getBet['unmatched_amount'];

                //Begin Transaction
                $db->startTransaction();

                //Update Bet As Canceled

                //If Bet Was Matched Than This is Partly Canceled
                if ($getBet['status'] == 2) {
                    $update_status = 6;
                } //If Bet Was Not Matched This is Fully Canceled
                else {
                    $update_status = 5;
                }


                $db->where("id", $bet_id);
                $update_bet = $db->update("betting_bets", array('unmatched_amount' => 0, "status" => $update_status));

                //Save Cancel Bet Amount
                $insert_cancelation = $db->insert("betting_bet_cancelations", array(
                    "betting_bets_id" => $bet_id,
                    "returned_amount" => $unmatched_amount
                ));


                $data = array(
                    'balance' => $db->inc($unmatched_amount)
                );
                $db->where('id', $user_id);
                $refunded = $db->update("core_users", $data);


                //If Bet Was Deleted And Refund Was Made Than Commit Action
                if ($update_bet && $refunded && $insert_cancelation) {
                    $this->Log("Refunded on canceled bet!", array("returned_amount" => $unmatched_amount, "cancelation_id" => $insert_cancelation));
                    $db->commit();
                    return array("code" => 10);
                } else {
                    $db->rollback();
                    return array("code" => 30);
                }

            } else {
                return array("code" => 70);
            }
        } else {
            return array("code" => 40);
        }
    }


    /**
     * Get Amount Of Money That Should Be Cut From Account Balance
     * @param $bet_type
     * @param $bet_amount
     * @param $bet_odd
     * @return mixed
     */
    private function calculateNeededBalanceForBet($bet_type, $bet_amount, $bet_odd)
    {

        $total = $bet_amount * $bet_odd;

        //Lay-Red - If Lay We Need To Cut Liability
        if ($bet_type == 1) {
            return $total - $bet_amount;
        } //Back Blue - When Betting Back We Need To Cut BetAmount
        else {
            return $bet_amount;
        }

    }


    /**
     * @param $odd_id
     * @param int $type
     * @return int
     */
    private function IsOddAvailable($odd_id, $type = 1)
    {
        $db = $this->db;
        $odd_id = (int)$db->escape($odd_id);
        $type = (int)$db->escape($type);


        //If Odd Was Match Odd
        if ($type == 1) {

            $get = $db->rawQuery("
                                SELECT

                                    matches.id as event_id,

                                    match_odds.match_odd_name as match_odd_name,
                                    match_odds.SpecialBetValue as SpecialBetValue,

                                    odds.title as odd_title,
                                    odds.OutCome as odd_putcome,

                                    oddtypes.title as type_title,
                                    oddtypes.TeamReplace as team_replace

                                FROM

                                  betting_match matches,
                                  betting_match_odds match_odds,
                                  betting_odds odds,
                                  betting_oddtypes oddtypes

                                WHERE
                                  match_odds.id = $odd_id
                                    AND
                                  match_odds.status = 1
                                    AND
                                  matches.status = 1
                                    AND
                                  matches.starttime > NOW()
                                    AND
                                  odds.id = match_odds.betting_odds_id
                                    AND
                                  odds.betting_oddtypes_id = oddtypes.id
                                    AND
                                  match_odds.betting_match_id = matches.id
                                    LIMIT 1
                            ");
            if(count($get)) {



                return $get[0]['event_id'];
            } else {
                return false;
            }

        } //If Odd Was Outright Odd

        else if ($type == 2) {
            $get = $db->rawQuery("
                                SELECT
                                    outright.id as event_id
                                FROM
                                  betting_outright outright,
                                  betting_outright_odds odds
                                WHERE
                                  odds.id = $odd_id
                                  AND
                                  odds.status = 1
                                  AND
                                  outright.status = 1
                                  AND
                                  outright.EventEndDate > NOW()
                                  AND
                                  odds.betting_outright_id = outright.id
                                  LIMIT 1
                            ");
            if(count($get)) {
                return $get[0]['event_id'];
            } else {
                return false;
            }
        }

        return false;


    }


    /**
     * Check if matching is found and save relationship
     *
     * @param $ParametersForMatching
     *
     *                  "odd_id"=>$odd_id,
     * "bet_odd"=>$bet_odd,
     * "bet_amount,"=>$bet_amount,
     * "bet_type"=>$bet_type,
     * "insert_bet_id"=>$insert_id,
     * "user_id"=>$user_id,
     * "match_id"=>$match_id
     * @return array
     */
    private function checkMatching($ParametersForMatching)
    {
        //Check If Bet Was Lay
        if ($ParametersForMatching['bet_type'] == 1) {
            return $this->MatchLayToBack($ParametersForMatching);
        } //Check If Bet Was Back
        else {
            return $this->MatchBackToLay($ParametersForMatching);
        }
    }


    /**
     * If User Makes Lay Bet We Try To Find Back Bets And Match Them With This Lay Bet
     * @param $parameters
     * @return array
     */
    private function MatchLayToBack($parameters)
    {


        $odd_id = $parameters['odd_id'];
        $bet_odd = $parameters['bet_odd'];
        $bet_amount = $parameters['bet_amount'];
        $insert_lay_bet_id = $parameters['insert_bet_id'];
        $layer_user_id = $parameters['user_id'];
        $event_id = $parameters['event_id'];
        $type = $parameters['type'];


        $odd_id_string = "";
        if ($type == 1) {
            $odd_id_string = "bets.betting_match_odds_id as odd_id,";
        } elseif ($type == 2) {
            $odd_id_string = "bets.betting_outright_odds_id as odd_id,";
        }

        //Calculate Total Liability For Current Lay Bet
        $current_bet_total_liability = $this->calculateNeededBalanceForBet(1, $bet_amount, $bet_odd);


        $db = $this->db;
        if ($type == 1) {
            $odd_name = "bets.betting_match_odds_id";
        } else {
            $odd_name = "bets.betting_outright_odds_id";
        }

        $back_bet_for_this_lay_bet = $db->rawQuery("
            SELECT
              bets.id,
              bets.bet_amount,
              bets.bet_odd,
              $odd_id_string
              bets.core_users_id as backer_users_id,
              bets.unmatched_amount
            FROM
              betting_bets bets
            WHERE

              bets.bet_type = 2
                AND
              bets.bet_odd = $bet_odd
                AND
              (
                bets.status = 2 OR bets.status = 0
              )
                AND
              $odd_name = $odd_id
                AND
              bets.type = $type

              ORDER BY
                bets.unmatched_amount
              ASC

        ");


        $match_status = array();

        foreach ($back_bet_for_this_lay_bet as $back) {

            $db->startTransaction();

            if ($current_bet_total_liability == 0) {
                return array("code" => 10, "message" => "matched_fully");
                continue;
            }

            //If Back Matched Fully But Have Some Lay Money Left
            $back_needs_to_be_fully_matched_amount = $back['unmatched_amount'] * $back['bet_odd'] - $back['unmatched_amount'];


            $lay_bet_needs_to_be_fully_matched = $current_bet_total_liability / ($back['bet_odd'] - 1);


            //Current Bet Liability And Needed Amount For Back Bet Are The Same
            //Than This Bets Are Fully Matched With Each Other
            if ($lay_bet_needs_to_be_fully_matched == $back['unmatched_amount']) {

                $db->where('id', $insert_lay_bet_id);
                $lay_update = $db->update("betting_bets", array("unmatched_amount" => 0, "status" => 1));

                $db->where('id', $back['id']);
                $back_update = $db->update("betting_bets", array("unmatched_amount" => 0, "status" => 1));

                $insert_matched_bet_data = array(
                    "betting_back_id" => $back['id'],
                    "betting_lay_id" => $insert_lay_bet_id,
                    "betting_pot_amount" => ($back['unmatched_amount'] + $current_bet_total_liability),
                    "back_amount_in_pot" => $back['unmatched_amount'],
                    "lay_amount_in_pot" => $current_bet_total_liability,
                    "layer_user_id" => $layer_user_id,
                    "backer_user_id" => $back['backer_users_id'],
                    "event_id" => $event_id,
                    "bet_type" => $type,
                    "odd_id" => $back['odd_id']

                );
                $saved_matching = $db->insert("betting_matched_bets", $insert_matched_bet_data);

                if ($back_update && $lay_update && $saved_matching) {
                    $db->commit();
                    $match_status = array("code" => 10, "message" => "matched_fully");
                    return array("code" => 10, "message" => "matched_fully");
                } else {
                    echo $db->getLastError();
                    $db->rollback();
                    $match_status = array("code" => 20);
                }


            }


            //If This Lay Was Fully Matched But Back Has Additional Money And Waiting SomeOne To Take
            if ($lay_bet_needs_to_be_fully_matched < $back['unmatched_amount']) {

                $db->where('id', $insert_lay_bet_id);
                $lay_update = $db->update("betting_bets", array("unmatched_amount" => 0, "status" => 1));

                $db->where('id', $back['id']);
                $back_update = $db->update("betting_bets", array("unmatched_amount" => $back['unmatched_amount'] - $lay_bet_needs_to_be_fully_matched, "status" => 2));


                $insert_matched_bet_data = array(
                    "betting_back_id" => $back['id'],
                    "betting_lay_id" => $insert_lay_bet_id,
                    "betting_pot_amount" => ($lay_bet_needs_to_be_fully_matched + $current_bet_total_liability),
                    "back_amount_in_pot" => $lay_bet_needs_to_be_fully_matched,
                    "lay_amount_in_pot" => $current_bet_total_liability,
                    "layer_user_id" => $layer_user_id,
                    "backer_user_id" => $back['backer_users_id'],
                    "event_id" => $event_id,
                    "bet_type" => $type,
                    "odd_id" => $back['odd_id']
                );
                $saved_matching = $db->insert("betting_matched_bets", $insert_matched_bet_data);

                if ($back_update && $lay_update && $saved_matching) {
                    $current_bet_total_liability = 0;
                    $db->commit();
                    $match_status = array("code" => 10, "message" => "matched_fully");
                } else {
                    $db->rollback();
                    echo $db->getLastError();
                    $match_status = array("code" => 20);
                }

            }


            //If This Lay Was Matched Partly //But Back for matched fully
            if ($lay_bet_needs_to_be_fully_matched > $back['unmatched_amount']) {


                $db->where('id', $insert_lay_bet_id);
                $unmatched_left = $current_bet_total_liability - $back_needs_to_be_fully_matched_amount;
                $lay_update = $db->update("betting_bets", array("unmatched_amount" => $unmatched_left, "status" => 2));

                $db->where('id', $back['id']);
                $back_update = $db->update("betting_bets", array("unmatched_amount" => 0, "status" => 1));


                $insert_matched_bet_data = array(
                    "betting_back_id" => $back['id'],
                    "betting_lay_id" => $insert_lay_bet_id,
                    "betting_pot_amount" => ($back_needs_to_be_fully_matched_amount + $back['unmatched_amount']),
                    "back_amount_in_pot" => $back['unmatched_amount'],
                    "lay_amount_in_pot" => $back_needs_to_be_fully_matched_amount,
                    "layer_user_id" => $layer_user_id,
                    "backer_user_id" => $back['backer_users_id'],
                    "event_id" => $event_id,
                    "bet_type" => $type,
                    "odd_id" => $back['odd_id']
                );
                $saved_matching = $db->insert("betting_matched_bets", $insert_matched_bet_data);

                if ($back_update && $lay_update && $saved_matching) {
                    $current_bet_total_liability = $unmatched_left;
                    $db->commit();
                    $match_status = array("code" => 11, "message" => "matched_partly", "unmatched_amount_left" => $unmatched_left);
                } else {
                    $db->rollback();
                    
                    $match_status = array("code" => 20);
                }

            }


        }


        return $match_status;
    }


    /**
     * If User Makes Back Bet We Try To Find Lay Bets And Match Them With This Back Bet
     * @param $parameters
     * @return array
     */
    private function MatchBackToLay($parameters)
    {

        $odd_id = $parameters['odd_id'];
        $bet_odd = $parameters['bet_odd'];
        $bet_amount = $parameters['bet_amount'];
        $insert_back_bet_id = $parameters['insert_bet_id'];
        $backer_user_id = $parameters['user_id'];
        $event_id = $parameters['event_id'];
        $type = $parameters['type'];

        $odd_id_string = "";

        //Pre match
        if ($type == 1) {
            $odd_id_string = "bets.betting_match_odds_id as odd_id,";
        }

        //Outright
        elseif ($type == 2) {
            $odd_id_string = "bets.betting_outright_odds_id as odd_id,";
        }

        $this_back_needs_lay_amount_to_be_matched_with = ($bet_amount * $bet_odd) - $bet_amount;

        $db = $this->db;
        //Pre match
        if ($type == 1) {
            $odd_name = "bets.betting_match_odds_id";
        }

        //Outright
        else {
            $odd_name = "bets.betting_outright_odds_id";
        }

        $lay_bets_for_this_back_bet = $db->rawQuery("
            SELECT
              bets.id,
              bets.bet_amount,
              bets.bet_odd,
              $odd_id_string
              bets.core_users_id as layer_user_id,
              bets.unmatched_amount
            FROM
              betting_bets bets
            WHERE
              bets.bet_type = 1
              AND
              (bets.status = 0 OR bets.status = 2)
              AND
              bets.bet_odd = $bet_odd
              AND
              $odd_name = $odd_id
              AND
              bets.type = $type
            ORDER BY
              bet_amount
            ASC

        ");


        $match_status = array();
        foreach ($lay_bets_for_this_back_bet as $lay) {

            //What Money Is Left For Matching
            $available_lay_pot = $lay['unmatched_amount'];
            $odd = $lay['bet_odd'] - 1; //3
            $lay_bet_needs_amount_to_matched_totally = $lay['unmatched_amount'] / $odd; //10


            //Here We Check Laundering Suspecting Between Users


            if ($this_back_needs_lay_amount_to_be_matched_with == 0) {
                return array("code" => 10, "message" => "matched_fully");
            }

            $db->startTransaction();
            //If Lay And Back Where Matched Fully
            if ($available_lay_pot == $this_back_needs_lay_amount_to_be_matched_with) {

                $db->where('id', $insert_back_bet_id);
                $back_update = $db->update("betting_bets", array("unmatched_amount" => 0, "status" => 1));

                $db->where('id', $lay['id']);
                $lay_update = $db->update("betting_bets", array("unmatched_amount" => 0, "status" => 1));

                $insert_matched_bet_data = array(
                    "betting_lay_id" => $lay['id'],
                    "betting_back_id" => $insert_back_bet_id,
                    "betting_pot_amount" => ($this_back_needs_lay_amount_to_be_matched_with + $bet_amount),
                    "back_amount_in_pot" => $bet_amount,
                    "lay_amount_in_pot" => $this_back_needs_lay_amount_to_be_matched_with,
                    "layer_user_id" => $lay['layer_user_id'],
                    "backer_user_id" => $backer_user_id,
                    "event_id" => $event_id,
                    "bet_type" => $type,
                    "odd_id" => $lay['odd_id']
                );
                $saved_matching = $db->insert("betting_matched_bets", $insert_matched_bet_data);

                if ($back_update && $lay_update && $saved_matching) {
                    $this_back_needs_lay_amount_to_be_matched_with = 0;
                    $bet_amount = 0;
                    $db->commit();
                    return array("code" => 10, "message" => "matched_fully");
                } else {
                    $db->rollback();
                    echo $db->getLastError();
                    return array("code" => 20);
                }
            } //This Back Was Fully Matched And Lay Has Additional Money To Be Matched And Waiting

            elseif ($available_lay_pot > $this_back_needs_lay_amount_to_be_matched_with) {

                $db->where('id', $insert_back_bet_id);
                $back_update = $db->update("betting_bets", array("unmatched_amount" => 0, "status" => 1));

                $db->where('id', $lay['id']);
                $lay_update = $db->update("betting_bets", array("unmatched_amount" => ($available_lay_pot - $this_back_needs_lay_amount_to_be_matched_with), "status" => 2));

                $insert_matched_bet_data = array(
                    "betting_lay_id" => $lay['id'],
                    "betting_back_id" => $insert_back_bet_id,
                    "betting_pot_amount" => ($this_back_needs_lay_amount_to_be_matched_with + $bet_amount),
                    "back_amount_in_pot" => $bet_amount,
                    "lay_amount_in_pot" => $this_back_needs_lay_amount_to_be_matched_with,
                    "layer_user_id" => $lay['layer_user_id'],
                    "backer_user_id" => $backer_user_id,
                    "event_id" => $event_id,
                    "bet_type" => $type,
                    "odd_id" => $lay['odd_id']

                );
                $saved_matching = $db->insert("betting_matched_bets", $insert_matched_bet_data);

                if ($back_update && $lay_update && $saved_matching) {
                    $this_back_needs_lay_amount_to_be_matched_with = 0;
                    $bet_amount = 0;
                    $db->commit();
                    return array("code" => 10, "message" => "matched_fully");
                } else {
                    $db->rollback();
                    echo $db->getLastError();
                    return array("code" => 20);
                }
            } //Lay Was Fully Matched And This Back Has Additional Money To Be Matched

            elseif ($lay_bet_needs_amount_to_matched_totally < $bet_amount) {

                $db->where('id', $insert_back_bet_id);
                $unmatched_left = ($bet_amount - $lay_bet_needs_amount_to_matched_totally);
                $back_update = $db->update("betting_bets", array("unmatched_amount" => $unmatched_left, "status" => 2));

                $db->where('id', $lay['id']);
                $lay_update = $db->update("betting_bets", array("unmatched_amount" => 0, "status" => 1));

                $insert_matched_bet_data = array(
                    "betting_lay_id" => $lay['id'],
                    "betting_back_id" => $insert_back_bet_id,
                    "betting_pot_amount" => ($lay_bet_needs_amount_to_matched_totally + $bet_amount),
                    "back_amount_in_pot" => $bet_amount,
                    "lay_amount_in_pot" => $available_lay_pot,
                    "layer_user_id" => $lay['layer_user_id'],
                    "backer_user_id" => $backer_user_id,
                    "event_id" => $event_id,
                    "bet_type" => $type,
                    "odd_id" => $lay['odd_id']
                );

                $saved_matching = $db->insert("betting_matched_bets", $insert_matched_bet_data);

                if ($back_update && $lay_update && $saved_matching) {
                    $bet_amount = $unmatched_left;
                    $this_back_needs_lay_amount_to_be_matched_with = ($unmatched_left * $bet_odd) - $unmatched_left;;
                    $db->commit();
                    $match_status = array("code" => 11, "message" => "matched_partly", "unmatched_amount_left" => $unmatched_left);
                } else {
                    $db->rollback();
                    echo $db->getLastError();
                    $match_status = array("code" => 20);
                }

            }


        }
        return $match_status;
    }


}