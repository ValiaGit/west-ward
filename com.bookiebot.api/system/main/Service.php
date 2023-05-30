<?php

if(!defined('APP')) {
    die();
}




abstract class Service {

    private $available_languages = array(
        "en",
        "ka",
        "ru",
        "jp",
        "de"
    );


    /**
     *
     */
    function __construct() {

        global $db;
        global $langPackage;

        $this->db = $db;
        $this->lang = $langPackage;



    }


    /**
     * If Service need another servise to load
     * (For example settings service needs to load session service to detect if session is active and has Grant)
     * @param $service
     * @return bool
     */
    protected function loadService($service) {

        if(file_exists(SERVICE_DIR.$service.".service.php")) {

            require_once SERVICE_DIR.$service.".service.php";
            $className = explode("/",$service);
            $className = end($className);
            $className = ucfirst($className);
            if(class_exists($className)) {
                $instance = new $className;
                return $instance;
            } else {
                return false;
            }
        } else {
            return false;
        }



    }


    /**
    * This is accessed in every service class. This method need user_id to be sent by POST
    * With this we detect if requested user is in active session and has grantSession available
    *return int $user_id
    **/
    protected function checkUserAccess() {
        $session  = $this->loadService("user/session");
        return $session->hasAccess();
    }







    /**
     * @param $serializedTitle
     * @return mixed
     */
    protected function getUnserializedTitle($serializedTitle) {
        global $lang;
        $titlearr = json_decode($serializedTitle,true);

        if(!isset($titlearr[$lang])) {
            $lang = "BET";
        }

        return $titlearr[$lang];
    }


    /**
     * Loads Payment Provider Class
     */
    protected function loadPaymentProvider($provider_name) {
        $provider_class_file = API_DIR."/providers/".$provider_name.".php";

        if(file_exists($provider_class_file)) {
            require_once $provider_class_file;
            $class_name = explode("/",$provider_name);
            $class_name = $class_name[1];
            return new $class_name();
        } else {
            return false;
        }
    }


    /**
     * Check If Request To Service Passed CSRF
     * @return bool
     */
    protected function CheckCSRF() {
        if(!isset($_REQUEST['CSRFToken'])) {
            return false;
        }

        if($_REQUEST['CSRFToken']!=Dispatcher::getCSRFToken()) {
            return false;
        }


        return true;
    }


    /**
     * @param $logText
     * @param array $parameters
     * @param int $type
     * @return bool
     */
    protected function Log($logText,$parameters = array(),$type = 1) {

        $user_id = @$_SESSION['user']['id'] ? $_SESSION['user']['id'] : 0;
        $type = (int)$type;
        if($user_id) {

            $db = $this->db;
            $logText = $db->escape($logText);

            $data_to_save = array(
                "core_users_id"=>(int) $user_id,
                "logText"=>$logText,
                "logType"=>$type,
                "logParams"=>json_encode($parameters),
            );

            $save_log = $db->insert("core_logs",$data_to_save);
            if($save_log!==false) {
                return true;
            }
            return false;
        }
        else {
            $db = $this->db;
            $logText = $db->escape($logText);

            $data_to_save = array(
                "core_users_id"=>0,
                "logText"=>$logText,
                "logType"=>$type,
                "logParams"=>json_encode($parameters),
            );
            $save_log = $db->insert("core_logs",$data_to_save);
            if($save_log!==false) {
                return true;
            }
        }
    }



}

