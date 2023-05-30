<?php


if(!defined('APP')) {
    die();
}



/**
 * This class provides access to data that is public for users and doesnt need authentication
 **/
class Countries extends Service {



    public function getList() {
        $db = $this->db;


        $data = $db->get("core_countries",null,"id,short_name,calling_code,iso2,iso3");

        foreach($data as  &$country) {
            $country['short_name'] = ($country['short_name']);
        }

        if(count($data)) {
            return array("code"=>10,"data"=>$data);
        }

        else {
            return array("code"=>60);
        }


    }


}