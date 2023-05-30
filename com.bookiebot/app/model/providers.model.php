<?php

if (!defined("APP")) {
    die("No Access");
}


class Providers_Model extends Model
{


    public function getList($type = 1) {
        global $lang;
        global $db;
        $db->where('type',$type);
        $db->where('status',1);
        return $db->get("money_providers",null,"id,title,image_path,min_amount,max_amount,commission,instructions,class_name,has_accounts,provider_image_path,provider_website_path");
    }



}