<?php

if(!defined('APP')) {
    die();
}



abstract class Service {
    private $db;

    /**
     *
     */
    public function __construct() {
        global $db;

        $this->$db = $db;
    }



    /**
     * @param $service
     * @return bool
     */
    public function loadService($service) {
        require_once SERVICE_DIR.$service.".service.php";
        $className = explode("/",$service);
        $className = end($className);
        $className = ucfirst($className);
        if(class_exists($className)) {
            $instance = new $className;
            return true;
        } else {
            return false;
        }
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
     * @param $logText
     * @param int $logType
     * @param int $logStatus
     * @return bool
     */
    protected function saveLog($logText,$logType = 1,$logStatus = 1) {
        $db = $this->db;
        $logText = $db->escape($logText);
        $logStatus = (int)$logStatus;
        $insert = $db->insert("backoffice_logs",array("logText"=>$logText,"logType"=>$logType,"logStatus"=>$logStatus));
        return (boolean) $insert;
    }

    /**
     * @param $filter
     * @param bool $clause
     * @param bool $db
     */
    protected function setFilters($filter,$clause = true,$db = false) {
        if(!count($filter)) {
            return false;
        }

        if(gettype($filter)!="array") {
            return false;
        }
        if($clause) {

            $clause_str = "";
            foreach($filter as $filter_index=>$filter_value) {

                if($filter_value !="" && $filter_value) {
                    if(is_array($filter_value)) {
                        foreach($filter_value as $date_filter_key=>$date_filter_value) {

                        }
                    }

                    else {
                        if(strpos($filter_index,"_")) {
                            $array = explode('_', $filter_index, 2);
                            $table = $array[0];
                            $param = $array[1];

                            $clause_str  .= " AND $table.$param='".$filter_value."' ";
                        } else {
                            $clause_str .= " AND $filter_index='".$filter_value."' ";

                        }
                    }
                }
            }

            return $clause_str;
        }

        else {


            foreach($filter as $filter_index=>$filter_value) {

                if($filter_value !="" && $filter_value) {
                    if(is_array($filter_value)) {
                        foreach($filter_value as $date_filter_key=>$date_filter_value) {

                        }
                    }

                    else {
                        if(strpos($filter_index,"_")) {
                            $array = explode('_', $filter_index, 2);
                            $table = $array[0];
                            $param = $array[1];
                            // $db->where($table.$param,$filter_value);
                        } else {

                            // $db->where($filter_index,$filter_value);

                        }
                    }
                }


            }



        }


    }

}

?>