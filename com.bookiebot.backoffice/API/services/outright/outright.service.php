<?php


if(!defined('APP')) {
    die();
}


class Outright extends Service {


    /**
     * @param bool $outright_id
     * @param bool $category_id
     * @param string $title
     * @return array
     */
    public function getOutrightTournaments($outright_id = false,$category_id = false, $title = "") {


        //Database Instance
        $db = $this->db;

        /**
         *
         */
        if($outright_id) {
            $db->where("id",$outright_id);
        }

        /**
         *
         */
        if($category_id) {
            $db->where("betting_category_id",$category_id);
        }


        /**
         *
         */
        if($title) {
            $db->where("title LIKE '%?%'",$title);
        }




        //Get Data
        $data = $db->get("betting_outright",null,"id,title,betting_category_betting_sport_id as sport_id,EventDate,status");
        if(count($data)) {
            return array("code"=>10,"data"=>$data);
        } else {
            return array("code"=>60);
        }

    }


    /**
     * @param bool $outright_id
     * @param bool $category_id
     * @param string $title
     * @return array
     */
    public function getOutrightTournamentsListSelect($outright_id = false,$category_id = false, $title = "") {


        //Database Instance
        $db = $this->db;

        /**
         *
         */
        if($outright_id) {
            $db->where("id",$outright_id);
        }

        /**
         *
         */
        if($category_id) {
            $db->where("betting_category_id",$category_id);
        }


        /**
         *
         */
        if($title) {
            $db->where("title LIKE '%?%'",$title);
        }



        //Get Data
        $data = $db->get("betting_outright",null,"id,title,status,betting_category_id");
        if(count($data)) {
            foreach($data as &$node) {
                $node['title'] = $this->getUnserializedTitle($node['title']);
            }
            return $data;
        } else {
            return array("code"=>60);
        }

    }



    /**
     * @param bool $outright_id
     * @return array
     */
    public function getOutrightOdds($filter = array()) {

        $db = $this->db;

        $db = $this->db;
        if(!isset($filter['tournament_id'])) {
            if(!isset($filter['matches_id'])) {
                return array("code"=>50);
            }

        }
        $clause = $this->setFilters($filter);



//
//        $db->where("betting_outright_odds.betting_outright_id",$tournament_id);
//        $db->where("betting_outright_odds.betting_outright_competitors_id = betting_outright_competitors.id");
//        $db->groupBy("betting_outright_odds.id");
//        $data = $db->get(
//                            "
//                                betting_outright_odds,
//                                betting_outright_competitors
//                            ",
//                            null,
//                            "
//                                betting_outright_odds.id as ourtight_odd_id,
//                                betting_outright_competitors.title
//                            "
//        );
//
//
//
//        foreach($data as &$node) {
//            $node['title'] = $this->getUnserializedTitle($node['title']);
//        }


        return $data;




    }


    public function addOutrightTournament() {

    }



}