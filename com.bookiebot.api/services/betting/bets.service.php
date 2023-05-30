<?php


if (!defined('APP')) {
    die();
}

/**
 * Is Responsible For Betting Data To Get For Example How Many Bets Was Made On Certain Odd
 * Class Bets
 */
class Bets extends Service
{




    public function getBetsForCurrentSesion() {
        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user = $user_data['id'];
            $session_id = isset($user_data['grantSession'])?$user_data['grantSession']:false;
            $db = $this->db;

            $db->where('core_users_id',$user);
            $db->where('session_id',$session_id);
            $summery = $db->getOne("betting_bets","SUM(profit_lose) as money_transfers");
            if($summery) {
                if(count($summery)) {
                    return array("code"=>10,'amounts'=>$summery['money_transfers']);
                } else {
                    return array("code"=>60);
                }
            } else {
                return array("code"=>60);
            }




        }
        else {
            return array("code"=>20);
        }
    }

    /**
     * Gets Match Odd Id As Parameter And
     * Returns Data What Bests Are Available Backs And Lays Are Available on The Market
     * @param $match_odd_id
     * @param $match_id
     * @return array
     */
    public function getBetsDataByOddID($match_odd_id = 0, $match_id = 0)
    {
        if (!$match_odd_id) {
            $match_odd_id = (int)$_POST['match_odd_id'];
        }


        $db = $this->db;
        $odd_id = (int)$db->escape($match_odd_id);


        $data = array();

        $getAvailableBackBetsForMatchOdd = $this->getAvailableBackBetsForMatchOdd($match_odd_id, 3, $match_id);
        $getAvailableLayBetsForMatchOdd = $this->getAvailableLayBetsForMatchOdd($match_odd_id, 3, $match_id);

//        print_r($getAvailableBackBetsForMatchOdd);
//        print_r($getAvailableBackBetsForMatchOdd);
        $data['availableLays'] = $getAvailableLayBetsForMatchOdd;
        $data['availableBacks'] = $getAvailableBackBetsForMatchOdd;

        return $data;
    }


    /**
     *
     */
    public function getBetDetailsForCurrentSession() {
        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user = $user_data['id'];
            $session_id = isset($user_data['grantSession'])?$user_data['grantSession']:false;


            $db = $this->db;



        }
    }



    /**
     *
     */
    public function getOddsDataByOutrightOddId($outright_odd_id = 0)
    {
        if (!$outright_odd_id) {
            $outright_odd_id = (int)$_POST['outright_odd_id'];
        }

        $db = $this->db;


        $data = array();


        $getAvailableBackBetsForMatchOdd = $this->getAvailableBackBetsForMatchOdd($outright_odd_id, 3, 0, 2);
        $getAvailableLayBetsForMatchOdd = $this->getAvailableLayBetsForMatchOdd($outright_odd_id, 3, 0, 2);

        $data['availableLays'] = $getAvailableLayBetsForMatchOdd;
        $data['availableBacks'] = $getAvailableBackBetsForMatchOdd;

        return $data;

    }


    /**
     * Get Bets That Are Against Current Team,
     * This Will Be Shown In Community Feed
     */
    public function getBetsStreamByTeamId($competitor_id = 0, $limit = 10)
    {
        if (!$competitor_id) {
            return array("code" => 70);
        }


        $db = $this->db;

        $data = $db->rawQuery("
                                SELECT

                                     bets.bet_type,
                                     bets.bet_amount,
                                     ROUND(bets.bet_amount/100,2),
                                     bets.bet_odd,
                                     odds.title,
                                     users.id as user_id,
                                     bets.bets_date,
                                     odd_types.title as market_title,
                                     IF(users.name_privacy=1,CONCAT(first_name,' ',last_name),nickname) as fullname,
                                     if(match_odds.match_odd_name = '',odds.title,match_odds.match_odd_name) as selection,
                                     competitors.title home,
                                     competitors1.title away


                                FROM

                                    betting_bets bets,
                                    betting_match_odds match_odds,
                                    betting_match matches,
                                    betting_odds odds,
                                    betting_oddtypes odd_types,
                                    core_users users,
                                    betting_competitors competitors,
                                    betting_competitors competitors1


                                WHERE


                                    (
                                        matches.betting_competitors_id = $competitor_id
                                           OR
                                        matches.betting_competitors_id1 = $competitor_id
                                    )
                                        AND
                                    match_odds.betting_match_id = matches.id
                                        AND
                                    bets.betting_match_odds_id = match_odds.id
                                        AND
                                    odds.id = match_odds.betting_odds_id
                                        AND

                                    odd_types.id = odds.betting_oddtypes_id
                                        AND
                                    (
                                         bets.status = 0
                                         OR
                                         bets.status = 2
                                    )
                                      AND
                                    competitors.id = matches.betting_competitors_id
                                      AND
                                    competitors1.id = matches.betting_competitors_id1
                                      AND
                                    matches.status = 1
                                      AND
                                    match_odds.status = 1
                                      AND
                                    users.id = bets.core_users_id

                                GROUP BY
                                    bets.id
                                ORDER BY
                                  bets.id DESC
                                ");
        foreach ($data as &$node) {
            $node['home'] = $this->getUnserializedTitle($node['home']);
            $node['away'] = $this->getUnserializedTitle($node['away']);
            $node['avatar'] = $this->loadService("user/settings")->getUserImage($node['user_id'], "thumb");
        }
        return $data;

    }


    /**
     * @param int $match_odd_id
     * @return array
     */
    public function getDetailedBetsDataByOddId($match_odd_id = 0)
    {
        if (!$match_odd_id) {
            $match_odd_id = (int)$_POST['match_odd_id'];
        }

        $db = $this->db;
        $odd_id = (int)$db->escape($match_odd_id);


        $data = array();

        $getAvailableBackBetsForMatchOdd = $this->getAvailableBackBetsForMatchOdd($match_odd_id, 3);
        $getAvailableLayBetsForMatchOdd = $this->getAvailableLayBetsForMatchOdd($match_odd_id, 3);

        $data['availableLays'] = $getAvailableLayBetsForMatchOdd;
        $data['availableBacks'] = $getAvailableBackBetsForMatchOdd;

        return $data;
    }


    /**
     * If We Want To Show Available Back Bets For Current Odds
     * We Should Select Data From LayedBets With The Largest Available odd_value
     * @param int $match_odd_id
     * @param int $limit
     * @param int $match_id
     * @return array
     */
    private function getAvailableBackBetsForMatchOdd($match_odd_id = 0, $limit = 3, $match_id = 0, $type = 1)
    {
        if (!$match_odd_id) {
            $match_odd_id = (int)$_POST['match_odd_id'];
        }


        //Get Opponent Odds Group For This Odd
//        $odds_service = $this->loadService("betting/odds");
//        $opponent_ids = $odds_service->getOddsTypeGroupByMatchOddId($match_odd_id,$match_id);
//        $opponent_ids_count = $opponent_ids['count'];
//        $opponent_ids = $opponent_ids['ids'];

        $clause = " AND type=$type ";
        if ($type == 1) {
            $odd_name = "betting_match_odds_id";
        } else {
            $odd_name = "betting_outright_odds_id";
        }

        $db = $this->db;
        $data = $db->rawQuery("SELECT
                                    bet_odd as price,
                                    ROUND(SUM(unmatched_amount / 100),2) as amount
                                FROM
                                    betting_bets
                                WHERE
                                    $odd_name = $match_odd_id
                                        AND
                                    bet_type = 1
                                        AND
                                    is_private = 0
                                        AND
                                    unmatched_amount > 0
                                        AND
                                    (
                                        betting_bets.status = 0
                                          OR
                                        betting_bets.status = 2
                                    )
                                    $clause
                                GROUP BY
                                  bet_odd
                                ORDER BY
                                  bet_odd
                                DESC
                                LIMIT $limit
                             ");


        foreach ($data as &$value) {
            $value['amount'] = number_format($value['amount'] / ($value['price'] - 1), 2, ".", "");
        }

        return $data;
    }


    /**
     * If We Want To Show Available Lay Bets For Current Odds
     * We Should Select Data From BackBets With The Smallest odd_value
     * @param int $match_odd_id
     * @param int $limit
     * @param int $match_id
     * @return array
     */
    private function getAvailableLayBetsForMatchOdd($match_odd_id = 0, $limit = 3, $match_id = 0, $type = 1)
    {
        if (!$match_odd_id) {
            $match_odd_id = (int)$_POST['match_odd_id'];
        }

        $clause = " AND type=$type ";
        if ($type == 1) {
            $odd_name = "betting_match_odds_id";
        } else {
            $odd_name = "betting_outright_odds_id";
        }


        $db = $this->db;
        $data = $db->rawQuery("
                                SELECT
                                    bet_odd as price,
                                    ROUND(SUM(unmatched_amount / 100),2) as amount
                                FROM
                                    betting_bets
                                WHERE
                                    $odd_name = $match_odd_id
                                      AND
                                    bet_type = 2
                                      AND
                                    is_private = 0
                                      AND
                                    unmatched_amount > 0
                                      AND
                                    (
                                        betting_bets.status = 0
                                          OR
                                        betting_bets.status = 2
                                    )
                                    $clause
                                GROUP BY
                                  bet_odd
                                ORDER BY
                                  bet_odd
                                DESC LIMIT $limit
                             ");


        return $data;
    }


    /**
     * Gets All Market By Odd Type And MatchID
     *      For Example: if i wan to get all correct score market data for match with id=1
     *                   i call -  getBetsDataByMatchOddTypeId(1,2);
     * @param $match_id
     * @param $odd_type_id
     * @return array
     */
    public function getMarketDataByMatchAndOddTypeId($match_id = false, $odd_type_id = false)
    {
        $db = $this->db;


        $data = $db->rawQuery("
                        SELECT
                          SUM(matched_bets.betting_pot_amount) as matched_amount
                        FROM
                            betting_bets bets,
                            betting_matched_bets matched_bets,
                            betting_match_odds match_odds,
                            betting_odds odds
                        WHERE
                            odds.betting_oddtypes_id = $odd_type_id
                              AND
                            match_odds.betting_odds_id = odds.id
                              AND
                            is_private = 0
                              AND
                            match_odds.betting_match_id = $match_id
                              AND
                            bets.betting_match_odds_id = match_odds.id
                              AND
                            matched_bets.betting_back_id = bets.id
                        ");

        if (count($data)) {
            if (!$data[0]['matched_amount']) {
                $data[0]['matched_amount'] = 0;
            }
            return (int)$data[0]['matched_amount'];
        } else {
            return 0.00;
        }


    }


    /**
     * Gets Bet That User Friends Have Made
     * @return array
     */
    public function getBetsByFriends()
    {
        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            $db = $this->db;


            $data = $db->rawQuery("
                                    SELECT

                                        users.id as user_id,
                                        IF(users.name_privacy=1,CONCAT(users.first_name,' ',users.last_name),users.nickname) as fullname,
                                        bets.bets_date,
                                        bets.bet_type,
                                        bets.unmatched_amount,
                                        competitors.title as home,
                                        competitors1.title as away,
                                        bets.bet_amount,
                                        matches.id as match_id,
                                        oddtypes.title as market_title,
                                        if(match_odds.match_odd_name = '',odds.title,match_odds.match_odd_name) as selection,
                                        oddtypes.id as oddtype_id

                                    FROM

                                        core_users users,
                                        betting_bets bets,
                                        social_friendship friendship,
                                        betting_match_odds match_odds,
                                        betting_match matches,
                                        betting_competitors competitors,
                                        betting_competitors competitors1,

                                        betting_odds odds,
                                        betting_oddtypes oddtypes

                                    WHERE
                                      users.bet_privacy = 1
                                        AND
                                      friendship.core_user_id = ?
                                        AND
                                      bets.core_users_id = friendship.core_user_friend
                                        AND
                                      friendship.status =  1
                                        AND
                                      users.id = friendship.core_user_friend
                                        AND
                                      match_odds.id = bets.betting_match_odds_id
                                        AND
                                      match_odds.betting_match_id = matches.id
                                        AND
                                      competitors.id = matches.betting_competitors_id
                                        AND
                                      competitors1.id = matches.betting_competitors_id1
                                        AND
                                      odds.id = match_odds.betting_odds_id
                                        AND
                                      odds.betting_oddtypes_id = oddtypes.id
                                        AND
                                      (bets.status = 2 OR bets.status = 0)

                                    GROUP BY
                                      bets.id
                                    ORDER BY
                                      bets.id
                                    DESC
                                    LIMIT 10
                                 ", array($user_id));


            foreach ($data as &$node) {
                $node['home'] = $this->getUnserializedTitle($node['home']);
                $node['away'] = $this->getUnserializedTitle($node['away']);
                $node['avatar'] = $this->loadService("user/settings")->getUserImage($node['user_id'], "thumb");
            }
            return $data;
        } else {
            return array("code" => 40);
        }
    }



    /**
     * bo - BetOdd
     * tp - BetType,Lay,Back
     * t - Type, Outright,Prematch,Live
     * odn - MatchOddName
     * ua - UnmatchedAmount
     * ba - BetAmount
     * bt - BetType
     * sc - Score
     *
     * oId - Odd Id
     * otId - Odd TypeId
     *
     *
     *
     * @return array
     */
    public function getUsersOpenedBets()
    {
        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user = $user_data['id'];

            $db = $this->db;
            $qs = "
SELECT * FROM (
                                    SELECT
                                        bets.id,
                                        bets.bet_type as bt, #BetType0
                                        bets.bet_amount as ba, #BetAmount
                                        bets.unmatched_amount as ua,#UnmatchedAmount
                                        bets.bet_odd as bo, #BetOdd
                                        bets.status as s, #Status
                                        bets.type as tp, #type
                                        bets.is_private as is_private, #private
                                        bets.bets_date as t,

                                        odds.id as oId,
                                        oddtypes.id as otId,

                                        matches.id as event_id,
                                        matches.score_data as sc,
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
                                        bets.core_users_id=$user
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
                                        competitor2.id = matches.betting_competitors_id1
                                          AND
                                          (
                                            bets.status = 0
                                            OR
                                            bets.status = 2
                                          )
                                          AND
                                          bets.type = 1
                                    GROUP BY
                                        bets.id
                                    ORDER BY
                                        bets.id
                                    DESC
) as opened_prematch

UNION

SELECT * FROM (
                                      SELECT

                                        bets.id,
                                        bets.bet_type as bt, #BetType0
                                        bets.bet_amount as ba, #BetAmount
                                        bets.unmatched_amount as ua,#UnmatchedAmount
                                        bets.bet_odd as bo, #BetOdd
                                        bets.status as s, #Status
                                        bets.type as tp, #type
                                        bets.is_private as is_private, #private
                                        bets.bets_date as t,

                                        null as oId,
                                        null as otId,


                                        outright.id as event_id,
                                        null as sc,
                                        null as a,
                                        null as h,

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
                                        bets.betting_outright_odds_id = outright_odds.id
                                        AND
                                        outright_competitors.id = outright_odds.betting_outright_competitors_id
                                        AND
                                        outright_odds.betting_outright_id = outright.id
                                        AND
                                        category.id = outright.betting_category_id
                                        AND
                                        sport.id = category.betting_sport_id
                                         AND
                                          (
                                            bets.status = 0
                                            OR
                                            bets.status = 2
                                          )
                                          AND
                                          bets.type = 2
                                    GROUP BY
                                        bets.id
                                    ORDER BY
                                        bets.id
                                    DESC
) as opened_outright

                                    ";
//echo $qs;

            $data = $db->rawQuery($qs);
            echo $db->getLastError();
            foreach ($data as $index => $node) {
//                print_r($node);

                $data[$index]['h'] = $this->getUnserializedTitle($data[$index]['h']);
                $data[$index]['a'] = $this->getUnserializedTitle($data[$index]['a']);

                if($data[$index]['tp'] == 2) {
                    $data[$index]['odn'] = $this->getUnserializedTitle($data[$index]['odn']);
                }

                $data[$index]['sports_title'] = $this->getUnserializedTitle($data[$index]['sports_title']);
                $data[$index]['category_title'] = $this->getUnserializedTitle($data[$index]['category_title']);
                $data[$index]['tournament_title'] = $this->getUnserializedTitle($data[$index]['tournament_title']);

                if($data[$index]['is_private']) {
                    $receivers = $this->getBetReceiversInPrivateBetWhichCurrentUserMade($data[$index]['id']);
                    if($receivers['code'] == 10) {
                        $data[$index]['receivers_data'] = $receivers['data'];
                    } else {
                        $data[$index]['receivers_data'] = array();
                    }

                }
            }


            if(count($data)) {
                return array("code"=>10,"data"=>$data);
            } else {
                return array("code"=>60);
            }


        } else {
            return array("code" => 40);
        }
    }



    /**
     * @param $private_bet_id
     * @return array
     */
    public function getBetReceiversInPrivateBetWhichCurrentUserMade($private_bet_id)
    {
        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            $private_bet_id = (int)$private_bet_id;
            $user_id = (int)$user_id;

            $db = $this->db;
            $data = $db->rawQuery("SELECT
                        CONCAT(users.first_name,' ',users.last_name) AS full_name,
                        users.id as receiver_id,
                        users.gender
                        FROM
                          core_users_has_betting_bets has_bets,
                          core_users users
                        WHERE
                        has_bets.sender_users_id=$user_id
                        AND betting_bets_id = $private_bet_id
                        AND users.id = has_bets.receiver_users_id
                        ");
            if(count($data)) {
                foreach($data as &$user) {
                    $user['avatar'] = $this->loadService("user/settings")->getUserImage($user['receiver_id'],"thumb",$user['gender']);
                }
                return array(
                    "code"=>10,
                    "data"=>$data
                );
            } else {
                return array("code"=>60);
            }
        } else {
            return array("code"=>20);
        }


    }


    /**
     * @param $private_bet_id
     *
     */
    public function getBetSenderInPrivateBetWhichCurrentUserMade($private_bet_id) {
        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            $private_bet_id = (int)$private_bet_id;
            $user_id = (int)$user_id;

            $db = $this->db;
            $qs = "
                        SELECT
                            CONCAT(users.first_name,' ',users.last_name) AS full_name,
                            users.id as sender_id,
                            users.gender
                        FROM
                          core_users_has_betting_bets has_bets,
                          betting_matched_bets matched_bets,
                          core_users users
                        WHERE
                        (matched_bets.betting_lay_id = $private_bet_id OR matched_bets.betting_back_id = $private_bet_id)
                      AND
                          has_bets.receiver_users_id=$user_id
                        AND
                          users.id = has_bets.sender_users_id
                        ";
//            echo $qs;
            $data = $db->rawQuery($qs);
            if(count($data)) {
                foreach($data as &$user) {
                    $user['avatar'] = $this->loadService("user/settings")->getUserImage($user['sender_id'],"thumb",$user['gender']);
                }
                return array(
                    "code"=>10,
                    "data"=>$data
                );
            } else {
                return array("code"=>60);
            }
        } else {
            return array("code"=>20);
        }

    }

    /**
     * @param bool|false $receiver_user_id
     * @param bool|false $bet_id
     * @return array
     */
    public function deleteSentPrivateBetRequest($receiver_user_id=false,$bet_id=false) {
        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user = $user_data['id'];

            $db = $this->db;

            $receiver_user_id = (int) $receiver_user_id;
            $bet_id = (int) $bet_id;


            $check_if_receiver_is_last_user = $db->rawQuery("
            SELECT
              COUNT(*) as cnt
            FROM
              core_users_has_betting_bets has_bets
              WHERE
              has_bets.sender_users_id = $user
              AND betting_bets_id = $bet_id
            ");
            if($check_if_receiver_is_last_user[0]['cnt']>1) {
                $db->where("sender_users_id",$user);
                $db->where("betting_bets_id",$bet_id);
                $db->where("receiver_users_id",$receiver_user_id);
                $delete = $db->delete("core_users_has_betting_bets");

                if($delete !== false) {
                    return array("code"=>10);
                }
                else {
                    return array("code"=>30);
                }
            } else {
                return array("code"=>-30,"msg"=>"Only one receiver left and you cant cancel request! You can cancel whole bet!");
            }




        }
        else {
            return array("code"=>20);
        }

    }


    /**
     * @return array
     */
    public function getUsersReceivedBets()
    {
        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user = $user_data['id'];

            $db = $this->db;
            $qs = "


                    SELECT * FROM (
                                    SELECT
                                        bets.id, #1
                                        bets.bet_type as bt, #2 - BetType
                                        bets.bet_amount as ba, #3 - BetAmount
                                        bets.unmatched_amount as ua,#4 - UnmatchedAmount
                                        bets.bet_odd as bo, #5 - BetOdd
                                        bets.status as s, #6 - Status
                                        bets.type as tp, #7 - type
                                        bets.bets_date as t, #8 - Type

                                        odds.id as oId, #9
                                        oddtypes.id as otId, #10

                                        matches.id as event_id,
                                        matches.score_data as sc, #11
                                        competitor1.title as h, #12
                                        competitor2.title as a, #13

                                        CONCAT(users.first_name,' ',users.last_name) as sender_name, #14

                                        match_odds.match_odd_name as odn, #15
                                        match_odds.SpecialBetValue as sp, #16
                                        match_odds.oddValue as ov, #17

                                        tournaments.title as tournament_title, #18
                                        category.title as category_title, #19
                                        sports.title as sports_title, #20
                                        sports.code as sports_code #21



                                    FROM
                                        core_users users,
                                        betting_bets bets,
                                        betting_match_odds match_odds,

                                        betting_match matches,
                                        betting_tournament tournaments,
                                        betting_sport sports,
                                        betting_category category,


                                        betting_odds odds,
                                        betting_oddtypes oddtypes,
                                        betting_competitors competitor1,
                                        betting_competitors competitor2,
                                        core_users_has_betting_bets has_bets
                                    WHERE
                                        bets.betting_match_odds_id = match_odds.id
                                          AND
                                        matches.id = match_odds.betting_match_id
                                          AND
                                        odds.id = match_odds.betting_odds_id
                                          AND
                                        odds.betting_oddtypes_id = oddtypes.id
                                          AND
                                        competitor1.id = matches.betting_competitors_id
                                          AND
                                        competitor2.id = matches.betting_competitors_id1
                                          AND

                                        tournaments.id = matches.betting_tournament_id
                                          AND
                                        sports.id = matches.betting_sport_id
                                          AND
                                        category.id = matches.betting_category_id
                                          AND

                                        (bets.status = 0 OR bets.status = 2)

                                          AND
                                          has_bets.receiver_users_id = $user
                                          AND has_bets.betting_bets_id = bets.id
                                          AND
                                          users.id = has_bets.sender_users_id

                                    GROUP BY
                                        has_bets.betting_bets_id
                                    ORDER BY
                                        bets.id
                                    DESC
) as received_prematch
UNION ALL

SELECT * FROM (
                                    SELECT
                                        bets.id, #1
                                        bets.bet_type as bt, #2 - BetType
                                        bets.bet_amount as ba, #3 - BetAmount
                                        bets.unmatched_amount as ua, #4- UnmatchedAmount
                                        bets.bet_odd as bo, #5 - BetOdd
                                        bets.status as s, #6 - Status
                                        bets.type as tp, #7 - type
                                        bets.bets_date as t, #8 - Bet Time


                                        null as oId, #9
                                        null as otId, #10

                                        outright.id as event_id,
                                        null as sc, #11
                                        outright_competitors.title as h, #12
                                        null as a, #13

                                        CONCAT(users.first_name,' ',users.last_name) as sender_name, #14
                                        outright_competitors.title as odn, #15

                                        null as sp, #16
                                        null as ov, #17

                                        outright.title as tournament_title, #18
                                        category.title as category_title, #19
                                        sports.title as sports_title, #20
                                        sports.code as sports_code #21



                                    FROM
                                        core_users users,
                                        betting_bets bets,
                                        betting_category category,
                                        betting_sport sports,
                                        betting_outright_odds outright_odds,
                                        betting_outright outright,
                                        betting_outright_competitors outright_competitors,

                                        core_users_has_betting_bets has_bets
                                    WHERE
                                        outright_odds.id = bets.betting_outright_odds_id
                                        AND
                                        outright_odds.betting_outright_id = outright.id
                                        AND
                                        outright_competitors.id = outright_odds.betting_outright_competitors_id
                                        AND
                                        sports.id = category.betting_sport_id
                                          AND
                                        category.id = outright.betting_category_id
                                          AND

                                        (bets.status = 0 OR bets.status = 2)

                                          AND
                                          has_bets.receiver_users_id = $user
                                          AND
                                          has_bets.betting_bets_id = bets.id
                                          AND
                                          users.id = has_bets.sender_users_id

                                    GROUP BY
                                        has_bets.betting_bets_id
                                    ORDER BY
                                        bets.id
                                    DESC
) as received_outright
                                    ";
//            echo $qs;
            $data = $db->rawQuery($qs);


            foreach ($data as $index => $node) {

                $data[$index]['h'] = $this->getUnserializedTitle($data[$index]['h']);
                $data[$index]['a'] = $this->getUnserializedTitle($data[$index]['a']);

                if($data[$index]['tp'] == 2) {
                    $data[$index]['h'] = $this->getUnserializedTitle($data[$index]['tournament_title']);
                    $data[$index]['odn'] = $this->getUnserializedTitle($data[$index]['odn']);
                }


                $data[$index]['sports_title'] = $this->getUnserializedTitle($data[$index]['sports_title']);
                $data[$index]['tournament_title'] = $this->getUnserializedTitle($data[$index]['tournament_title']);
                $data[$index]['category_title'] = $this->getUnserializedTitle($data[$index]['category_title']);
            }

            if(count($data)) {
                return array("code"=>10,"data"=>$data);
            } else {
                return array("code"=>60);
            }

        } else {
            return array("code" => 40);
        }
    }


}