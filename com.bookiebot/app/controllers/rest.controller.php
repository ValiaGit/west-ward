<?php


if(!defined("APP")) {
    die("No Access!");
}



class Rest extends Controller {


    public function init() {
        $data = array();



        echo $this->render("rest.tpl",$data);
    }


}

?>