<?php


if(!defined('APP')) {
    die();
}


class Providers extends Service {



    public function getProvidersList() {
        $db = $this->db;
        $return = array("code"=>10,"data"=> $db->get("money_providers",null,"*"));
    }


}