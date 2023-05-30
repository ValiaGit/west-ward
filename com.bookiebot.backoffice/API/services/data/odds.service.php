<?php



if(!defined('APP')) {
    die();
}


class Odds extends Service {



    public function getOddsList() {

    }


    public function getOddsTypeGroupByMatchOddId($match_odd_id = 0,$match_id = 0) {

        if(!$match_odd_id && !$match_id) {
            $match_odd_id = (int) $_POST['match_odd_id'];
            $match_id = (int) $_POST['match_id'];
        }


        $db = $this->db;
        $data = $db->rawQuery("
                              SELECT
                                betting_match_odds.id as match_odd_id,
                                betting_oddtypes.title,
                                betting_oddtypes.BetradarOddsTypeID
                              FROM
                                betting_odds,
                                betting_match_odds,
                                betting_oddtypes
                              WHERE
                                    betting_match_odds.betting_match_id = $match_id
                                  AND
                                    betting_match_odds.betting_odds_id = betting_odds.id
                                  AND
                                      betting_odds.betting_oddtypes_id = (
                                            SELECT
                                              odds.betting_oddtypes_id
                                            FROM
                                              betting_match_odds match_odds,
                                              betting_odds odds
                                            WHERE
                                                match_odds.id = $match_odd_id
                                                  AND
                                                match_odds.betting_odds_id = odds.id
                                            GROUP BY
                                              odds.id
                                      )
                                  AND
                                    betting_oddtypes.id = betting_odds.betting_oddtypes_id
                                  AND
                                    betting_match_odds.id != $match_odd_id
                              GROUP BY
                                betting_match_odds.id
                              ");

        $return = array();
        $op_ids = "";
        $index = 0;
        foreach($data as $op_id) {

            if($index == count($data)-1) {
                $op_ids.=$op_id['match_odd_id'];
            } else {
                $op_ids.=$op_id['match_odd_id'].",";
            }

            $index++;

        }

        $return['count'] = count($data);
        $return['type_name'] = @$data[0]['title'];
        $return['loser_odd_ids'] = $op_ids;




        return $return;
    }



    public function getConfiguration() {
//
//        require_once ROOT_DIR."/API/config.json";
//
//        return false;

        $db = $this->db;
        $typeData = $db->rawQuery("
                SELECT
                   betting_odds.id as odd_id,
                   betting_odds.title as odd_name,
                   betting_oddtypes.id as type_id,
                   betting_oddtypes.title as type_name,
                   betting_oddtypes.TeamReplace as tr,
                   betting_oddtypes.priority as pr
                FROM
                  betting_oddtypes
                INNER JOIN
                  betting_odds
                ON
                  betting_oddtypes.id = betting_odds.betting_oddtypes_id
        ");
//return $typeData;
        $typeInfo = array();
        foreach($typeData as $index=>$odd) {

            if(!isset($typeInfo[$odd['type_id']])) {
                $typeInfo[$odd['type_id']] = array(
                    "n"=>$odd['type_name'],
                    "tr"=>$odd['tr'],
                    "pr"=>$odd['pr'],
                    "odds"=>array()
                );
            }
            if(!isset($typeInfo[$odd['type_id']]['odds'][$odd['odd_id']])) {
                $typeInfo[$odd['type_id']]['odds'][$odd['odd_id']] = array(
                    'n'=>$odd['odd_name']
                );
            }
        }


        $return = array(
            "typeInfo"=>$typeInfo,
            "groups"=>array(),
            "sports"=>array(
                "336"=>1,
                "337"=>4,
                "340"=>4,
                "343"=>4,
                "344"=>4,
                "358"=>4,
                "357"=>4,
                "339"=>1,
                "352"=>1,
                "347"=>4,
                "338"=>4,
                "354"=>1
            )
        );
        return $return;

    }



}