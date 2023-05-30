<?php


if(!defined('APP')) {
    die();
}


class History extends Service {


    /**
     * @param array $filter
     * @return array
     */
    public function getHistoryList($filter = array("from"=>false,"to"=>"","bet_status"=>"","bet_type"=>""), $from=false, $to = false) {

        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user = $user_data['id'];

            $db = $this->db;

            if(!$from) {
                $from = $db->escape(@$filter['from']);
            }

            if(!$to) {
                $to = $db->escape(@$filter['to']);
            }

            $status = (int)$db->escape(@$filter['bet_status']);
            $type = (int)$db->escape(@$filter['bet_type']);

            $clause = "";

            if(!empty($from)) {
                $clause .= " AND bets.bets_date > '$from' ";
            }

            if(!empty($to)) {
                $clause .= " AND bets.bets_date < '$to' ";
            }


            if(!empty($status) && $status != -1 && $status!="-1") {
                $clause .= " AND bets.status = $status ";
            }
            if(!empty($type) && $type != -1 && $type!="-1") {
                $clause .= " AND bets.bet_type = $type ";
            }
//
//            var_export($clause);

            $qs = "
SELECT * FROM
(
                                    SELECT
                                        bets.id,

                                        bets.bet_type as bt, #BetType
                                        bets.bet_amount as ba, #BetAmount
                                        bets.unmatched_amount as ua,#UnmatchedAmount

                                      IF(
                                        bets.bet_type = 1,
                                        ((bets.bet_amount*bets.bet_odd) - bets.bet_amount),
                                        bets.bet_amount
                                      ) as bet_liability,

                                        bets.bet_odd as bo, #BetOdd
                                        bets.status as s, #Status

                                        bets.returned_unmatched_amount as um_returned_amount, #returned_unmatched_amount

                                        bets.returned_unmatched_amount as returned_unmatched_amount, #returned_unmatched_amount

                                        bets.type as tp, #type prematch or outright
                                        bets.is_private as is_private, #private


                                        bets.profit_lose as profit_lose, #profit_lose
                                        bets.deducted_commission as deducted_commission, #deducted_commission


                                        bets.bets_date as t,


                                        odds.id as oId,
                                        oddtypes.id as otId,


                                        matches.id as event_id,
                                        matches.status as event_status,
                                        matches.score_data as sc,
                                        matches.starttime as starttime,
                                        competitor1.title as h,
                                        competitor2.title as a,

                                        match_odds.match_odd_name as odn,
                                        match_odds.SpecialBetValue as sp,

                                        sport.title as sports_title,
                                        sport.code as sports_code,
                                        category.title as category_title,
                                        tournament.title as tournament_title



                                    FROM
                                        betting_bets bets,
                                        betting_match_odds match_odds,

                                        betting_match matches,

                                        betting_tournament tournament,
                                        betting_category category,
                                        betting_sport sport,


                                        betting_odds odds,

                                        betting_oddtypes oddtypes,
                                        betting_competitors competitor1,
                                        betting_competitors competitor2
                                    WHERE
                                        bets.core_users_id = $user
                                        AND
                                        bets.type = 1
                                          AND
                                        bets.betting_match_odds_id = match_odds.id
                                          AND
                                        matches.id = match_odds.betting_match_id

                                          AND
                                        matches.betting_sport_id = sport.id
                                        AND
                                        matches.betting_category_id = category.id
                                        AND
                                        matches.betting_tournament_id = tournament.id

                                          AND
                                        odds.id = match_odds.betting_odds_id
                                          AND
                                        odds.betting_oddtypes_id = oddtypes.id
                                          AND
                                        competitor1.id = matches.betting_competitors_id
                                          AND
                                        competitor2.id = betting_competitors_id1
                                        $clause
                                    GROUP BY
                                        bets.id
                                    ORDER BY
                                        bets.id
                                    DESC
) as prematch




                                    UNION
SELECT * FROM
(
                                    SELECT
                                        bets.id,

                                        bets.bet_type as bt, #BetType
                                        bets.bet_amount as ba, #BetAmount
                                        bets.unmatched_amount as ua,#UnmatchedAmount

                                      IF(
                                        bets.bet_type = 1,
                                        (bets.bet_amount*bets.bet_odd) - bets.bet_amount,
                                        bets.bet_amount
                                      ) as bet_liability,

                                        bets.bet_odd as bo, #BetOdd
                                        bets.status as s, #Status
                                        bets.returned_unmatched_amount as um_returned_amount, #returned_unmatched_amount

                                        bets.returned_unmatched_amount as returned_unmatched_amount, #returned_unmatched_amount

                                        bets.type as tp, #type
                                        bets.is_private as is_private, #private

                                        bets.profit_lose as profit_lose, #profit_lose
                                        bets.deducted_commission as deducted_commission, #deducted_commission

                                        bets.bets_date as t,

                                        null as oId,
                                        null as otId,

                                        outright.id as event_id,
                                        outright.status as event_status,
                                        outright.EventDate as starttime,
                                        null as sc,
                                        outright_competitors.title as h,
                                        null as a,


                                        outright_competitors.title as odn,
                                        null as sp,

                                        sport.title as sports_title,
                                        sport.code as sports_code,
                                        category.title as category_title,
                                        outright.title as tournament_title

                                    FROM
                                        core_users users,
                                        betting_bets bets,
                                        betting_category category,
                                        betting_sport sport,
                                        betting_outright_odds outright_odds,
                                        betting_outright outright,
                                        betting_outright_competitors outright_competitors

                                    WHERE
                                        bets.core_users_id = $user
                                        AND
                                        bets.type = 2
                                        AND
                                        bets.betting_outright_odds_id = outright_odds.id
                                        AND
                                        outright_competitors.id = outright_odds.betting_outright_competitors_id
                                        AND
                                        outright_odds.betting_outright_id = outright.id
                                        AND
                                        category.id = outright.betting_category_id
                                        AND
                                        sport.id = category.betting_sport_id
                                        $clause
                                    GROUP BY
                                        bets.id
                                    ORDER BY
                                        bets.id
                                    DESC
) as outright
                                    ";




            //echo $qs;
            $hist_result = $db->_mysqli->query($qs);

            echo $db->getLastError();
            if(!$hist_result->num_rows) {
                return array("code"=>60);
            } else {
                $data = array();
                while($fetch = mysqli_fetch_assoc($hist_result)) {
                    array_push($data,$fetch);
                }
                foreach($data as $index=>$node) {

                    $data[$index]['h'] = $this->getUnserializedTitle($data[$index]['h']);
                    $data[$index]['a'] = $this->getUnserializedTitle($data[$index]['a']);

                    if($data[$index]['tp'] == 2) {
                        $data[$index]['odn'] = $this->getUnserializedTitle($data[$index]['odn']);
                    }

                    $data[$index]['sports_title'] = $this->getUnserializedTitle($data[$index]['sports_title']);
                    $data[$index]['category_title'] = $this->getUnserializedTitle($data[$index]['category_title']);
                    $data[$index]['tournament_title'] = $this->getUnserializedTitle($data[$index]['tournament_title']);

                    //If Bet Was Canceled
                    if($data[$index]['s'] == 5 || $data[$index]['s'] == 6) {
                        $data[$index]['canceled_bet_data'] = $this->getCanceledBetData($data[$index]['id']);
                    }

                    if($data[$index]['is_private']) {
                        //If Receiver Show Sender

                        $receivers = $this->loadService("betting/bets")->getBetReceiversInPrivateBetWhichCurrentUserMade($data[$index]['id']);

                        //If Sender Show Receivers
                        if($receivers['code'] == 10) {
                            $data[$index]['receivers_data'] = $receivers['data'];
                        } else {

                            $sender = $this->loadService("betting/bets")->getBetSenderInPrivateBetWhichCurrentUserMade($data[$index]['id']);

                            if($sender['code'] == 10) {
                                $data[$index]['senders_data'] = $sender['data'];
                            }

                        }

                    }
                }
                return array("code"=>10,"data"=>$data);
            }




        }
        else {
            return array("code"=>40);
        }

    }



    /**
     * @param $bet_id
     * @return array
     */
    private function getCanceledBetData($bet_id) {
        $bet_id = (int) $bet_id;
        $db = $this->db;
        $db->where("betting_bets_id",$bet_id);
        $data = $db->getOne("betting_bet_cancelations","returned_amount,cancel_time");
        return $data;
    }


}



?>