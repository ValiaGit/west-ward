<?php


if (!defined('APP')) {
    die();
}


class Bets extends Service
{


    /**
     * @param array $filter
     * @return array
     *                  match_odd_status - 3 Won,2 Lost
     *                  match_status; 0 - Disabled; 1 - Active; 2 - Finished; 3- In Play
     */
    public function getBetList($skip = false, $pageSize = 10, $filter = array())
    {


        $db = $this->db;


        $clause = $this->ReturnKendoFilterClause($filter, true);
//echo $clause;
        $skip = (int)$skip;
        $pageSize = (int)$pageSize;

//        print_r($filter);

        $qs = "SELECT
                                        bets.id as bets__id,

                                        bets.bet_type as bets__bet_type,
                                        bets.bet_amount as bets_bet_amount ,
                                        bets.unmatched_amount as bets_unmatched_amount,

                                      IF(
                                        bets.bet_type = 1,
                                        (
                                          (bets.bet_amount*bets.bet_odd) - bets.bet_amount
                                        ),
                                        bets.bet_amount
                                      ) as bet_liability,

                                        bets.bet_odd as bets_bet_odd,
                                        bets.status as bets__status,


                                        bets.returned_unmatched_amount as returned_unmatched_amount, #returned_unmatched_amount

                                        bets.type as tp,
                                        bets.row_last_update,
                                        bets.balance_before_bet as balance_before_bet,
                                        bets.balance_after_settlement as balance_after_settlement,
                                        bets.is_private as is_private,

                                        bets.profit_lose as profit_lose,
                                        bets.deducted_commission as deducted_commission,
                                        bets.returned_unmatched_amount as returned_unmatched_amount,


                                        #DATE_FORMAT(bets.bets_date, '%Y-%m-%dT%TZ') as bets__bets_date,
                                        bets.bets_date as bets__bets_date,


                                          #UserData
                                          users.id as users__id,
                                          users.username as users__username,
                                          CONCAT(users.first_name,' ',users.last_name) as users_fullname,

                                        odds.id as oId,
                                        odds.title as odd_title,

                                        oddtypes.id as otId,
                                        oddtypes.title as type_title,
                                        oddtypes.TeamReplace as tr,


                                        matches.id as matches__id,
                                        matches.status as event_status,
                                        matches.score_data as score_data,
                                        matches.BetradarMatchId as betradar_event_id,

                                        competitor1.title as home,
                                        competitor2.title as away,

                                        match_odds.match_odd_name as odn,
                                        match_odds.SpecialBetValue as sp,
                                        match_odds.status as mos,
                                        match_odds.id as match__odds_id,

                                        sport.title as sports_title,
                                        sport.code as sports_code,
                                        category.title as category_title,
                                        tournament.title as tournament_title



                                    FROM
                                        core_users users,
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
                                        bets.core_users_id = users.id
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
                                    LIMIT $pageSize OFFSET $skip";
        $return = array();
        $mysqli = $db->getSQLIInstance();


        if($result = $mysqli->query($qs)) {
            /* fetch associative array */
            while ($node = $result->fetch_assoc()) {
                $node['home'] = $this->getUnserializedTitle($node['home']);
                $node['away'] = $this->getUnserializedTitle($node['away']);


                if($node['tp'] == 2) {
                    $node['odn'] = $this->getUnserializedTitle($node['odn']);
                }

                $node['sports_title'] = $this->getUnserializedTitle($node['sports_title']);
                $node['category_title'] = $this->getUnserializedTitle($node['category_title']);
                $node['tournament_title'] = $this->getUnserializedTitle($node['tournament_title']);

                $node['score_data'] = json_decode($node['score_data'], true);

                $node['private_data'] = $this->getBetReceiversInPrivateBetWhichCurrentUserMade($node['bets__id']);

                array_push($return,$node);
            }

            $result->free();
        } else {
            var_export($mysqli->error);
        }

//        print_r($return);

        $total = 0;
        try {
            $total = $db->rawQuery("SELECT COUNT(bets.id) as cnt  FROM
                                        core_users users,
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
                                        bets.core_users_id = users.id
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
                                        $clause");
            $total = $total[0]['cnt'];
        }catch(Exception $e) {

        }




        return array("code" => 10, "total"=>$total,  "data" => $return);

    }


    /**
     * @param bool $bet_id
     * @return array
     */
    public function getBetDetails($bet_id = false)
    {
        $db = $this->db;

        if(!$bet_id) {
            return false;
        }

        $data = $db->rawQuery("
            SELECT


              bets.id as bet_id,
              bets.bet_type,
              bets.bet_amount,
              bets.bet_odd,
              bets.status as bet_status,
              bets.unmatched_amount/100 as unmatched_amount,
              bets.is_private,


              matches.id as event_id,
              matches.BetradarMatchId as event_betradar_id,


              IF(
                bets.bet_type = 1,
                (bets.bet_amount*bets.bet_odd - bets.bet_amount)/100,
                bets.bet_amount/100
              ) as bet_liability,




              IF(
                matched_bets.betting_lay_id = bets.id,
                matched_bets.betting_back_id,
                matched_bets.betting_lay_id

              ) as matcher_bet_id,
              matched_bets.betting_pot_amount as betting_pot_amount,

              matched_bets.back_amount_in_pot as back_amount_in_pot,
              matched_bets.lay_amount_in_pot as lay_amount_in_pot,



              cancelations.cancel_time,
              cancelations.returned_amount as returned_amount



            FROM

              betting_bets bets

            INNER JOIN
              betting_match_odds match_odds
            ON
              bets.betting_match_odds_id = match_odds.id

            INNER JOIN
              betting_match matches
            ON
              matches.id = match_odds.betting_match_id

            LEFT JOIN
              betting_matched_bets matched_bets
            ON
              matched_bets.betting_lay_id = bets.id
                OR
              matched_bets.betting_back_id = bets.id

          LEFT JOIN
            betting_bet_cancelations cancelations
          ON
            cancelations.betting_bets_id = bets.id

            WHERE
              bets.id = $bet_id

            GROUP BY
              matched_bets.id



        ");


        $return = array();

        //If Found More Than One Matched Bets With Current Bet
        if (count($data)) {
            foreach ($data as $betting) {


                //Create Bet Not With Bet Id
                if (!isset($return[$betting['bet_id']])) {
                    $return[$betting['bet_id']] = array(
                        "bet_type" => $betting['bet_type'],
                        "bet_amount" => $betting['bet_amount'],
                        "bet_status" => $betting['bet_status'],
                        "bet_odd" => $betting['bet_odd'],
                        "unmatched_amount" => $betting['unmatched_amount'],
                        "bet_liability" => (float)$betting['bet_liability'],
                        "matched_with" => array(),
                        "cancelation_data"=>array()
                    );
                }


                if ($betting['cancel_time'] !== null) {
                    $returned_amount = $betting['returned_amount'];
                    $cancel_time = $betting['cancel_time'];
                    $return[$betting['bet_id']]['cancelation_data'] = array(
                        "cancel_time" => $cancel_time,
                        "returned_amount" => $returned_amount
                    );
                }


                if(isset($betting['matcher_bet_id'])) {
                    //Push Matched Bets in Array
                    array_push($return[$betting['bet_id']]['matched_with'], array(
                        "bet_id" => $betting['matcher_bet_id'],
                        "betting_pot_amount" => $betting['betting_pot_amount'],
                        "back_amount_in_pot" => $betting['back_amount_in_pot'],
                        "lay_amount_in_pot" => $betting['lay_amount_in_pot'],
                    ));
                }


            }
        } //If Bet Didn't have matchings

        return array(
            "data"=>$return
        );
    }



    public function getBetReceiversInPrivateBetWhichCurrentUserMade2($private_bet_id,$users_id)
    {

        $db = $this->db;
        $data = $db->rawQuery("SELECT
                        CONCAT(users.first_name,' ',users.last_name) AS full_name,
                        users.id as receiver_id,
                        users.gender
                        FROM
                          core_users_has_betting_bets has_bets,
                          core_users users
                        WHERE
                        has_bets.sender_users_id=$users_id
                        AND betting_bets_id = $private_bet_id
                        AND users.id = has_bets.receiver_users_id
                        ");
        if($data) {
            return array("code"=>10,"data"=>$data);
        } else {
            return array("code"=>60);
        }

    }


    /**
     * @param $private_bet_id
     * @return array
     */
    public function getBetReceiversInPrivateBetWhichCurrentUserMade($private_bet_id)
    {



            $private_bet_id = (int)$private_bet_id;

            $qs = "SELECT
                          CONCAT(sender_user.first_name,' ',sender_user.last_name) as sender_name,
                        CONCAT(receiver_user.first_name,' ',receiver_user.last_name) as receiver_user,
                         receiver_user.id as receiver_user_id,
                         sender_user.id as sender_user_id

                        FROM
                          core_users_has_betting_bets has_bets,
                          betting_matched_bets matched_bets,
                          core_users sender_user,
                          core_users receiver_user
                        WHERE
                        (matched_bets.betting_lay_id = $private_bet_id OR matched_bets.betting_back_id = $private_bet_id)
                        AND
                        (has_bets.betting_bets_id=matched_bets.betting_lay_id OR has_bets.betting_bets_id = matched_bets.betting_back_id)
                        AND
                        receiver_user.id = has_bets.receiver_users_id
                        AND
                        sender_user.id = has_bets.sender_users_id
                        ";
//        echo $qs;
            $db = $this->db;
            $data = $db->rawQuery($qs);
            if(count($data)) {
                return $data;
            } else {
                return array("code"=>60);
            }



    }


}