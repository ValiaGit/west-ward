<?php

if (!defined('APP')) {
    die();
}

use Carbon\Carbon;

abstract class Service
{

    /**
     *
     */
    public function __construct()
    {
        global $db;

        $this->db = $db;
    }


    /**
     * @param $service
     * @return bool
     */
    public function loadService($service)
    {
        require_once SERVICE_DIR . $service . ".service.php";
        $className = explode("/", $service);
        $className = end($className);
        $className = ucfirst($className);
        if (class_exists($className)) {
            $instance = new $className;
            return $instance;
        } else {
            return false;
        }
    }


    /**
     * @param $serializedTitle
     * @return mixed
     */
    protected function getUnserializedTitle($serializedTitle)
    {
        global $lang;
        $titlearr = json_decode($serializedTitle, true);

        if (!isset($titlearr[$lang])) {
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
    protected function saveLog($logText, $logType = 1, $logStatus = 1)
    {
        $db = $this->db;
        $logText = $db->escape($logText);
        $logStatus = (int)$logStatus;
        $insertArray = array("logText" => $logText, "logType" => $logType, "logStatus" => $logStatus);

        if(isset($_SESSION['admin_data'])) {
            if(isset($_SESSION['admin_data']['id'])){
                $insertArray['westward_employee_id'] = $_SESSION['admin_data']['id'];
            }
        }


        $insert = $db->insert("backoffice_logs", $insertArray);
        return (boolean)$insert;
    }

    /**
     * @param $filter
     * @param bool $clause
     * @param bool $db
     */
    protected function setFilters($filter, $clause = true, $db = false)
    {

        if (!count($filter)) {

            return false;
        }

        if (gettype($filter) != "array") {

            return false;
        }

        if ($clause) {

            $clause_str = "";
            foreach ($filter as $filter_index => $filter_value) {

                if ($filter_value != "" && $filter_value!==false) {
                    if (is_array($filter_value)) {
                        foreach ($filter_value as $date_filter_key => $date_filter_value) {

                            try {
                                $from = "";
                                if (isset($date_filter_value['from'])) {
                                    $from = $date_filter_value['from'];
                                }

                                $to = "";
                                if (isset($date_filter_value['to'])) {
                                    $to = $date_filter_value['to'];
                                }


                                if (!empty($from) && !empty($to)) {
                                    if (strpos($filter_index, "_")) {
                                        $array = explode('_', $filter_index, 2);
                                        $table = $array[0];
                                        $param = $array[1];

                                        $clause_str .= " AND ($table.$param>'$from' AND  $table.$param<'$to')";
                                    } else {
                                        $clause_str .= " AND ($filter_index>'$from' AND $filter_index<'$to') ";

                                    }
                                }


                            } catch (Exception $e) {

                            }

                        }
                    } else {


                            if (strpos($filter_index, "_")) {

                                $array = explode('_', $filter_index, 2);

                                $table = $array[0];
                                $param = $array[1];

                                $clause_str .= " AND $table.$param='" . $filter_value . "' ";
                            } else {
                                $clause_str .= " AND $filter_index='" . $filter_value . "' ";

                            }


                    }
                }
            }


            return $clause_str;
        } else {

            foreach ($filter as $filter_index => $filter_value) {

                if ($filter_value != "" && $filter_value) {
                    if (is_array($filter_value)) {
                        foreach ($filter_value as $date_filter_key => $date_filter_value) {

                        }
                    } else {
                        if (strpos($filter_index, "_")) {
                            $array = explode('_', $filter_index, 2);
                            $table = $array[0];
                            $param = $array[1];
                            $db->where($table . $param, $filter_value);
                        } else {

                            $db->where($filter_index, $filter_value);

                        }
                    }
                }


            }
        }


    }


    /**
     * @param $filter
     * @param bool|true $hasWhere
     * @return string
     */
    protected function ReturnKendoFilterClause($filter, $hasWhere = true, $is_users_table = false)
    {
        $clause = "";

        if (isset($filter['filters'])) {
            $filters = $filter['filters'];
            if(gettype($filters) == 'array') {
                $filters_length = count($filters);

                foreach ($filters as $index=>$filter_val) {

                    if(isset($filter_val['field']) && isset($filter_val['value'])){
                        $field = $filter_val['field'];
                        $value = $filter_val['value'];
                    } else {
                        $field = '';
                        $value = '';
                    }





                    $operator = isset($filter_val['operator']) ? $filter_val['operator'] : false;
                    if($operator == "lt") {
                        continue;
                    }

                    if(!isset($filter_val['filters'])) {
                        if($value == '') {
                            continue;
                        }
                    }


                    if (!$hasWhere) {
                        if (!strpos($clause, "WHERE")) {
                            $clause .= " WHERE ";
                        }
                    } else {
                        $clause .= " AND ";
                    }



                    if($is_users_table) {
                        if($field == 'status' && ($value==-1 || $value=='Inactive')) {

                        }
                    }


                    try {
                        if(isset($filter_val['filters'])) {
                            $grFilters = $filter_val['filters'];

                            foreach($grFilters as $index=>$groupedFilter) {
                                $op = $groupedFilter['operator'];
                                $fi = $groupedFilter['field'];
                                $va = $groupedFilter['value'];

                                if($op == "gt") {
                                    $from = $va;
                                    $to = $grFilters[$index+1]['value'];

                                    try {

                                        if(strpos($from," (")) {
                                            $from = explode(" (",$from);
                                            $from = $from[0];
                                        }
                                        $from = Carbon::parse($from);


                                        if(strpos($to," (")) {
                                            $to = explode(" (",$to);
                                            $to = $to[0];
                                        }
                                        $to = Carbon::parse($to);


                                        if (strpos($fi, "__")) {
                                            $array = explode('__', $fi, 2);
                                            $table = $array[0];
                                            $param = $array[1];
                                        }
                                        //echo " $table.$param BETWEEN '$from' AND '$to' ";
                                        $clause .= " $table.$param BETWEEN '$from' AND '$to' ";

                                    }catch(Exception $e) {

                                    }
                                }

                            }
                        }

                    }catch(Exception $e) {

                    }



                    if($operator == "gt") {
                        $from = $value;
                        $to = $filters[$index+1]['value'];

                        try {

                            if(strpos($from," (")) {
                                $from = explode(" (",$from);
                                $from = $from[0];
                            }
                            $from = Carbon::parse($from);


                            if(strpos($to," (")) {
                                $to = explode(" (",$to);
                                $to = $to[0];
                            }
                            $to = Carbon::parse($to);



                            if (strpos($field, "__")) {
                                $array = explode('__', $field, 2);
                                $table = $array[0];
                                $param = $array[1];
                            }


                            $clause .= " $table.$param BETWEEN '$from' AND '$to' ";

                        }catch(Exception $e) {

                        }

                    }

                    elseif($is_users_table && ($field == 'status' && ($value==-1 || $value=='Inactive'))) {

                        $clause .= " core_users.last_login_date < '".Carbon::now()->subMonths(30)->toDateTimeString()."' AND ";
                    }
                    else {

                        //If Value Is String

                        if($is_users_table && $field == 'status') {
                            switch($value) {
                                case 'Active':
                                    $value = 1;
                                    break;
                                case 'Suspended Permanently':
                                    $value = 7;
                                    break;
                                case 'Blocked':
                                    $value = 2;
                                    break;
                            }
                            //Active
                        }


                        if ((isset($value) && (int)$value == 0 && $value!='0') || strpos($value,"/")) {
                            if (strpos($field, "__")) {
                                $array = explode('__', $field, 2);
                                $table = $array[0];
                                $param = $array[1];
                                if($value!='') {
                                    $clause .= " $table.$param='$value' AND ";
                                }



                            } else {
                                if($value!='') {
                                    $clause .= " $field='$value' AND ";
                                }

                            }
                        }

                        //If Value Equals Integer
                        else {

                            if (strpos($field, "__")) {
                                $array = explode('__', $field, 2);
                                $table = $array[0];
                                $param = $array[1];
                                if($value!='') {
                                    $clause .= " $table.$param=$value AND ";
                                }

                            } else {
                                if($value!='') {
                                    $clause .= " $field=$value AND ";
                                }

                            }

                        }
                    }


                    if($filters_length>1) {
                        if($index<$filters_length-1 && $hasWhere) {
                            if ($this->endsWith($clause, "AND")) {
                                $clause = substr($clause, 0, -3);
                            }
                            if ($this->endsWith($clause, "AND ")) {
                                $clause = substr($clause, 0, -4);
                            }
                        }
                    }


                }

                if ($this->endsWith($clause, "AND")) {
                    $clause = substr($clause, 0, -3);
                }
                if ($this->endsWith($clause, "AND ")) {
                    $clause = substr($clause, 0, -4);
                }
            }



        }

        else if(count($filter)) {

            $filters_length = count($filter);
            if($filters_length) {
                if(gettype($filter) == 'array') {
                    foreach ($filter as $index=>$filter_val) {

                        $field = $index;
                        $value = $filter_val;
                        if($value == '') {
                            continue;
                        }

                        if (!$hasWhere) {
                            if (!strpos($clause, "WHERE")) {
                                $clause .= " WHERE ";
                            }
                        } else {
                            $clause .= " AND ";
                        }



                        //If Value Is String
                        if ((int)$value == 0) {

                            if (strpos($field, "__")) {
                                $array = explode('__', $field, 2);
                                $table = $array[0];
                                $param = $array[1];

                                $clause .= " $table.$param='$value' AND ";

                            }
                            else if(strpos($field, "_")) {
                                $array = explode('_', $field, 2);
                                $table = $array[0];
                                $param = $array[1];

                                $clause .= " $table.$param='$value' AND ";
                            }


                            else {
                                $clause .= " $field='$value' AND ";
                            }
                        }

                        //If Value Equals Integer
                        else {

                            if (strpos($field, "__")) {
                                $array = explode('__', $field, 2);
                                $table = $array[0];
                                $param = $array[1];
                                $clause .= " $table.$param=$value AND ";
                            }
                            else if(strpos($field, "_")) {
                                $array = explode('_', $field, 2);
                                $table = $array[0];
                                $param = $array[1];

                                $clause .= " $table.$param='$value' AND ";
                            }


                            else {
                                $clause .= " $field=$value AND ";
                            }

                        }


                        if($filters_length>1) {
                            if($index<$filters_length-1 && $hasWhere) {
                                if ($this->endsWith($clause, "AND")) {
                                    $clause = substr($clause, 0, -3);
                                }
                                if ($this->endsWith($clause, "AND ")) {
                                    $clause = substr($clause, 0, -4);
                                }
                            }
                        }

                    }
                }

            }




            if ($this->endsWith($clause, "AND")) {
                $clause = substr($clause, 0, -3);
            }
            if ($this->endsWith($clause, "AND ")) {
                $clause = substr($clause, 0, -4);
            }
        }

//        echo $clause;

        return $clause;
    }


    private function  endsWith($haystack, $needle)
    {
        // search forward starting from end minus needle length characters
        return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
    }

}

?>