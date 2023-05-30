<?php


if(!defined('APP')) {
    die();
}

use Carbon\Carbon;

class Protection extends Service {



    protected $protection_types = array(
        1=>array("name"=>"Timeout","hasAmount"=>false),
        2=>array("name"=>"Deposit Limit","hasAmount"=>true),
        3=>array("name"=>"Self Exclusion","hasAmount"=>false),
        4=>array("name"=>"Lose Amount Limit","hasAmount"=>false),
        5=>array("name"=>"Bet Amount Limit","hasAmount"=>false),
        6=>array("name"=>"Session Timeout","hasAmount"=>false)
    );


    protected $period_types = array(

        //Dates Fixed
        0=>array("title"=>"Never Expires","minutes"=>0),

        1=>array("title"=>"24 Hours","minutes"=>1440),
        2=>array("title"=>"48 Hours","minutes"=>2880),
        4=>array("title"=>"7 Days","minutes"=>10080),
        5=>array("title"=>"30 Days","minutes"=>40320),
        6=>array("title"=>"6 Months","minutes"=>241920),

        //Dates Repeatable
        7=>array("title"=>"Per Day","minutes"=>1440),
        8=>array("title"=>"Per Week","minutes"=>10080),
        9=>array("title"=>"Per Month","minutes"=>40320),
        10=>array("title"=>"Per Year","minutes"=>483800)
    );


