<?php


if(!defined("APP")) {
    die("No Access!");
}



class Contact extends Controller {


    public function init() {
        $data = array();
        echo $this->render("contact/index.tpl",$data);
    }


}
