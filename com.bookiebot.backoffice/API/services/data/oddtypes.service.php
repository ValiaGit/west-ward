<?php


if (!defined('APP')) {
    die();
}


class Oddtypes extends Service
{


    public function getOddTypesList($sport_id = 0)
    {

        $db = $this->db;


        if (!$sport_id) {
            return array("code"=>50);
        }


        $data = $db->rawQuery("SELECT
                                     oddtypes.id,
                                     oddtypes.title,
                                     oddtypes.status,
                                     oddtypes.priority
                              FROM
                                betting_oddtypes oddtypes,
                                betting_sport_has_betting_oddtypes sport_has_oddtypes
                              WHERE
                                oddtypes.id = sport_has_oddtypes.betting_oddtypes_id
                                AND
                                sport_has_oddtypes.betting_sport_id = $sport_id
        ");

        return array("code" => 10, "data" => $data);

    }


}