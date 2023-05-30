<?php

if (!defined("APP")) {
    die("No Access");
}


class Countries_Model extends Model
{


   public function getList() {
        global $lang;
       global $db;

       return $db->get("core_countries",null,"id,short_name,calling_code");
   }



}