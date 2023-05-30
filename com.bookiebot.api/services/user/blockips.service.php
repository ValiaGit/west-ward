<?php


if(!defined('APP')) {
    die();
}



class Blockips extends Service {


    /**
     * @return array
     */
    public function getList() {

        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            $db = $this->db;

            $db->where("core_users_id",$user_id);

            $data = $db->get("core_blocked_ips",null,"id,blocked_ip,blocker_ip,block_date");
            return array("code"=>10,"data"=>$data);
        }
        else {
            return array("code"=>60);
        }

    }


    /**
     * @param bool $ip
     * @param bool $user_id
     * @return array
     */
    public function checkIpIsBlockedForUser($user_id = false,$ip = false) {
        $db = $this->db;
        $user_id = (int) $db->escape($user_id);
        $ip = ip2long($db->escape($ip));

        $db->where("core_users_id",$user_id);
        $db->where("blocked_ip",$ip);
        $is_blocked = $db->getOne("core_blocked_ips","1");
        if($is_blocked) {
            return array("code"=>10,"is_blocked"=>true);
        } else {
            return array("code"=>20,"is_blocked"=>false);
        }
    }


    /**
     * @param bool $blocked_ip_id
     * @return array
     */
    public function unBlockIp($blocked_ip_id = false) {

        if(!$blocked_ip_id) {
            return array("code"=>50);
        }
        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            $db = $this->db;

            $db->where("id",$blocked_ip_id);
            $db->where("core_users_id",$user_id);

            $delete = $db->delete("core_blocked_ips");
            if($delete) {
                return array("code"=>10);
            } else {
                return array("code"=>20);
            }

        }
        else {
            return array("code"=>40);
        }
    }

    /**
     * @param bool $ip
     * @return array
     */
    public function blockIp($ip = false, $core_question_id=false, $answer_value = false) {
        if(!$ip) {
            return false;
        }
        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            $db = $this->db;
            $ip = ip2long($ip);
            $data = array(
                "core_users_id"=>$user_id,
                "blocked_ip"=>$ip,
                "blocker_ip"=>IP
            );

            /**
             * Security Question
             */
            $security_questions_service = $this->loadService("user/securityquestions");
            $check_question = $security_questions_service->checkSecurityQuestion($user_id,$core_question_id,$answer_value);
            if($check_question['code']!=10) {
                return array("code"=>65);
            }

            /**
             * Insert Blocked Ip
             */
            $insert_id = $db->insert("core_blocked_ips",$data);
            if($insert_id) {
                return array("code"=>10);
            } else {
                return array("code"=>20);
            }

        }
        else {
            return array("code"=>40);
        }



    }





}