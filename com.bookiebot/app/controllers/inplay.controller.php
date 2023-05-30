<?php

if(!defined("APP")) {
    die("No Access!");
}



/**
 * Real Estate Controller
 */
class Inplay extends Controller {

    /**
     * Initilization of real estate main controller
     */
    public function init() {
            echo $this->render("inplay.tpl");
    }








}



?>