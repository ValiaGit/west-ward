<?php


if (!defined("APP")) {
	die("Dont have Access");
}

/**
 * This class has two methods. 
 * Every Controller needs data to manipulate(model) and then pass this data to template(TPL)
 * and render to user.
 * 
 * 		1) loadModel - loads model to get model data
 * 		2) render - loads template and passes data loaded by model
 */

class Controller {

    /**
     * @var int
     */
	protected $user = 0;


    /**
     *
     */
	public function __construct() {
		
		global $config;
		global $lang;
		global $langN;
		
		$this->config = $config;
		$this->lang = $lang;
		$this->langN = $langN;
	}
	
	
	/**
	 * This method should be implemented 
	 * in every controller representation
	 */
	public function init() {
		global $user;
		$this->user = $user;
		//This variable passes data in .TPL file
		$data = array();
	}
	
	
	
	/**
	 * Renders Content of Controller
	 * @param string $controller - example (main/company/company.tpl or main/company/tab.tpl)
	 * @param array $data - The data that should be passed in TPL
	 * 
	 * @return string - Content of specified TPL file with its data
	 */
	public function render($controller,$data = array()) {
		
		global $tpl;
        global $config;

        if(!isset($data['modules'])) {
            $data['modules'] = array();
        }
        $common_modules = $config['common_modules'];
        $explodedCommons = explode(",",$common_modules);
        foreach($explodedCommons as $module) {
            $moduleData = Module::loadCommon($module)->init();
            $data['modules'][$module] = $moduleData;
        }


		$tpl->assign("Data",$data);
		
		//Template File
		$tpl_path = SKIN_DIR."/view/".$controller;

		if(file_exists($tpl_path)) {
            //require_once($tpl_path);
			return $tpl->fetch("view/".$controller);
		}

	}
	
	
	
	/**
	 * Loads Model By Model Name returns objects and we can call its methods
	 * 
	 * @param string $modelName - example(main/category) loads category model in which we can call category table
	 * @return object - Model Object to call its methods
	 */
	public static function loadModel($modelName) {
			

			$modelPath = MODEL_DIR.$modelName;




			$className = explode("/",$modelPath);
			$className = end($className);
			$className = ucfirst($className);


			$modelPath = $modelPath.".model.php";

			if(file_exists($modelPath)) {

				require_once $modelPath;
				
				$className = $className."_model";
				if(class_exists($className)) {
					$object = new $className();
					return $object;
				}
			}
	}


    /**
     * @param $service_name
     * @return mixed
     */
    protected function loadApiService($service_name) {
        $service_path = SERVICE_DIR;

        //Base API Classes
        require_once API_DIR."/engine/Service.php";
        require_once API_DIR."/engine/Api.class.php";
        @$_POST['user_id'] = $_SESSION['user']['id'];
        $api = new API(false);
        return $api->GetServiceInstance($service_name);
    }


    /**
     *
     */
    protected function callServiceMethod($service,$method,$parameters) {
        global $config;
        $api_url = $config['api_url'];

        $url_to_call = $api_url."/$service/$method.sr";

        //Open the Curl session
        $session = curl_init($url_to_call);

        // If it's a GET, put the GET data in the body

            //Iterate Over GET Vars
            $postvars = '';
            foreach($parameters as $key=>$val) {
                    $postvars.="$key=$val&";
            }
            curl_setopt ($session, CURLOPT_POST, true);
            curl_setopt ($session, CURLOPT_POSTFIELDS, $postvars);


        curl_setopt($session, CURLOPT_HEADER, false);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

        // EXECUTE
        $json = curl_exec($session);
        curl_close($session);
        return $json;

    }

	
	
}



?>