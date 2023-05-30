<?php

if(!defined('APP')) {
    die();
}


class Resetpassword extends Service {


    /**
     * Initializes Reset
     * @return array
     */
    public function initReset() {

        $db = $this->db;

        if(!isset($_POST['email'])) {
            return array("code"=>50);
        }

        $email = $db->escape($_POST['email']);

        $db->where("email",$email);
        $data = $db->getOne("core_users","id,email,username");

        $user_id = $data['id'];
        $email = $data['email'];


        $generate_token = $this->saveAndSendToken($user_id,$email);
        if($generate_token['code'] == 10) {
            $this->Log("Password Reset Was Initialised!",array("username"=>$data['username']));
            $generate_token['data'] = array(
                "username"=>$data['username']
            );
        }
        return $generate_token;
    }


    /**
     * This method gets token as parameter with new password
     * and resets password to user with provided token
     * @return array
     */
    public function resetPass($security_code = false,$password = false) {

        global $config;


        $db = $this->db;
        $token = $db->escape($security_code);
        $password = sha1($db->escape($password).$config['password_sault']);

        //Check Token Existence
        $db->where("token",$token);
        $db->where('expire_time', Array('<' => "NOW()"));
        $token_exists = $db->getOne("core_password_reset_tokens","id,core_users_id");


        //If Token Was Found
        if($token_exists) {
            $user_id = $token_exists['core_users_id'];


            $db->where('core_users_id',$user_id);
            $db->where('password',$password);
            $had_used = $db->get("old_used_passwords","1");
            if($had_used) {
                return array("code"=>30,"msg"=>"You already used this password please try different one!");
            }

            $update_data = array(
                "password"=>$password
            );
            $db->where("id",$user_id);
            $update = $db->update("core_users",$update_data);

            if($update) {
                $db->where("id",$token_exists['id']);
                $db->delete("core_password_reset_tokens");
                return array("code"=>10);
            }

            else {
                return array("code"=>30);
            }

        }

        else {
            return array("code"=>70);
        }

    }


    /**
     * When Init Reset Called Save Token For Provided User
     * @param $user_id
     * @param $email
     * @return array
     */
    private function saveAndSendToken($user_id, $email) {
        global $config;
        global $langPackage;

        $user_id = (int) $user_id;
        $db = $this->db;

        $db->where("core_users_id",$user_id);
        $db->delete("core_password_reset_tokens");

        //Generate Token And Expiration Time
        $token = md5(sha1(time().$email.$user_id."Salt#$"));
        $date = strtotime("+30 minute");
        $expire_date = date('Y-m-d h:i:s', $date);

        //Data To Be Inserted in DB
        $insert_data = array(
            "core_users_id"=>$user_id,
            "token"=>$token,
            "expire_time"=>$expire_date
        );


        //Generate Email Sent Text
        $email_text = $langPackage['password_reset_email_text'];
        $email_text = str_replace("{{token}}",$token,$email_text);

        //Load EmailSender Service And Send Email
        $email_sender_service = $this->loadService("common/_emailsender");
        $email_sent = $email_sender_service->sendPublicMail($email,"BookieBot.Com - Password Recovery",$email_text);

        $db->where("core_users_id",$user_id);
        $db->delete("core_password_reset_tokens");

        //If Email Was Sent
        if($email_sent) {
            $insert_id = $db->insert("core_password_reset_tokens",$insert_data);

            if($insert_id) {
                //Send Email With Token
                return array("code"=>10);
            }

            else {
                return array("code"=>70);
            }
        } else {
            return array("code"=>30);
        }




    }



}