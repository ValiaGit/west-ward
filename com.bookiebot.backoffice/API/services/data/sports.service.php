<?php


if (!defined('APP')) {
    die();
}


class Sports extends Service
{

    /**
     * @param string $keyWord
     * @return array
     */
    public function getSportsList($keyWord = "")
    {
        $db = $this->db;

        $keyWord = $db->escape($keyWord);
        if($keyWord!="") {
            $db->where("title LIKE ?",array("%$keyWord%"));
        }

        $data = $db->get("betting_sport", null, "id,title,code,status");
        $return = array("code" => 10, "data" => $data);
        return $return;
    }


    /**
     * @param bool $sport_id
     * @param bool $odd_type_id
     * @return array
     */
    public function attachOddTypeId($sport_id = false,$odd_type_id = false){
        if(!$sport_id || !$odd_type_id) {
            return array("code"=>50);
        }

        $sport_id = (int)$sport_id;
        $odd_type_id = (int)$odd_type_id;

        $db = $this->db;


        $insert_data = array(
            "betting_sport_id"=>$sport_id,
            "betting_oddtypes_id"=>$odd_type_id
        );

        $insert = $db->insert("betting_sport_has_betting_oddtypes",$insert_data);
        if($insert!==false) {
            return array("code"=>10);
        } else {
            return array("code"=>20);
        }

    }

    /**
     * @param string $keyWord
     * @return array
     */
    public function getSportsListSelect($keyWord = "")
    {
        $db = $this->db;

        $keyWord = $db->escape($keyWord);
        if($keyWord!="") {
            $db->where("title LIKE ?",array("%$keyWord%"));
        }

        $data = $db->get("betting_sport", null, "id,title");
        foreach($data as &$node) {
            $node['title'] = $this->getUnserializedTitle($node['title']);
        }
        return $data;
    }


    /**
     * @param bool $title
     * @param bool $code
     * @param bool $status
     * @return array
     */
    public function add($title = false, $code = false, $status = false)
    {

        $db = $this->db;

        $title = str_replace('\\','',$title);
        $title = json_encode(json_decode($title));


        $code = $db->escape($code);
        $status = $db->escape($status);


        $insert_data = array(
            "title"=>$title,
            "code"=>$code,
            "status"=>$status
        );

        $insert = $db->insert("betting_sport",$insert_data);
        if($insert) {
            return array("code"=>10,"data"=>array(
                "id"=>$insert,
                "title"=>$title,
                "code"=>$code,
                "status"=>$status
            ));
        }

        else {
            echo $db->getLastError();
            return array("code"=>20);
        }


    }



    /**
     * @param bool $id
     * @param bool $title
     * @param bool $code
     * @param bool $status
     * @return array
     */
    public function edit($id = false, $title = false, $code = false, $status = false)
    {


        $db = $this->db;

        $id = $db->escape($id);
        $title = str_replace('\\','',$title);
        $title = json_encode(json_decode($title));
        $code = $db->escape($code);
        $status = $db->escape($status);


        $update_data = array(
            "title"=>$title,
            "code"=>$code,
            "status"=>$status
        );
        $db->where("id",$id);
        $update = $db->update("betting_sport",$update_data);
        if($update) {
            return array("code"=>10,"data"=>array(
                "id"=>$id,
                "title"=>$title,
                "code"=>$code,
                "status"=>$status,
            ));
        } else {
            return array("code"=>20);
        }

    }


    /**
     * @param bool $id
     * @return array
     */
    public function delete($id = false) {
        if(!(int)$id) {
            return array("code"=>50);
        }


        $db = $this->db;
        $db->where("id",$id);
        $remove = $db->delete("betting_sport");
        if($remove!==false) {
            return array("code"=>10);
        } else {
            return array("code"=>20);
        }
    }


}