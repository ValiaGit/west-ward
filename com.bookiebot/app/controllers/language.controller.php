<?php

if(!defined("APP")) {
    die("No Access!");
}



/**
 * Real Estate Controller
 */
class Language extends Controller {
	
	/**
	 * Initilization of real estate main controller
	 */
	public function init() {
		global $langPackage;
        header('Content-Type: application/javascript');
		echo "var lang_arr = ".json_encode($langPackage);
	}
	
	
}



?>