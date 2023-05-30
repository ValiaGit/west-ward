<?php


if (!defined('APP')) {
    die();
}


class Categories extends Service
{


    /**
     * @param bool $sport_id
     * @param bool $category_id
     * @return array
     */
    public function getCategoriesList($keyWord = "", $category_id = false, $sport_id = false, $is_outright = false)
    {

        //DataBase Object
        $db = $this->db;

        //If Sport ID Was Specified
        $clause = "";
        if ($sport_id) {
            $db->where("betting_sport_id", $sport_id);
        }

        //Filter By Category Id
        if ($is_outright) {
            $db->where("betting_category.has_outright", 1);
        }

        if ($category_id) {
            $db->where("betting_category.id", $category_id);
        }


        $keyWord = $db->escape($keyWord);
        if ($keyWord != "") {
            $db->where("betting_category.title LIKE ?", array("%$keyWord%"));
        }
        $db->where("betting_category.betting_sport_id = betting_sport.id");
        $db->groupBy("id");

        //Request Data
        $data = $db->get(
                            "betting_category,betting_sport",
                             null,
                            "betting_category.id,
                            betting_category.title,
                            betting_category.code,
                            betting_category.betting_sport_id,
                            betting_sport.title as sport_title");




        foreach($data as &$node) {
            $node['sport_title'] = $this->getUnserializedTitle($node['sport_title']);
        }
        //Return Data
        return array("code"=>10,"data"=>$data);
    }


    /**
     * Returns List with  id and name only
     * @param string $keyWord
     * @param bool $category_id
     * @param bool $sport_id
     * @return array
     */
    public function getCategoriesListSelect($keyWord = "", $category_id = false, $sport_id = false,$is_outright = false)
    {

        //DataBase Object
        $db = $this->db;

        $clause = "";
        if ($sport_id) {
            $db->where("betting_sport_id", $sport_id);
        }

        //Filter By Category Id
        if ($category_id) {
            $db->where("betting_category.id", $category_id);
        }

        if ($is_outright) {
            $db->where("betting_category.has_outright", 1);
        }


        $keyWord = $db->escape($keyWord);
        if ($keyWord != "") {
            $db->where("betting_category.title LIKE ?", array("%$keyWord%"));
        }


        $db->where("betting_category.betting_sport_id = betting_sport.id");
        $db->groupBy("betting_category.id");

        //Request Data
        $data = $db->get(
                            "betting_category,betting_sport",
                             null,
                            "betting_category.id,
                            betting_category.title,
                            betting_sport.title as sport_title");




        foreach($data as &$node) {
            $node['title'] = $this->getUnserializedTitle($node['sport_title'])." - ".$this->getUnserializedTitle($node['title']);
            unset($node['sport_title']);
        }



        usort($data, function($a, $b) {
//            return $a['title'] - $b['title'];
            return strcmp($a['title'], $b['title']);
        });

        //Return Data
        return $data;
    }


    /**
     * @param bool $betting_sport_id
     * @param bool $title
     * @param bool $code
     * @return array
     */
    public function add($betting_sport_id = false, $title = false, $code = false)
    {

        $db = $this->db;

        $betting_sport_id = $db->escape($betting_sport_id);
        $title = str_replace('\\','',$title);
        $title = json_encode(json_decode($title));


        $code = $db->escape($code);


        $insert_data = array(
            "betting_sport_id" => $betting_sport_id,
            "title" => $title,
            "code" => $code
        );


        $insert = $db->insert("betting_category", $insert_data);
        if ($insert) {
            $inserted_cat = $this->getCategoriesList("",$insert);
            return array("code" => 10,"data"=>$inserted_cat['data']);
        } else {
            return array("code" => 20);
        }


    }




    /**
     * @param bool $id
     * @param bool $title
     * @param bool $code
     * @return array
     */
    public function edit($id = false, $betting_sport_id = false, $title = false, $code = false)
    {
        $db = $this->db;

        $id = $db->escape($id);
        $betting_sport_id = $db->escape($betting_sport_id);
        $title = str_replace('\\','',$title);
        $title = json_encode(json_decode($title));


        $code = $db->escape($code);

        $update_data = array(
            "betting_sport_id" => $betting_sport_id,
            "title" => $title,
            "code" => $code
        );

        $db->where("id", $id);
        $update = $db->update("betting_category", $update_data);
        if ($update) {
            $updated_cat = $this->getCategoriesList("",$id);
            return array("code" => 10,"data"=>$updated_cat['data']);
        } else {
            return array("code" => 20);
        }


    }


}