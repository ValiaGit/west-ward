<?php


if (!defined('APP')) {
    die();
}

/**
 * Class Matches
 */
class Matches extends Service
{


    /**
     * Get Match Odds And Market
     * @param int $match_id
     * @return array
     */
    public function getMatch($match_id = 0)
    {
        $db = $this->db;

        if (!$match_id) {
            $match_id = (int)$db->escape($_POST['match_id']);
        }


        $data = $db->rawQuery("
                                    SELECT

                                        matches.id as id,
                                        matches.betting_sport_id as sId,
                                        matches.betting_tournament_id as tId,
                                        matches.starttime as t,
                                        matches.status as s,

                                        IF(matches.status = 2,matches.score_data,'') as score,

                                        matches.BetFairEventId,
                                        matches.BetradarMatchId,

                                        tournament.title as tName,
                                        category.title as cName,
                                        category.id as cId,


                                        competitors.title as h,
                                        competitors2.title as a,

                                        IF(matches.score_data != '',matches.score_data,'') as score,


                                        sport.code as sCode

                                    FROM
                                        betting_match matches,
                                        betting_competitors competitors,
                                        betting_competitors competitors2,
                                        betting_tournament tournament,
                                        betting_category category,
                                        betting_sport sport

                                    WHERE
                                      competitors.id = matches.betting_competitors_id
                                        AND
                                      competitors2.id = matches.betting_competitors_id1
                                        AND
                                      matches.betting_tournament_id = tournament.id
                                        AND
                                      tournament.betting_category_id = category.id
                                        AND
                                      category.betting_sport_id = sport.id
                                        AND
                                      (
                                          matches.status = 1
                                            OR
                                          matches.status = 2
                                      )
                                        AND
                                      matches.starttime > NOW()
                                        AND
                                      matches.id=?
                                  ",
            array($match_id)
        );


        if(!isset($data[0])) {
            return array("code"=>60);
        }

        $data = $data[0];

        $data['h'] = $this->getUnserializedTitle($data['h']);
        $data['t'] = date("c", strtotime($data['t']));
        $data['a'] = $this->getUnserializedTitle($data['a']);
        $data['tName'] = $this->getUnserializedTitle($data['tName']);
        $data['cName'] = $this->getUnserializedTitle($data['cName']);
        $odds_service = $this->loadService("betting/odds");
        $odds = $odds_service->getOddsByMatchId($match_id);
        $data['odds'] = $odds;


        return $data;
    }


    /**
     * Gets League Id as Parameter Or Gets From POST request and returns Matches For That League With Odds
     * @param $tournament_id
     * @return array
     */
    public function getMatchesByTournamentID($tournament_id = 0,$intervalMinutes = false)
    {
        $db = $this->db;
        if (!$tournament_id) {
            $tournament_id = (int)$_POST['tournament_id'];
        }


        $OddsService = $this->loadService("betting/odds");

        $intervalString="";
        if($intervalMinutes) {
            $minutes = (int) $intervalMinutes;
            $intervalString.=" AND  matches.starttime < DATE_ADD(NOW(),INTERVAL $minutes MINUTE) ";
        }


        $qs = "
                                    SELECT
                                        matches.id,
                                        matches.betting_sport_id as sId,
                                        team.title as h,
                                        team2.title as a,
                                        matches.starttime as t
                                    FROM
                                        betting_match matches,
                                        betting_tournament tournament,
                                        betting_competitors team,
                                        betting_competitors team2
                                    WHERE
                                      matches.betting_tournament_id = tournament.id
                                        AND
                                      tournament.id = $tournament_id
                                        AND
                                      team.id = matches.betting_competitors_id
                                        AND
                                      team2.id = matches.betting_competitors_id1
                                        AND
                                      matches.status = 1
                                      AND matches.starttime > NOW()
                                      $intervalString
                                      GROUP BY
                                        matches.id
                                 ";

        $matches = $db->rawQuery($qs);



        $return = array();

        //Push Arranged Odds For Every Match
        for ($i = 0; $i < count($matches); $i++) {
            $matches[$i]['h'] = $this->getUnserializedTitle($matches[$i]['h']);
            $matches[$i]['a'] = $this->getUnserializedTitle($matches[$i]['a']);
            $matches[$i]['t'] = date('c', strtotime($matches[$i]['t']));
            $matches[$i]['odds'] = $OddsService->getMainOddsByMatchId($matches[$i]['id']);
            if ($matches[$i]['odds'] || 1) {
                array_push($return, $matches[$i]);
            }
        }
        return $return;
    }


