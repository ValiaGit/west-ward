<?php


class Model {
	
	function __construct() {
		global $db;
		$this->db = $db;
	}
	
	


    protected function escapeString(&$unescapedDtring) {
        $unescapedDtring = trim($unescapedDtring);
        $unescapedDtring = mysql_real_escape_string($unescapedDtring);
        return $unescapedDtring;
    }


    protected function loadApiService($service_name) {
        $service_path = SERVICE_DIR;

        //Base API Classes
        require_once API_DIR."/engine/Service.php";
        require_once API_DIR."/engine/Api.class.php";
        @$_POST['user_id'] = $_SESSION['user']['id'];
        $api = new API(false);
        return $api->GetServiceInstance($service_name);


    }

	protected function load($modelName) {

			$modelPath = MODEL_DIR.$modelName;
			$modelPath = explode(".",$modelPath);
			
			$className = explode("/",$modelPath[0]);
			$className = end($className);
			$className = ucfirst($className);
			
			$modelPath = $modelPath[0].".model.php";
			
			if(file_exists($modelPath)) {
				require_once $modelPath;
				
				$className = $className."_model";
				if(class_exists($className)) {
					$object = new $className();
					return $object;
				}
			}
	}
}

?>