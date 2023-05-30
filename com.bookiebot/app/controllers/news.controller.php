<?php


if(!defined("APP")) {
    die("No Access!");
}



class News extends Controller {


    public function init() {
        $data = array();


        echo $this->render("news/index.tpl",$data);
    }


    public function show() {
        $data = array();
        $id = (int) $_GET['intParam'];
        echo $this->render("news/show.tpl",$data);
    }


}
