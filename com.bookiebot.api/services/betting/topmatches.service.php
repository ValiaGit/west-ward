<?php


if(!defined('APP')) {
    die();
}

/**
 * Class Matches
 */
class Topmatches extends Service {


        /**
         * Gets Top Matches And Rearranges In Sports
         * @return array
         */
        public function getTopMatches() {
            $db = $this->db;

            $OddsService = $this->loadService("betting/odds");

            $matches = $db->rawQuery("
                                        SELECT
                                            matches.id,
                                            matches.betting_sport_id as sId,

                                            team.title as h,
                                            team2.title as a,

                                            matches.starttime as t

                                        FROM
                                            betting_match matches,
                                            betting_sport sports,
                                            betting_competitors team,
                                            betting_competitors team2
                                        WHERE
                                          matches.betting_sport_id = sports.id
                                            AND
                                          team.id = matches.betting_competitors_id
                                            AND
                                          team2.id = matches.betting_competitors_id1
                                            AND
                                          matches.status = 1
                                            AND
                                          matches.top = 1
                                          AND
                                          matches.starttime > NOW()

                                        GROUP BY
                                            matches.id
                                     ");


            //Push Arranged Odds For Every Match
            for($i=0;$i<count($matches);$i++) {
                $matches[$i]['t'] = date("c",strtotime($matches[$i]['t']));
                $matches[$i]['h'] = $this->getUnserializedTitle($matches[$i]['h']);
                $matches[$i]['a'] = $this->getUnserializedTitle($matches[$i]['a']);
                $matches[$i]['odds'] = $OddsService->getMainOddsByMatchId($matches[$i]['id']);
            }
            return $matches;
        }


        /**
         * Gets Matches Raw Data And Rearranges It In Sports
         * @param $matchesData
         * @return array
         */
        private function reArrangeTopMatches($matchesData) {

            $sports = array();

            //Iterate Over Matches
            foreach($matchesData as $key=>$match) {
                $sport_id = (int) $match['sId'];
                if(!isset($sports[$sport_id])) {
                    $sports[$sport_id] = array("id"=>$sport_id,"t"=>$this->getUnserializedTitle($match['s_title']),"c"=>$match['sCode'],"m"=>array());
                }
                unset($match['s_title']);
                unset($match['sCode']);
                array_push($sports[$sport_id]['m'],$match);
            }

            return $sports;
        }


}


?>