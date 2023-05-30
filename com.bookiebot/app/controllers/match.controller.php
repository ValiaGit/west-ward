<?php

if(!defined("APP")) {
    die("No Access!");
}



/**
 * Real Estate Controller
 */
class IMatch extends Controller {

    /**
     * Initialization of real estate main controller
     */
    public function show() {

        //Data To Be Sent To Tpl
        $data = array();

        $match_id = $_GET['intParam'];
        $data['match_id'] = $match_id;

        
        echo $this->render("match.tpl",$data);

    }





}



?>