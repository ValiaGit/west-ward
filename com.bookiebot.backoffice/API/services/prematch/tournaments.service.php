<?php


if(!defined('APP')) {
    die();
}


class Tournaments extends Service {
    private $db;


    /**
     * @param bool $sport_id
     * @param bool $category_id
     * @return array
     */
    public function getTournamentsList($keyWord = "", $tournament_id = false, $category_id = false, $sport_id = false)
    {

        //DataBase Object
        $db = $this->db;


        //Filter By Category Id
        if ($tournament_id) {
            $db->where("betting_tournament.id", $tournament_id);
        }

        if ($category_id) {
            $db->where("betting_tournament.betting_category_id", $category_id);
        }

        if ($sport_id) {
            $db->where("betting_category.betting_sport_id", $sport_id);
        }


        $keyWord = $db->escape($keyWord);
        if ($keyWord != "") {
            $db->where("betting_tournament.title LIKE ?", array("%$keyWord%"));
        }


        $db->where("betting_tournament.betting_category_id = betting_category.id");
        $db->where("betting_category.betting_sport_id = betting_sport.id");
        $db->groupBy("id");

        //Request Data
        $data = $db->get(
            "
                betting_tournament,
                betting_category,
                betting_sport
            ",
            null,
            "
                betting_tournament.id,
                betting_tournament.status,
                betting_tournament.title,

                betting_category.id as betting_category_id,
                betting_category.title as category_title,
                betting_category.betting_sport_id,
                betting_sport.title as sport_title
            ");


        foreach ($data as &$node) {
            $node['sport_title'] = $this->getUnserializedTitle($node['sport_title']);
            $node['category_title'] = $this->getUnserializedTitle($node['category_title']);
        }

        if(count($data)) {
            return array("code"=>10,"data"=>$data);
        } else {
            return array("code"=>60);
        }

    }


    /**
     *
     */
    public function getTournamentsListSelect($keyWord = "", $tournament_id = false, $category_id = false, $sport_id = false) {
        //DataBase Object
        $db = $this->db;


        //Filter By Category Id
        if ($tournament_id) {
            $db->where("betting_tournament.id", $tournament_id);
        }

        if ($category_id) {
            $db->where("betting_tournament.betting_category_id", $category_id);
        }

        if ($sport_id) {
            $db->where("betting_category.betting_sport_id", $sport_id);
        }


        $keyWord = $db->escape($keyWord);
        if ($keyWord != "") {
            $db->where("betting_tournament.title LIKE ?", array("%$keyWord%"));
        }


        $db->where("betting_tournament.betting_category_id = betting_category.id");
        $db->where("betting_category.betting_sport_id = betting_sport.id");
        $db->groupBy("id");

        //Request Data
        $data = $db->get(
            "
                betting_tournament,
                betting_category,
                betting_sport
            ",
            null,
            "
                betting_tournament.id,
                betting_tournament.status,
                betting_tournament.title
            ");


        foreach ($data as &$node) {
            $node['title'] = $this->getUnserializedTitle($node['title']);

        }

        if(count($data)) {
            return $data;
        } else {
            return array("code"=>60);
        }
    }


    /**
     * @param bool $betting_category_id
     * @param bool $BetradarTournamentId
     * @param bool $title
     * @param bool $is_favourite
     * @param int $status
     * @return array
     */
    public function add($betting_category_id = false, $title = false, $is_favourite = false, $status = 0)
    {

        $db = $this->db;

        $betting_category_id = $db->escape($betting_category_id);


        $title = str_replace('\\','',$title);
        $title = json_encode(json_decode($title));



        $insert_data = array(
            "betting_category_id" => $betting_category_id,
            "is_favourite" => (int)$is_favourite,
            "status" => (int)$status,
            "title" => $title
        );


        $insert = $db->insert("betting_tournament", $insert_data);
        if ($insert) {
            return $this->getTournamentsList("",$insert);
        } else {
            return array("code" => 20);
        }


    }


    /**
     * @param bool $id
     * @param bool $BetRadarCategoryId
     * @param bool $title
     * @param bool $code
     * @return array
     */
    public function edit($id = false, $betting_category_id = false, $title = false, $is_favourite = false, $status = false)
    {
        $db = $this->db;

        $id = $db->escape($id);
        $betting_category_id = $db->escape($betting_category_id);

        $title = str_replace('\\','',$title);
        $title = json_encode(json_decode($title));


        $is_favourite = $db->escape($is_favourite);
        $status = $db->escape($status);

        $update_data = array(
            "betting_category_id" => $betting_category_id,
            "title" => $title,
            "is_favourite" => $is_favourite,
            "status" => $status
        );


        if(!$title) {
            return array(-1000);
        }




        $db->where("id", $id);
        $insert = $db->update("betting_tournament", $update_data);
        if ($insert) {
            return array("code" => 10);
        } else {
            return array("code" => 20);
        }


    }




}