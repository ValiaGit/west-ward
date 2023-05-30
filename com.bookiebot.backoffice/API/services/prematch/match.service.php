<?php


if (!defined('APP')) {
    die();
}


class IMatch extends Service
{
    private $db;

    /**
     * @param array $filter
     * @return array
     */
    public function getMatchesList($skip = false, $pageSize = 10,$filter = array())
    {

        $db = $this->db;



        $skip = (int)$skip;
        $pageSize = (int)$pageSize;


        $clause = $this->ReturnKendoFilterClause($filter,true);


        $qs = "
                SELECT
                  matches.id as matches__id,
                  matches.BetradarMatchId as matches__BetradarMatchId,
                  matches.BetFairEventId as matches__BetFairEventId,

                  matches.score_data as matches_score_data,
                  matches.status as matches_status,
                  matches.top as matches_top,
                  DATE_FORMAT(matches.starttime, '%Y-%m-%dT%TZ') as matches_starttime,



                  competitors1.title as home,
                  competitors1.id as competitors1_id,

                  competitors2.title as away,
                  competitors2.id as competitors2_id,

                  tournament.title as tTitle,
                  tournament.id as tID,

                  category.title as cTitle,
                  category.id as cID,

                  sport.title as sTitle,
                  sport.id as sID


                FROM
                
                  betting_sport sport,
                  betting_category category,
                  betting_tournament tournament,
                  betting_match matches,
                  betting_competitors competitors1,
                  betting_competitors competitors2


                WHERE
                  matches.betting_tournament_id = tournament.id
                  AND
                  category.id = tournament.betting_category_id
                  AND
                  sport.id = category.betting_sport_id
                  AND
                  competitors1.id = matches.betting_competitors_id
                  AND
                  competitors2.id = matches.betting_competitors_id1

                  $clause
               GROUP BY
                  matches.id
               ORDER BY
                  matches.starttime
               ASC
               LIMIT $pageSize OFFSET $skip
        ";
//        echo $qs;
        $data = $db->rawQuery($qs);


        foreach ($data as &$node) {
            $node['home'] = $this->getUnserializedTitle($node['home']);
            $node['away'] = $this->getUnserializedTitle($node['away']);
            $node['tTitle'] = $this->getUnserializedTitle($node['tTitle']);
            $node['cTitle'] = $this->getUnserializedTitle($node['cTitle']);
            $node['sTitle'] = $this->getUnserializedTitle($node['sTitle']);
        }

        return array("code" => 10, "data" => $data,"total"=>1000);


    }


    /**
     * @param bool $tournament_id
     * @param bool $competitor1_id
     * @param bool $competitor2_id
     * @param bool $sport_id
     * @param bool $category_id
     * @param bool $starttime
     * @return array
     */
    public function addMatch($tournament_id = false, $sport_id = false, $category_id=false, $competitors1_id = false, $competitors2_id = false, $matches_starttime = false,$type=false,$matches_status = false,$matches_top = 0)
    {

        if(!$tournament_id || !$competitors1_id || !$competitors2_id || !$matches_starttime) {
            return array("code"=>-10,"msg"=>"Wrong Parameters");
        }



        $matches_starttime = str_replace("Z","",$matches_starttime);
        $matches_starttime = str_replace("T","",$matches_starttime);
        $time = strtotime($matches_starttime);

        $final_time = date('Y-m-d H:i:s',$time);

        $insert_data = array(
            "betting_tournament_id" => (int)$tournament_id,
            "betting_sport_id" => (int)$sport_id,
            "betting_category_id" => (int)$category_id,
            "betting_competitors_id" => (int)$competitors1_id,
            "betting_competitors_id1" =>(int) $competitors2_id,
            "top" =>(int) $matches_top,
            "starttime" => $final_time,
            "type" => 1,
            "status" => $matches_status
        );

        $db = $this->db;
        $insert = $db->insert("betting_match", $insert_data);

        if ($insert) {
            return $this->getMatchesList(false,10,array("matches_id"=>$insert));
        }

        else {
            return array("code" => 20);
        }

    }


