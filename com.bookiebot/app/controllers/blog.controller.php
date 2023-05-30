<?php


if(!defined("APP")) {
    die("No Access!");
}



class Blog extends Controller {


    public function init() {
        $data = array();



        echo $this->render("blog/index.tpl",$data);
    }


}

