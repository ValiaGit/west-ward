<?php


class Matchodds extends Service {




    public function getOddsByMatchId($match_id = false) {

        $match_id = (int)$match_id;

        $db = $this->db;
        $qs = "
                                SELECT
                                    match_odds.id,
                                    match_odds.match_odd_name,
                                    match_odds.status,
                                    match_odds.SpecialBetValue as sp,
                                    match_odds.oddValue as ov,

                                    odds.id as odd_id,
                                    odds.title as odd_title,

                                    oddtypes.id as type_id,
                                    oddtypes.title as type_title,
                                    oddtypes.BetradarOddsTypeID,
                                    oddtypes.priority


                                FROM
                                  betting_match_odds match_odds,
                                  betting_oddtypes oddtypes,
                                  betting_odds odds

                                WHERE
                                  match_odds.betting_match_id = $match_id
                                  AND
                                  odds.id = match_odds.betting_odds_id
                                  AND
                                  oddtypes.id = odds.betting_oddtypes_id
                                GROUP BY
                                  match_odds.id
                                  ORDER BY oddtypes.priority ASC

                              ";


        $odds = $db->rawQuery($qs);
//        print_r($odds);
        return array("code"=>10,"data"=>$this->reArrangeOddsInTypes($odds,$match_id));

    }


    private function reArrangeOddsInTypes($odds,$match_id) {


        $types = array();
        for($i=0;$i<count($odds);$i++) {
            $current = $odds[$i];

            $type_id = $current['type_id'];
            $type_title = $current['type_title'];
            $priority = $current['priority'];
            $status = $current['status'];
            $odd_title = $current['odd_title'];
            $BetradarOddsTypeID = $current['BetradarOddsTypeID'];



            if(!isset($types[$type_id])) {
                $types[$type_id] = array(
                    "id"=>$type_id,
                    "title"=>$type_title,
                    "priority"=>$priority,

                    "BetradarOddsTypeID"=>$BetradarOddsTypeID
                );
            }



            if($current['match_odd_name']!='') {
                $current['title'] = $current['match_odd_name'];
            }
            if(!isset($types[$type_id]['odds'])) {
                $types[$type_id]['odds'] = array();
            }

            array_push($types[$type_id]['odds'],array(
                "id"=>$current['id'],
                "title"=>$current['odd_title'],
                "status"=>$status,
                "ov"=>$current['ov'],
                "sp"=>$current['sp']
            ));

        }



        return array_values($types);
    }


    public function UpdateMatchOdd($match_odd_id,$odd_value) {
        $match_odd_id = (int)$match_odd_id;
        $odd_value = (float)$odd_value;
        $db = $this->db;
        $db->where("id",$match_odd_id);
        $update = $db->update("betting_match_odds",array("oddValue"=>$odd_value));
        if($update!==false) {
            return array("code"=>10);
        }

        return array("code"=>20);
    }


    public function UpdateMatchOddAsWinner($match_odd_id,$match_id) {
        $db = $this->db;
        $oddsGroup = $this->loadService("data/odds")->getOddsTypeGroupByMatchOddId($match_odd_id,$match_id);
        $updated = $db->query("UPDATE betting_match_odds SET status = 3 WHERE id=$match_odd_id");
        $db->rawQuery("UPDATE betting_match_odds SET status = 2 WHERE id IN($oddsGroup[loser_odd_ids])");
    }


    public function UpdateMatchOddStatus($match_odd_id,$match_id,$status_id) {
        $db = $this->db;

        if($status_id == 3) {
            $oddsGroup = $this->loadService("data/odds")->getOddsTypeGroupByMatchOddId($match_odd_id,$match_id);
            $updated = $db->query("UPDATE betting_match_odds SET status = 3 WHERE id=$match_odd_id");
            $update = $db->rawQuery("UPDATE betting_match_odds SET status = 2 WHERE id IN($oddsGroup[loser_odd_ids])");
            if($update!==false) {
                return array("code"=>10);
            }
        }

        elseif($status_id==2) {
            $oddsGroup = $this->loadService("data/odds")->getOddsTypeGroupByMatchOddId($match_odd_id,$match_id);
            $updated = $db->query("UPDATE betting_match_odds SET status = 2 WHERE id=$match_odd_id");
            $update = $db->rawQuery("UPDATE betting_match_odds SET status = 3 WHERE id IN($oddsGroup[loser_odd_ids])");
            if($update!==false) {
                return array("code"=>10);
            }

        }
        elseif($status_id==1) {
            $oddsGroup = $this->loadService("data/odds")->getOddsTypeGroupByMatchOddId($match_odd_id,$match_id);
            $updated = $db->query("UPDATE betting_match_odds SET status = 1 WHERE id=$match_odd_id");
            $update = $db->rawQuery("UPDATE betting_match_odds SET status = 1 WHERE id IN($oddsGroup[loser_odd_ids])");
            if($update!==false) {
                return array("code"=>10);
            }
        }
        return array("code"=>20);

    }

}