<?php
	if(!defined('APP')) {
		die();
	}



class Dispatcher {
	
	//Address Of Folder Where Service Classes are
	private $_ServicesPath = SERVICE_DIR;

    // Class and Sub Class Separator
    private $_Separator = ".";

	
	
	//Check If Client Provided Hash
	function __construct() {
		if(!$this->CheckHash()) {
			echo json_encode(
                array(
                    "response"=>0,
                    "errCode"=>1,
                    "errDesc"=>"Wrong token!"
                )
            );
			die();
		}

	}



    public static function getCSRFToken() {
        global $config;
        $token = base64_encode(hash("sha512", Dispatcher::getSessionToken().$config['csrf_sault'], True));
        return $token;
    }


	//Check Hash Method
	private function CheckHash() {
        return true;
        $token = $this->getSessionToken();

        if($_REQUEST['token']!=$token) {
            return false;
        }

		return true;
	}


	/**
	 * Get Request Parameters
	 */
	private function GetRequest() {

		//If Service Parameter is absent
        if(!isset($_REQUEST['service'])) {
            header('HTTP/1.0 403 Forbidden');
			echo json_encode(array("response"=>0,"errCode"=>2,"errDesc"=>"No Service"));
			return false;
		}
		
		//If Method Parameter is absent
		if(!isset($_REQUEST['method'])) {
            header('HTTP/1.0 403 Forbidden');
			echo json_encode(array("response"=>0,"errCode"=>2,"errDesc"=>"No Method"));		
			return false;
		}
		
		//Get Service And Method
		$service = $_REQUEST['service'];
		$method = $_REQUEST['method'];

		//If Subdirectory
		if(strrpos($service,$this->_Separator) !== false) {
            $exploded = explode($this->_Separator,$service);
            $service = ucfirst($exploded[1]);
            $servicePath = $exploded[0]."/".strtolower($service);
            $service_file = $this->_ServicesPath."$servicePath.service.php";

        }
        //If Not Sub directory
        else {
            $service_file = $this->_ServicesPath."/".strtolower($service).".service.php";
        }



		//If Service Handler Class File Exists
		if(!file_exists($service_file)) {
            header('HTTP/1.0 403 Forbidden');
			echo json_encode(array("response"=>0,"errCode"=>2,"errDesc"=>"No Service Class File Found"));	
			return false;
		}


		require_once($service_file);
		

		//IF Service Class Doesnt Exists
		if(!class_exists($service)) {
            header('HTTP/1.0 403 Forbidden');
			echo json_encode(array("response"=>0,"errCode"=>2,"errDesc"=>"Service Doesn't Exists"));
			return false;
		}

        $service = ucfirst($service);

        //If Method Was Denided
        if(strpos($service,"_") === 0 || strpos($method,"_")===0) {
            header('HTTP/1.0 403 Forbidden');
            echo json_encode(array("response"=>0,"errCode"=>-11,"errDesc"=>"Access Denided"));
            return false;
        }


		//Initialise Object
		$ServiceObject = new $service;

        //If Method Exists
		if(!method_exists($ServiceObject,$method)) {
            header('HTTP/1.0 403 Forbidden');
			echo json_encode(array("response"=>0,"errCode"=>2,"errDesc"=>"Method Doesn't Exists"));
			return false;
		}
		

        unset($_REQUEST['service']);
        unset($_REQUEST['method']);
        unset($_REQUEST['lang']);
        unset($_REQUEST['hash']);
        unset($_POST['token']);
        unset($_POST['CSRFToken']);
        unset($_POST['lang']);
        unset($_POST['submit']);



        $r = new ReflectionMethod($ServiceObject, $method);

        $reflection_params = $r->getParameters();

        $r_params_array = array();
        $r_param_def_values = array();

        foreach($reflection_params as $ref_param) {
            array_push($r_params_array,$ref_param->name);
            try {
                array_push($r_param_def_values,$ref_param->getDefaultValue());
            }catch(Exception $e) {

            }

        }
        $invoke_params = array();
        foreach($r_param_def_values as $default_value) {
            array_push($invoke_params,$default_value);
        }


        
        foreach($_POST as $key=>$value) {
            if($key != "user_id") {
                if(array_search($key,$r_params_array)!==false) {
                    $invoke_params[array_search($key,$r_params_array)] = $value;
                }

            }
        }
        ksort($invoke_params);



        $response = call_user_func_array(array($ServiceObject, $method), $invoke_params);

        if(gettype($response) == "array") {
            echo json_encode($response);
        } else {
            echo ($response);
        }
		
		
	}



	public function Process() {
		$this->GetRequest();
	}
	
	


	
}

