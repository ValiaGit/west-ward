<?php


if(!defined('APP')) {
    die();
}

/**
 * Class Matches
 */
class Odds extends Service {

    /**
     * Gets Match id As Parameters And Returns Arranged Odds For That Match
     * @param $match_id
     * @return array
     */
    public function getOddsByMatchId($match_id = 0) {
        if(!$match_id) {
            $match_id = (int) $_POST['match_id'];
        }

        $db = $this->db;
        $odds = $db->rawQuery("
                                SELECT
                                    match_odds.id,
                                    match_odds.match_odd_name,
                                    odds.id as odd_id,
                                    odds.title,
                                    match_odds.SpecialBetValue as sp,
                                    match_odds.oddValue as ov,
                                    odds.betting_oddtypes_id as type_id

                                FROM
                                  betting_match_odds match_odds,
                                  betting_odds odds

                                WHERE
                                  match_odds.betting_match_id = $match_id
                                  AND
                                  odds.id = match_odds.betting_odds_id
                                  AND
                                  match_odds.status = 1
                                GROUP BY
                                  match_odds.id

                              ");

        return $this->reArrangeOddsInTypes($odds,$match_id);
    }



    /**
     * Gets Only Main Odds For Match That is specified for match sport
     * @param $match_id
     * @return array
     */
    public function getMainOddsByMatchId($match_id = 0) {

        if(!$match_id) {
            $match_id = (int) $_POST['match_id'];
        }
        $match_id = (int)$match_id;




        $db = $this->db;
        $qs = " SELECT
                                    match_odds.id,
                                    match_odds.match_odd_name,
                                    odds.title,
                                    odds.id as odd_id,
                                    match_odds.SpecialBetValue as sp,
                                    match_odds.oddValue as ov,
                                    odds.betting_oddtypes_id as type_id
                                FROM
                                  betting_match_odds match_odds,
                                  betting_odds odds,
                                  betting_oddtypes odd_types,
                                  betting_sport_has_betting_oddtypes sport_has_oddtypes,
                                  betting_sport sport
                                WHERE
                                  match_odds.betting_match_id = $match_id
                                  AND
                                  odds.id = match_odds.betting_odds_id
                                  AND
                                  sport_has_oddtypes.betting_sport_id = sport.id
                                  AND
                                  sport_has_oddtypes.betting_oddtypes_id = odd_types.id
                                  AND sport_has_oddtypes.basic = 1
                                  AND
                                  odds.betting_oddtypes_id = odd_types.id
                                  AND
                                  match_odds.status = 1
                                GROUP BY
                                  match_odds.id";
//        var_export($qs);
        $odds = $db->rawQuery($qs);


        return $this->reArrangeOddsInTypes($odds,$match_id);
    }


    /**
     * Get Odd Types By Match and odd_type_id, For Example Get 2-Way Odds on Match Barca Real
     * @param $match_id
     * @param $odd_type_id
     * @return array
     */
    public function getOddsByTypeAndMatchID($match_id,$odd_type_id) {
          $db = $this->db;
          if(!$match_id && !$odd_type_id) {
              $match_id = (int) $db->escape($_POST['match_id']);
              $odd_type_id = (int) $db->escape($_POST['type_id']);
          }


          $data = $db->rawQuery("
                SELECT

                                    match_odds.id,
                                    match_odds.match_odd_name,
                                    odds.id as odd_id,
                                    odds.title,
                                    match_odds.SpecialBetValue as sp,
                                    match_odds.oddValue as ov,
                                    odds.betting_oddtypes_id as type_id


                FROM
                  betting_match matches,
                  betting_match_odds match_odds,
                  betting_odds odds,
                  betting_oddtypes odd_types
                WHERE
                  matches.id = ?
                    AND
                  odd_types.id = ?
                    AND
                  match_odds.betting_match_id = matches.id
                    AND
                  odds.id = match_odds.betting_odds_id
                    AND
                  odd_types.id = odds.betting_oddtypes_id
                    AND
                  match_odds.status = 1
                    AND
                  matches.status = 1
          ",array($match_id,$odd_type_id));


        return $this->reArrangeOddsInTypesForTypeRefresh($data,$match_id);

    }




    /**
     * Gets Raw Odds Data That Match Has And Return Them Arranged
     * @param $odds
     * @param $match_id
     * @return array
     */
    private function reArrangeOddsInTypes($odds,$match_id) {


        $types = array();
        for($i=0;$i<count($odds);$i++) {
            $current = $odds[$i];

            $type_id = $current['type_id'];

            $BetsService = $this->loadService("betting/bets");
            $bet_data = $BetsService->getBetsDataByOddID($current['id'],$match_id);



            if(!isset($types[$type_id])) {
                $types[$type_id] = array("status"=>1,"odds"=>array());
            }

            $types[$type_id]['matched'] = (int)$BetsService->getMarketDataByMatchAndOddTypeId($match_id,$type_id);


            if($current['match_odd_name']!='') {
                $current['title'] = $current['match_odd_name'];
            }
            $types[$type_id]['odds'][$current['id']] = array(
                "id"=>$current['odd_id'],
                "sb"=>$current['sp'],
                "ov"=>$current['ov'],
                "l"=>$bet_data['availableLays'],
                "b"=>$bet_data['availableBacks']
            );


        }


//        print_r($types);

        return $types;
    }


    /**
     * @param $odds
     * @param $match_id
     * @return array
     */
    private function reArrangeOddsInTypesForTypeRefresh($odds,$match_id) {


        $return = array(
            "status"=>1,
            "odds"=>array()
        );
        for($i=0;$i<count($odds);$i++) {
            $current = $odds[$i];

            $type_id = $current['type_id'];

            $BetsService = $this->loadService("betting/bets");
            $bet_data = $BetsService->getBetsDataByOddID($current['id'],$match_id);



            $return['matched'] = (int)$BetsService->getMarketDataByMatchAndOddTypeId($match_id,$type_id);



            if($current['match_odd_name']!='') {
                $current['title'] = $current['match_odd_name'];
            }
            $return['odds'][$current['id']] = array(
                "id"=>$current['odd_id'],
                "sb"=>$current['sp'],
                "ov"=>$current['ov'],
                "l"=>$bet_data['availableLays'],
                "b"=>$bet_data['availableBacks']
            );


        }


//        print_r($types);

        return $return;
    }



    /**
     * This Return Array Of Opponent Odd_ids
     * For Example:
     *          If User Bets Back Bet on Brazil To Win With (selection 1) This Should Return Back Odd For Opponent To Win
     * @param int $match_odd_id
     * @param int $match_id
     * @return array
     */
    public function getOddsTypeGroupByMatchOddId($match_odd_id = 0,$match_id = 0) {

        if(!$match_odd_id && !$match_id) {
            $match_odd_id = (int) $_POST['match_odd_id'];
            $match_id = (int) $_POST['match_id'];
        }


        $db = $this->db;
        $data = $db->rawQuery("
                              SELECT
                                betting_match_odds.id as match_odd_id,
                                betting_oddtypes.title
                              FROM
                                betting_odds,
                                betting_match_odds,
                                betting_oddtypes
                              WHERE
                                  betting_match_odds.betting_match_id = ?
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
                                            match_odds.id = ?
                                              AND
                                            match_odds.betting_odds_id = odds.id
                                        GROUP BY
                                          odds.id
                                  )
                                  AND
                                  betting_match_odds.status = 1
                                  AND
                                  betting_oddtypes.id = betting_odds.betting_oddtypes_id
                                  AND
                                  betting_match_odds.id != ?
                              GROUP BY
                                betting_match_odds.id
                              ",array($match_id,$match_odd_id,$match_odd_id));

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



    /**
     * Get Configuration Of Odd
     * @return array
     */
    public function getConfiguration() {

        $db = $this->db;
        $typeData = $db->rawQuery("
                SELECT
                   odds.id as odd_id,
                   odds.title as odd_name,
                   oddtypes.id as type_id,
                   oddtypes.title as type_name,
                   oddtypes.TeamReplace as tr,
                   oddtypes.priority as pr,

                   sport_has_types.betting_sport_id
                FROM
                  betting_oddtypes oddtypes

				INNER JOIN
                  betting_odds odds
                  ON
                oddtypes.id = odds.betting_oddtypes_id

              LEFT JOIN
                betting_sport_has_betting_oddtypes sport_has_types
                ON
                sport_has_types.betting_oddtypes_id = oddtypes.id
                AND
                sport_has_types.basic = 1
        ");

        $return = array(
            "typeInfo"=>array(),
            "sports"=>array()
        );

        $typeInfo = array();
        $sportBasicInfo = array();
        foreach($typeData as $index=>$odd) {
            if(isset($odd['betting_sport_id'])) {
                if($odd['betting_sport_id']) {
                    $sportBasicInfo[$odd['betting_sport_id']] = $odd['type_id'];
                }
            }

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
        $return['typeInfo'] = $typeInfo;
        $return['sports'] = $sportBasicInfo;



        return $return;

    }







}