    /**
     * @param bool $matches_id
     * @param bool $tournament_id
     * @param bool $competitors1_id
     * @param bool $competitors2_id
     * @param bool $sport_id
     * @param bool $category_id
     * @param bool $matches_starttime
     * @param int $type
     * @param int $matches_status
     * @return array
     */
    public function updateMatch($matches__id = false, $tournament_id = false, $competitors1_id = false, $competitors2_id = false, $sport_id = false, $category_id = false, $matches_starttime = false, $type=1, $matches_status = 0,$matches_top = 0) {

        if(!$matches__id) {
            return array("code"=>-10,"msg"=>"Wrong Parameters");
        }

        $db = $this->db;

        $matches_starttime = str_replace("Z","",$matches_starttime);
        $matches_starttime = str_replace("T","",$matches_starttime);
        $time = strtotime($matches_starttime);

        $final_time = date('Y-m-d H:i:s',$time);



//        return $final_time;

        $update_data = array(
            "betting_competitors_id" => (int) $competitors1_id,
            "betting_competitors_id1" =>(int) $competitors2_id,
            "starttime" => $final_time,
            "top" => $matches_top,
            "status" => $matches_status
        );


//        return $update_data;
        $db->where("id",$matches__id);
        $update = $db->update("betting_match",$update_data);


        if($update) {
            return $this->getMatchesList(array("matches_id"=>$matches__id));
        } else {
            echo $db->getLastError();
            return array("code"=>20);
        }


    }



    /**
     *
     */
    public function delete($matches_id) {

        $matches_id = (int)$matches_id;

        $db = $this->db;

        $db->where("betting_match_id",$matches_id);
        $db->delete("betting_match_odds");

        $db->where("id",$matches_id);
        $delete = $db->delete("betting_match");
        if($delete) {
            return array("code"=>10);
        }
        echo $db->getLastError();
        return array("code"=>20);
    }


    /**
     * @param $match_id
     * @param $odd_type_id
     * @return array
     */
    public function addOddType($match_id = false, $odd_type_id = false)
    {

        $db = $this->db;

        $db->where("id", $match_id);
        $match_exists = $db->getOne("betting_match", "1");
        if (!$match_exists) {
            return array("code" => -20);
        }


        $db->where("betting_oddtypes_id", $odd_type_id);
        $odds = $db->get("betting_odds");

        //If Found Odds For OddType
        if (count($odds)) {
            $inserted_data = array();
            //Iterate Over Odds That Should Be Added To Match
            foreach ($odds as $odd) {
                $match_odd_insert_data = array(
                    "betting_match_id" => $match_id,
                    "betting_odds_id" => $odd['id'],
                    "status" => 1,
                    "oddValue" => "",
                    "match_odd_name" => ""
                );


                $db->where('betting_match_id',$match_id);
                $db->where('betting_odds_id',$odd['id']);
                $exists = $db->getOne("betting_match_odds","1");

                if(!$exists) {
                    $insert_odds = $db->insert("betting_match_odds", $match_odd_insert_data);
                    if($insert_odds) {
                        $inserted_data[$insert_odds] = $odd['id'];
                    } else {
                        echo $db->getLastError();
                    }
                }




            }

            return array("code" => 10, "inserted" => $inserted_data);

        } else {
            return array("code" => 20);
        }


    }

    public function disableOddTypeOnMatch($match_id = 0,$odd_type_id = 0) {

         if(!$match_id || !$odd_type_id) {
             return array("code"=>50);
         }



        $db = $this->db;


        $update = $db->rawQuery("
                UPDATE
                    betting_match_odds match_odds
                INNER JOIN
                  betting_odds odds
                    ON
                  odds.id = match_odds.betting_odds_id
                    AND
                  odds.betting_oddtypes_id = $odd_type_id
                    AND
                  match_odds.betting_match_id = $match_id
                SET
                  match_odds.status = 0
        ");


        if($update['update'] == true) {
            return array("code"=>10);
        } else {
            return array("code"=>30);
        }


    }

    public function suspendOddTypeOnMatch($match_id = 0,$odd_type_id = 0) {

        if(!$match_id || !$odd_type_id) {
            return array("code"=>50);
        }


        $db = $this->db;


        $update = $db->rawQuery("
                UPDATE
                    betting_match_odds match_odds
                JOIN
                  betting_odds odds
                    ON
                  odds.id = match_odds.betting_odds_id
                    AND
                  odds.betting_oddtypes_id = $odd_type_id
                    AND
                  match_odds.betting_match_id = $match_id
                SET
                  match_odds.status = 2
        ");


        if($update['update'] == true) {
            return array("code"=>10);
        } else {
            return array("code"=>30);
        }


    }

    public function enableOddTypeOnMatch($match_id = 0,$odd_type_id = 0) {

        if(!$match_id || !$odd_type_id) {
            return array("code"=>50);
        }


        $db = $this->db;
        $update = $db->rawQuery("
                UPDATE
                    betting_match_odds match_odds
                JOIN
                  betting_odds odds
                    ON
                  odds.id = match_odds.betting_odds_id
                    AND
                  odds.betting_oddtypes_id = $odd_type_id
                    AND
                  match_odds.betting_match_id = $match_id
                SET
                  match_odds.status = 1
        ");


        if($update['update'] == true) {
            return array("code"=>10);
        } else {
            return array("code"=>30);
        }


    }







}