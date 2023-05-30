<?php


if(!defined('APP')) {
    die();
}


class Outright_competitors extends Service {


    /**
     * @param bool $sport_id
     * @param string $competitor_title
     * @param bool $BetradarCompetitorId
     * @return array
     */
    public function getCompetitorsList($skip = false, $take = false, $filter = array()) {

        $db = $this->db;



        $skip = (int)$skip;
        $take = (int)$take;

        $clause = "";

        $filters_array = $filter['filters'];
        foreach($filters_array as $cur_filter) {
            $field = $cur_filter['field'];
            $value = $cur_filter['value'];

            switch($field) {
                case "sport_id":
                    $clause .= " AND betting_sport.id = $value";
                    break;
                case "title":
                    $clause .= " AND betting_competitors.title LIKE '%$value%'";
                    break;
                case "id":
                    $clause .= " AND betting_competitors.id = $value";
                    break;
            }

        }

        $limit = "";
        if($skip!==false && $take!==false) {
            $limit = "LIMIT $skip,$take";
        }

        $qs = "
            SELECT
              betting_competitors.id as id,
              betting_competitors.BetradarCompetitorId,
              betting_competitors.title as title,
              betting_sport.title as sport_title,
              betting_competitors.image_path as competitor_image

            FROM
              betting_competitors,
              betting_sport
            WHERE
              betting_sport.id = betting_competitors.betting_sport_id
            $clause $limit";

        $competitors = $db->rawQuery($qs);

//        print_r($qs);
        if(count($competitors)) {
            return array("code"=>10,"data"=>$competitors,"total"=>1000);
        } else {
            return array("code"=>60);
        }





    }



    /**
     * @param string $keyWord
     * @return array
     */
    public function getCompetitorsListSelect($keyWord = "") {
        $db = $this->db;

        $keyWord = $db->escape($keyWord);
        if($keyWord!="") {
            $db->where("title LIKE ?",array("%$keyWord%"));
        }

        $data = $db->get("betting_competitors", null, "id,title");
        foreach($data as &$node) {
            $node['title'] = $this->getUnserializedTitle($node['title']);
        }
        return $data;
    }



    /**
     * @param bool $betting_sport_id
     * @param string $title
     * @return array
     */
    public function add($betting_sport_id = false,$title = "") {
        $db = $this->db;


        $betting_sport_id = (int) $betting_sport_id;
        $title = str_replace('\\','',$title);
        $title = json_encode(json_decode($title));


        $insert_data = array(
            "betting_sport_id"=>$betting_sport_id,
            "title"=>$title
        );

        $competitor_id = $db->insert("betting_competitors",$insert_data);
        if($competitor_id) {
            $inserted_competitor = $this->getCompetitorsList(false,false,$competitor_id);
            return array("code"=>10,"data"=>$inserted_competitor['data']);
        } else {
            return array("code"=>20);
        }

    }



    /**
     * @param bool $id
     * @param bool $betting_sport_id
     * @param string $title
     * @return array
     */
    public function edit($id = false,$betting_sport_id = false,$title = "") {

        $id = (int) $id;

        $db = $this->db;

        $title = str_replace('\\','',$title);
        $title = json_encode(json_decode($title));


        $update_data = array(
            "betting_sport_id"=>(int)$betting_sport_id,
            "title"=>$title
        );

        $db->where("id",$id);
        $update = $db->update("betting_competitors",$update_data);
        if($update !== false) {
            return array("code"=>10,"data"=>array(
                "id"=>(int)$id,
                "betting_sport_id"=>(int)$betting_sport_id,
                "title"=>$title
            ));
        }
        return array("code"=>20);

    }


}