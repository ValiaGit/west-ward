<?php


if (!defined("APP")) {
	die("Dont have Access");
}



/**
 * Module class to load some custom modules. Has two main methods.
 * 		1) load - loads module class by its name and returns its object to call its methods
 * 		2) output - outputs module Template with passed data to it
 */
abstract class Module {
	
	
	/**
	 * 
	 * Initializes And Returns Module Object
	 * 
	 * @param string $module_name - Module name exmp:(similar_companies)
	 * @return object - Custom module class object;
	 */
	public static function load($module_name) {
		
		$module_class_path = MODULES_DIR."".$module_name."/".$module_name.".class.php";

		//If Module Class File Exists Than load
		if(file_exists($module_class_path)) {
			
			//Require Class File
			require_once $module_class_path;
			
			//Get Class Name
			$ClassName = ucfirst($module_name);
			
			
			//If Class Exists
			if(class_exists($ClassName)) {
				$Object = new $ClassName();
				return $Object;
			}
		}
	}
	

	public static function loadCommon($module_name) {
		$module_class_path = MODULES_DIR."/common/".$module_name."/".$module_name.".class.php";
		
		//If Module Class File Exists Than load
		if(file_exists($module_class_path)) {
			
			//Require Class File
			require_once $module_class_path;
			
			//Get Class Name
			$ClassName = ucfirst($module_name);
			
			
			//If Class Exists
			if(class_exists($ClassName)) {
				$Object = new $ClassName();
				return $Object;
			}
		}
	}
	
	/**
	 * Gets data as parameter passes it to module template 
	 * and than returns output string from TPL
	 * @param array $data - data that should be passed in template
	 * @return string - Contents of template with passed data Array
	 */
	public function output($data = array(),$customTemplate = "",$isCommon) {
		global $tpl;
		$classname = get_class($this);
		if(!$isCommon) {
			if($customTemplate) {
				$module_tpl_path = SKIN_DIR."modules/$classname/$customTemplate.tpl";
				$module_tpl_for_smarty = "modules/$classname/$customTemplate.tpl";
			} else {
				$module_tpl_path = SKIN_DIR."modules/$classname/default.tpl";
				$module_tpl_for_smarty = "modules/$classname/default.tpl";
			}
		} else {
			if($customTemplate) {
				$module_tpl_path = SKIN_DIR."modules/common/$classname/$customTemplate.tpl";
				$module_tpl_for_smarty = "modules/common/$classname/$customTemplate.tpl";
			} else {
				$module_tpl_path = SKIN_DIR."modules/common/$classname/default.tpl";
				$module_tpl_for_smarty = "modules/common/$classname/default.tpl";
			}
		}





		if(file_exists($module_tpl_path)) {
			$tpl->assign("Data",$data);
			return $tpl->fetch($module_tpl_for_smarty);
		}
	}
	
	
	
	
	
}



?>