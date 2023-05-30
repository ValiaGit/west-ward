<?php


if (!defined('APP')) {
    die();
}


class Sports extends Service
{

    public function getList() {

        $db = $this->db;

        $sports = $db->get("betting_sports",null,"id,title");
        foreach($sports as &$sport) {
            $sport['title'] = $this->getUnserializedTitle($sport['title']);
        }

        return $sports;

    }

}