    /**
     * Get All Protections For Current User
     * @return array
     */
    public function getProtections() {
        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            $db = $this->db;

            $protections = array();
            $qs = "
                                    SELECT

                                      has_protections.id as protection_id,
                                      has_protections.core_protection_types_id,
                                      has_protections.amount,
                                      has_protections.expire_date,
                                      has_protections.period_id,
                                      has_protections.period_minutes,

                                        queue.id as is_in_action_queue,
                                      queue.core_users_has_core_protection_types_id as queue_type_id,
                                      queue.affect_time as queue_affect_time,
                                      queue.amount as queue_amount,
                                      queue.action_type as queue_action_type,
                                      queue.interval_minutes as queue_interval_minutes,
                                      queue.period_id as queue_period_id



                                    FROM
                                      core_protection_types types,
                                      core_users_has_core_protection_types has_protections

                                    LEFT JOIN
                                      core_protection_action_queue queue
                                    ON
                                      queue.core_users_has_core_protection_types_id = has_protections.core_protection_types_id
                                      AND queue.core_users_has_core_protection_types_core_users_id = has_protections.core_users_id

                                    WHERE
                                      has_protections.core_users_id = $user_id
                                    AND
                                      types.id = has_protections.core_protection_types_id
                                    AND
                                      has_protections.expire_date > NOW()

                                    ";

//            echo $qs;

            $data = $db->rawQuery($qs);

            if(count($data)) {
                foreach($data as $node) {
                    $protections[$node['core_protection_types_id']] = $node;
                }
                return array("code"=>10,"has_protections"=>true,"protections"=>$protections);
            } else {
                return array("code"=>60,"has_protections"=>false);
            }
        }
        else {
            return array("code"=>20);
        }

    }


    /**
     * @param $has_protection_id
     * @return boolean
     */
    private function checkIsInQueue($has_protection_id) {
        $has_protection_id = (int)$has_protection_id;
        $db = $this->db;
        $db->where("core_users_has_core_protection_types_id",$has_protection_id);
        $results = $db->get("core_protection_action_queue",null,"1");
        if(count($results)) {
            return true;
        } else {
            return false;
        }
    }



    /**
     *
     */
    public function jobHandles() {

            $db = $this->db;


            $db->where('is_repeatable',1);
            $db->where ('expire_date', Carbon::now()->toDateTimeString(), "<=");

            //Iterate Over All Expired Iterable Values
            $repeatable_that_should_be_renewed = $db->get("core_users_has_core_protection_types has_protections",null,"has_protections.id as has_protection_id,period_id,core_users_id");
            if($repeatable_that_should_be_renewed) {
                //Iterate Over Protections That Should Be Renewed
                foreach($repeatable_that_should_be_renewed as $protection_item) {


                    //Check if Its in Disable Queue
                    $period_id = $protection_item['period_id'];
                    $has_protection_id = $protection_item['has_protection_id'];
                    $core_users_id = $protection_item['core_users_id'];



                    //If Expired And Ws in Disable Queue Delete Protection and also queue
                    if($this->checkIsInQueue($has_protection_id)) {


                        //Delete Protection Disable Queue Item
                        $db->where("core_users_has_core_protection_types_id",$has_protection_id);
                        $db->where("core_users_has_core_protection_types_core_users_id",$core_users_id);
                        $delete_queue = $db->delete("core_protection_action_queue");

                        //Delete Protection
                        $db->where('id',$has_protection_id);
                        $delete_protection = $db->delete("core_users_has_core_protection_types");
                        echo $db->getLastError();

                        if($delete_protection && $delete_queue) {
                            $this->Log("User selected protection was deleted",array(),5);
                            echo "DELETED protectionid=$has_protection_id AND Also Queue";
                        }


                    }

                    //Renew Protection
                    else {

                        $protection_duration = $this->period_types[$period_id];
                        $duration_minutes = $protection_duration['minutes'];

                        //Set expiration date for protection
                        $date_now = Carbon::now();
                        $expire_date = $date_now->addMinutes($duration_minutes)->toDateTimeString();


                        $update_data = array(
                            "repeat_count"=>$db->inc(1),
                            "create_time"=>Carbon::now()->toDateTimeString(),
                            "expire_date"=>$expire_date
                        );
                        $db->where('id',$has_protection_id);
                        $update_protection_renewal = $db->update("core_users_has_core_protection_types",$update_data);
                        if($update_protection_renewal!==false) {
                            $this->Log("User selected protection was renewed",array(),5);
                            echo "renewed protectionid=$has_protection_id";
                        }


                    }


                }
            }


            //Get All Queue Items And Iterate
            $db->where ('affect_time', Carbon::now()->toDateTimeString(), "<=");
            $get_queue_items = $db->get("core_protection_action_queue",null,"*");
            foreach($get_queue_items as $action_queue_item) {


                $id = $action_queue_item['id'];
                $action_type = $action_queue_item['action_type'];
                $amount = $action_queue_item['amount'];
                $interval_minutes = $action_queue_item['interval_minutes'];
                $period_id = $action_queue_item['period_id'];

                $core_users_has_core_protection_types_id = $action_queue_item['core_users_has_core_protection_types_id'];
                $core_users_has_core_protection_types_core_users_id = $action_queue_item['core_users_has_core_protection_types_core_users_id'];


                //If Requested Action Is Disable Protection
                if($action_type == 2) {


                    //Delete User Has Protection
                    $db->where('core_users_id',$core_users_has_core_protection_types_core_users_id);
                    $db->where('core_protection_types_id',$core_users_has_core_protection_types_id);
                    $disable_protection = $db->delete("core_users_has_core_protection_types");


                    //Requested Delete Of Protection
                    $db->where('id',$id);
                    $delete_queue_item = $db->delete("core_protection_action_queue");
                    if($delete_queue_item && $disable_protection) {
                        echo "Disable Protection Which Was Requested In Queue";
                    } else {
                        echo $db->getLastError(). " -1";
                    }

                }

                //If Requested Action Is To Update Protection
                else {



                    //Set expiration date for protection
                    $date_now = Carbon::now();
                    $date_now_formatted = $date_now->toDateTimeString();
                    $expire_date = $date_now->addMinutes($interval_minutes)->toDateTimeString();


                    $update_data = array (
                        'amount'=>$amount,
                        'expire_date'=>$expire_date,
                        'period_minutes'=>$interval_minutes,
                        'create_time'=>$date_now_formatted,
                        'period_id'=>$period_id
                    );


                    $db->where('id',$id);
                    $delete_queue_item = $db->delete("core_protection_action_queue");

                    $db->where('core_users_id',$core_users_has_core_protection_types_core_users_id);
                    $db->where('core_protection_types_id',$core_users_has_core_protection_types_id);
                    $update_protection_with_new_details = $db->update("core_users_has_core_protection_types",$update_data);

                    if($update_protection_with_new_details && $delete_queue_item) {
                        echo "Update Protection Details Which was in queue";
                    } else {
                        echo $db->getLastError()." 0";
                    }

                }

            }


            //Check Expired One Time Protections And Disable
            $db->where('is_repeatable',0);
            $db->where ('expire_date', Carbon::now()->toDateTimeString(), "<=");
            $expired_not_repeatable = $db->get("core_users_has_core_protection_types has_protections",null,"has_protections.id as has_protection_id,period_id,core_users_id,core_protection_types_id");
            //If Expired One Time Protections Exists
            if($expired_not_repeatable) {

                //Iterate Over All Expired One Time Protections
                foreach($expired_not_repeatable as $expired_node) {


                    $has_protection_id = $expired_node['has_protection_id'];
                    $core_users_id = $expired_node['core_users_id'];
                    $core_protection_types_id = $expired_node['core_protection_types_id'];

                    //Delete From Queue
                    $db->where("core_users_has_core_protection_types_core_users_id",$core_users_id);
                    $db->where("core_users_has_core_protection_types_id",$core_protection_types_id);
                    $delete_queue = $db->delete("core_protection_action_queue");



                    //Delete Expired Protection
                    $db->where('id',$has_protection_id);
                    $delete_item = $db->delete('core_users_has_core_protection_types');
                    if($delete_item) {
                        echo "Deleted expired one time protection";
                    }

                }


            }



    }





    /**
     * Check If User Has protections
     * @return array
     */
    public function _checkProtection($user_id,$type_id = false) {
        $user_id = (int)$user_id;

        //If User Is Authenticated
        if($user_id) {
            $db = $this->db;

            $protections = array();

            $clause_type = "";
            if($type_id) {
                $clause_type.= " AND types.id = $type_id ";
            }

            $data = $db->rawQuery("
                                    SELECT
                                      has_protections.core_protection_types_id,
                                      has_protections.amount,
                                      has_protections.create_time,
                                      has_protections.period_minutes,
                                      has_protections.expire_date
                                    FROM
                                      core_users_has_core_protection_types has_protections,
                                      core_protection_types types
                                    WHERE
                                      has_protections.core_users_id = ?
                                    AND
                                      types.id = has_protections.core_protection_types_id
                                    AND
                                      has_protections.expire_date > NOW() $clause_type
                                    ",array($user_id));

            if(count($data)) {
                foreach($data as $node) {
                    $protections[$node['core_protection_types_id']] = $node;
                }
                return array("code"=>10,"has_protections"=>true,"protections"=>$protections);
            } else {
                return array("code"=>60,"has_protections"=>false);
            }
        }
        else {
            return array("code"=>20);
        }

    }


    /**
     * @param bool $core_protection_types_id
     * @param bool $period_id
     * @param bool $amount
     * @return array
     */
    private function addProtection($core_protection_types_id = false, $period_id = false, $amount = false,$account_password = false, $period_minutes = false) {
        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];


            $db = $this->db;

            $core_protection_types_id = (int)$core_protection_types_id;
            $period_id = (int)$period_id;
            $amount = (int)$amount;


            //CHECK PASSWORD TO AFFECT CHANGES
            $session_service = $this->loadService("user/session");
            $check_password = $session_service->checkPassword($account_password);
            if($check_password['code'] != 10) {
                return array("code"=>-102,"msg"=>"Account Password is Wrong!");
            }

            //Check If Limit Type Must Have Amount Value
            if(!isset($this->protection_types[$core_protection_types_id])) {
                return array("code"=>50,"msg"=>"Protection type is wrong!");
            }
            if($this->protection_types[$core_protection_types_id]['hasAmount'] && !$amount) {
                return array("code"=>50,"msg"=>"Please provide amount!");
            }

            //If period is lower than 5
            //This protection isn't repeatable
            if($period_id < 7) {
                $is_repeatable = false;
            }
            //This protection is repeatable
            else {
                $is_repeatable = true;
            }

            //If provided period_id isn't acceptable
            if(!isset($this->period_types[$period_id])) {
                return array("code"=>50,"msg"=>"Protection period id is wrong!");
            }

            if($period_id == 0) {
                $duration_minutes = (int)$period_minutes;
                if(!$duration_minutes) {
                    return array("code"=>50,"msg"=>"Chosen minutes are wrong for session timeout limit!");
                }
            }

            else {
                $protection_duration = $this->period_types[$period_id];
                $duration_minutes = $protection_duration['minutes'];
            }


            $has_already_limit = $this->_checkProtection($user_id,$core_protection_types_id);
            if($has_already_limit['code'] == 10) {
                return array("code"=>50,"msg"=>"You already have activated this limit!");
            }

            //Set expiration date for protection
            $date_now = Carbon::now();
            $expire_date = $date_now->addMinutes($duration_minutes)->toDateTimeString();

            //Data To Insert In Database
            $data_to_insert = array (
                "core_users_id"=>$user_id,
                "core_protection_types_id"=>$core_protection_types_id,
                "amount"=>$amount*100,
                "period_id"=>$period_id,
                "expire_date"=>$expire_date,
                "is_repeatable"=>$is_repeatable,
                "period_minutes"=>$duration_minutes
            );



            //If we insert protection successfully
            $inserted = $db->insert("core_users_has_core_protection_types",$data_to_insert);
            if($inserted!== false) {
                $this->Log("User enabled protection",$data_to_insert,5);
                return array("code"=>10);
            } else {
                echo $db->getLastError();
                //Save Log
                $this->Log("User Cant Active Protection",$data_to_insert);
                return array("code"=>30);
            }
        }


        else {
            return array("code"=>40);
        }


    }


    /**
     * @param bool $core_protection_types_id
     * @param bool $period_id
     * @param bool $amount
     * @param bool $account_password
     * @return array
     */
    public function makeProtectionChange($core_protection_types_id = false, $period_id = false, $amount = false,$account_password = false, $period_minutes = false) {
        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];


            $db = $this->db;
            $core_protection_types_id = (int)$core_protection_types_id;
            $period_id = (int)$period_id;
            $amount = (float)$amount;


            //Check If User Had This Protection
            $db->where('core_users_id',$user_id);
            $db->where('core_protection_types_id',$core_protection_types_id);
            $had_protection = $db->getOne("core_users_has_core_protection_types","amount,period_minutes");
            if($had_protection) {

                //Check If Limit Type Must Have Amount Value
                if(!isset($this->protection_types[$core_protection_types_id])) {
                    return array("code"=>50,"msg"=>"Protection type is wrong!");
                }
                if($this->protection_types[$core_protection_types_id]['hasAmount'] && !$amount) {
                    return array("code"=>50,"msg"=>"Please provide amount!");
                }


                //If provided period_id isn't acceptable
                if(!isset($this->period_types[$period_id])) {
                    return array("code"=>50,"msg"=>"Protection period id is wrong!");
                }
                $protection_duration = $this->period_types[$period_id];

                //Check
                if($core_protection_types_id == 6) {
                    $requested_duration_minutes = $period_minutes;
                } else {
                    $requested_duration_minutes = $protection_duration['minutes'];
                }



                $old_duration_minutes = $had_protection['period_minutes'];

                $requested_amount = (float)$amount*100;
                $old_amount = $had_protection['amount'];



                //Per Minute Deposit Ort Bet or Lose Amount
                try {
                    $old_per_minute = $old_amount / $old_duration_minutes;
                    $new_per_minute = $requested_amount / $requested_duration_minutes;
                }catch(Exception $e) {

                }



                //2 = Deposit Limit
                //4 = Lose Amount Limit
                //5 = Bet Amount Limit

                //If Type Is Deposit Limit Increase Is In Queue
                if($core_protection_types_id == 2 || $core_protection_types_id == 5 || $core_protection_types_id == 4 || $core_protection_types_id == 6) {
                    //if increased time or amount will be in queue
                    if($new_per_minute > $old_per_minute || ($core_protection_types_id == 6 && ($old_duration_minutes < $requested_duration_minutes))) {


                        $date_now = Carbon::now()->toDateTimeString();
                        $in_one_week = Carbon::now()->addWeeks(1)->toDateTimeString();

                        //Save In Queue
                        $queue_insert_data = array(
                            "core_users_has_core_protection_types_core_users_id"=>$user_id,
                            "core_users_has_core_protection_types_id"=>$core_protection_types_id,
                            "action_type"=>1,
                            "create_time"=>$date_now,
                            "affect_time"=>$in_one_week,
                            "amount"=>$requested_amount,
                            "interval_minutes"=>$requested_duration_minutes,
                            "period_id"=>$period_id,
                            "comment"=>"Requested to Update Protection",
                        );


                        //check already exists
                        $db->where('core_users_has_core_protection_types_core_users_id',$user_id);
                        $db->where('core_users_has_core_protection_types_id',$core_protection_types_id);
                        $exists_queue_request = $db->getOne("core_protection_action_queue","id");

                        //If Exists In Queue Of Update Or Disable
                        if($exists_queue_request) {
                            $queue_id = $exists_queue_request['id'];

                            $db->where('id',$queue_id);
                            $update_data = $db->update("core_protection_action_queue",$queue_insert_data);
                            if($update_data) {
                                return array("code"=>10);
                            } else {
                                return array("code"=>30,"msg"=>"Cant make changes at this moment - ".$db->getLastError());
                            }
                        }

                        else {

                            $insert = $db->insert("core_protection_action_queue",$queue_insert_data);
                            if($insert) {
                                return array("code"=>10);
                            } else {
                                return array("code"=>30,"msg"=>"Cant make changes at this moment - ".$db->getLastError());
                            }
                        }

                    }
                }

                if($old_amount !=0 && $requested_amount) {
                    if($requested_amount == $old_amount && $requested_duration_minutes == $old_duration_minutes) {
                        return array("code"=>-987,"msg"=>"Requested limit is the same!");
                    }
                }


                //Set expiration date for protection
                $date_now = Carbon::now();
                $expire_date = $date_now->addMinutes($requested_duration_minutes)->toDateTimeString();

                //Data To Update In Database
                $data_to_update_protection = array (
                    "amount"=>$requested_amount,
                    "period_id"=>$period_id,
                    "expire_date"=>$expire_date,
                    "period_minutes"=>$requested_duration_minutes
                );



                //Remove All Actions Queues Regarding This Protection Which Is Being Updated
                $db->where('core_users_has_core_protection_types_id',$core_protection_types_id);
                $db->where('core_users_has_core_protection_types_core_users_id',$user_id);
                $delete = $db->delete('core_protection_action_queue');


                //Uodate Newly Requested Protection
                $db->where('core_protection_types_id',$core_protection_types_id);
                $db->where('core_users_id',$user_id);
                $updated = $db->update("core_users_has_core_protection_types",$data_to_update_protection);
                if($updated!== false) {
                    $delete_queue = null;
                    try {
                        $db->where('core_users_has_core_protection_types_id',$core_protection_types_id);
                        $db->where('core_users_has_core_protection_types_core_users_id',$user_id);
                        $delete_queue = $db->delete('core_protection_action_queue');
                    }catch(Exception $e) {

                    }



                    $this->Log("User updated protection",$data_to_update_protection,5);
                    return array("code"=>10,"delete_queue"=>$delete_queue);
                } else {
                    echo $db->getLastError();
                    //Save Log
                    $this->Log("User Cant Active Protection",$data_to_update_protection);
                    return array("code"=>30);
                }

            }
            else {
                return $this->addProtection($core_protection_types_id,$period_id,$amount,$account_password,$period_minutes);
            }





        } else {
            return array("code"=>40);
        }
    }



    /**
     * @param bool $protection_id
     * @return array
     */
    public function disableProtection($protection_id = false,$type_id = false) {
        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            $db = $this->db;


            $date_now = Carbon::now()->toDateTimeString();
            $in_one_week = Carbon::now()->addWeeks(1)->toDateTimeString();

            //Save In Queue
            $queue_insert_data = array(
                "action_type"=>2,
                "create_time"=>$date_now,
                "affect_time"=>$in_one_week,
                "comment"=>"Requested to Disable Protection",
            );


            $db->where('core_users_has_core_protection_types_core_users_id',$user_id);
            $db->where('core_users_has_core_protection_types_id',$type_id);
            $exists_queue_request = $db->getOne("core_protection_action_queue","id");
            $qs = "SELECT id FROM core_protection_action_queue WHERE core_users_has_core_protection_types_core_users_id=$user_id AND core_users_has_core_protection_types_id=$type_id";

            if($exists_queue_request) {
                $queue_id = $exists_queue_request['id'];

                $db->where('id',$queue_id);
                $update_data = $db->update("core_protection_action_queue",$queue_insert_data);
                if($update_data) {
                    return array("code"=>10);
                } else {
                    return array("code"=>30,"msg"=>"Cant make changes at this moment - ".$db->getLastError());
                }
            }

            else {
                $queue_insert_data['core_users_has_core_protection_types_core_users_id'] = $user_id;
                $queue_insert_data['core_users_has_core_protection_types_id'] = $type_id;

                $insert = $db->insert("core_protection_action_queue",$queue_insert_data);
                if($insert) {
                    return array("code"=>10);
                } else {
                    return array("code"=>30,"msg"=>"Cant make changes at this moment - ".$db->getLastError());
                }
            }



        }


        else {
            return array("code"=>20);
        }
    }




}