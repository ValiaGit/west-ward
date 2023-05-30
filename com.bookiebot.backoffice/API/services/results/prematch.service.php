<?php


if(!defined('APP')) {
    die();
}

class Prematch extends Service {


    /**
     * @param bool $match_id
     * @return array
     */
    public function getResultsList($match_id = false) {


        $db = $this->db;
//        $match_id = $db->escape($match_id);

//        $clause = "";
//        if($match_id) {
//            $clause .= " AND betting_match_id = $match_id";
//        }

        $data = $db->rawQuery("

                    SELECT
                        queue.id,
                        matches.id as match_id,
                        matches.BetradarMatchId as BetradarMatchId,
                        matches.BetFairEventId as BetFairEventId,



                        queue.result_receive_time,
                        queue.status as queueStatus,
                        competitor1.title as home,
                        competitor2.title as away,
                        sport.title as sport_title



                    FROM

                        betting_resulting_queue queue,
                        betting_match matches,
                        betting_competitors competitor1,
                        betting_competitors competitor2,
                        betting_sport sport

                    WHERE
                      matches.id = queue.event_id
                      AND
                      competitor1.id = matches.betting_competitors_id
                      AND
                      competitor2.id = matches.betting_competitors_id1
                      AND
                      matches.betting_sport_id = sport.id
                   GROUP BY
                      queue.id
                   ORDER BY
                    queue.result_receive_time
                   DESC
                   LIMIT 50

        ");

        foreach($data as &$node) {
            $node['home'] = $this->getUnserializedTitle($node['home']);
            $node['away'] = $this->getUnserializedTitle($node['away']);
            $node['sport_title'] = $this->getUnserializedTitle($node['sport_title']);
        }


        return array("code"=>10,"data"=>$data);
    }


    /**
     * @param bool $queue_id
     */
    public function settleResult($queue_id = false) {

    }


}