    /**
     * Get Matches That Start In A Week Interval
     * @param int $interval_days
     * @return array
     */
    public function getUpcomingMatches($interval_days = 15)
    {


            $db = $this->db;

            $data = $db->rawQuery("SELECT
                                        matches.id,
                                        matches.betting_sport_id as sId,
                                        team.title as h,
                                        team2.title as a,
                                        matches.starttime as t,
                                        sport.code as sCode,
                                        sport.title as sTitle
                                    FROM
                                        betting_sport sport,
                                        betting_match matches,
                                        betting_competitors team,
                                        betting_competitors team2
                                    WHERE
                                      team.id = matches.betting_competitors_id
                                        AND
                                      team2.id = matches.betting_competitors_id1
                                        AND
                                      matches.status = 1
                                        AND
                                      sport.id = matches.betting_sport_id
                                        AND
                                      matches.starttime BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL $interval_days DAY)
                                    GROUP BY
                                        matches.id
                                    ORDER BY
                                      matches.starttime
                                    ASC LIMIT 50");
            foreach ($data as $index => $node) {
                $data[$index]['h'] = $this->getUnserializedTitle($data[$index]['h']);
                $data[$index]['a'] = $this->getUnserializedTitle($data[$index]['a']);
                $data[$index]['sTitle'] = $this->getUnserializedTitle($data[$index]['sTitle']);
            }
            return $data;


    }


    /**
     * Get Upcoming Matches For Concrete Team
     * @param int $competitor_id
     * @param int $interval_days
     * @return array
     */
    public function getUpcomingMatchesByTeamID($competitor_id = 0, $interval_days = 10)
    {
        if (!$competitor_id) {
            $competitor_id = (int)$_POST['team_id'];
        }


        $db = $this->db;

        $data = $db->rawQuery("SELECT
                                        matches.id,
                                        matches.betting_sport_id as sId,
                                        team.title as h,
                                        team2.title as a,
                                        matches.starttime as t,
                                        sport.code as sCode
                                    FROM
                                        betting_sport sport,
                                        betting_match matches,
                                        betting_competitors team,
                                        betting_competitors team2
                                    WHERE
                                      team.id = matches.betting_competitors_id
                                        AND
                                      team2.id = matches.betting_competitors_id1
                                        AND
                                        (
                                          team.id = $competitor_id
                                          OR
                                          team2.id = $competitor_id
                                        )
                                        AND
                                      matches.status = 1
                                        AND
                                      sport.id = matches.betting_sport_id
                                        AND
                                      matches.starttime BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL $interval_days DAY)
                                    GROUP BY
                                        matches.id
                                    ORDER BY
                                      matches.starttime
                                    ASC");

        foreach ($data as &$match) {
            $match['h'] = $this->getUnserializedTitle($match['h']);
            $match['a'] = $this->getUnserializedTitle($match['a']);
        }
        return $data;


    }


    /**
     * Get Matches That Have Unmatched Amount
     * @return array
     */
    public function getMatchesThatHaveMoney()
    {
        $db = $this->db;

        $matches = $db->rawQuery("

                SELECT

                  SUM(bets.unmatched_amount) as unmatched_amount,

                  matches.starttime,

                  competitors1.title as h,
                  competitors2.title as a,

                  betting_tournament.title as tTitle,
                  betting_category.title as cTitle,
                  betting_sport.title as sTitle,

                  betting_sport.code as sCode,

                  matches.id as match_id

                FROM
                    betting_bets bets

                #MATCH ODDS
                INNER JOIN
                    betting_match_odds match_odds
                ON
                  bets.betting_match_odds_id = match_odds.id

                #MATCH
                INNER JOIN
                  betting_match matches
                ON
                  matches.id = match_odds.betting_match_id

                #COMPETITOR 1
                INNER JOIN
                  betting_competitors competitors1
                ON  competitors1.id = matches.betting_competitors_id

                #COMPETITOR 2
                INNER JOIN
                  betting_competitors competitors2
                ON  competitors2.id = matches.betting_competitors_id1

                #TOURNAMENT
                INNER JOIN
                    betting_tournament
                  ON
                    matches.betting_tournament_id = betting_tournament.id


                #CATEGORY
                INNER JOIN
                    betting_category
                  ON
                    betting_tournament.betting_category_id = betting_category.id


                #CATEGORY
                INNER JOIN
                    betting_sport
                  ON
                    betting_category.betting_sport_id = betting_sport.id



                #GROUP AND ORDER
                GROUP  BY
                  matches.id
                 ORDER BY
                  unmatched_amount
                 DESC

        ");
        $ret = array();
        foreach ($matches as &$match) {
            if ($match['unmatched_amount'] > 1) {
                $match['h'] = $this->getUnserializedTitle($match['h']);
                $match['a'] = $this->getUnserializedTitle($match['a']);

                $match['tTitle'] = $this->getUnserializedTitle($match['tTitle']);
                $match['cTitle'] = $this->getUnserializedTitle($match['cTitle']);
                $match['sTitle'] = $this->getUnserializedTitle($match['sTitle']);

                $match['starttime'] = date("c", strtotime($match['starttime']));
                array_push($ret, $match);
            }

        }

        return $ret;

    }


}


?>