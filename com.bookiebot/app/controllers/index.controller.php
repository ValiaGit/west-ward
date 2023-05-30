<?php

if(!defined("APP")) {
    die("No Access!");
}



/**
 * Real Estate Controller
 */
class Index extends Controller {
	
	/**
	 * Initilization of real estate main controller
	 */
	public function init() {
        global $facebook;
		$data = array();


        if(isset($_SESSION['fb_redirect_state'])) {
            $user = $facebook->getUser();
            $redirect_page = $_SESSION['fb_redirect_state'];
            unset($_SESSION['fb_redirect_state']);
            header("Location: $redirect_page");
            exit;
        }

        $data['where_am_i'] = "bookmakers";

        if($_SERVER['REMOTE_ADDR'] == "221.251.140.138" || $_SERVER['REMOTE_ADDR'] == "210.160.37.26") {
            echo $this->render("under.tpl",$data);
        } else {
            echo $this->render("index.tpl",$data);
        }

	}



	

	
	
	
}



?>