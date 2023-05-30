<?php


if(!defined('APP')) {
    die();
}


class Registration extends Service {


	/**
	* Submit Registration Form
	**/
    public function submit(
                            $username = "",
                            $first_name = "",
                            $last_name="",
                            $birthdate = "",
                            $core_currency_id = "",
                            $email = "",
                            $gender = 0,
                            $core_countries_id = 0,
                            $city = "",
                            $address = "",
                            $zip_code = "",
                            $phone = "",
                            $password = "",
                            $password_confirm = "",
                            $core_security_question_id = 0,
                            $security_answer ="",
                            $affiliate_id = ""
    )

    {

        global $config,$log;

//        die();

//        if(!$this->CheckCSRF()) {
//            return array("core"=>-1005,"msg"=>"CSRF DENIDED!");
//        }


        $db = $this->db;


        //Check Details If Already Registered This Lind Of User
        $db->where('first_name',$first_name);
        $db->where('last_name',$last_name);
        $db->where('birthdate',$birthdate);
        $db->where('core_countries_id',$core_countries_id);
        $check_exists = $db->getOne('core_users','1');
        if($check_exists) {
            if(count($check_exists)) {
                return array('code'=>-89,'Msg'=>'User with same first name, last name, birth day and country of residence is already registered!');
            }
        }

        $parent_affiliate_id = null;
        if($affiliate_id == "apple1") {
            $parent_affiliate_id = 38;
        }
        else {
            $parent_affiliate_id = IFn::decodeAffiliateIdToUserId($affiliate_id);
        }


        //Escape Insert Parameters
        $data = array(
            'username' => $db->escape(trim($username)),
            'nickname' => $db->escape($username),
            'first_name' => $db->escape($first_name),
            'last_name' => $db->escape($last_name),
            'birthdate' => $db->escape($birthdate),
            'core_currencies_id' => $db->escape($core_currency_id),
            'email' => $db->escape($email),
            'gender' => $db->escape($gender),
            'core_countries_id' => $db->escape($core_countries_id),
            'city' => $db->escape($city),
            'address' => $db->escape($address),
            'address_zip_code' => $db->escape($zip_code),
            'phone' => $db->escape($phone),
            'password' => $db->escape($password),
            'password_confirm' => $db->escape($password_confirm),
            'balance' => 0,
            'parent_affiliate_id'=>$parent_affiliate_id
        );


//        print_r($data);


        //Validate Parameters Sent From Clientside
        $validation = $this->is_valid($data);
        if($validation['code']!=10) {
            return $validation;
        }
        unset($data['password_confirm']);

        $data['password'] = sha1($db->escape($password).$config['password_sault']);

        $db->startTransaction();

        //Insert Data in Database
        $user_id = $db->insert('core_users', $data);
//        var_export($db->getLastError());
        $insert_question_data = array(
            "core_users_id" => $user_id,
            "core_security_questions_id" => $core_security_question_id,
            "answer_value" => base64_encode(hash("sha512", $security_answer . $config['security_questions_sault'], True))
        );
        $insert_security_question = $db->insert("core_security_answers", $insert_question_data);

        if($user_id!==false && $insert_security_question!==false) {
            $this->sendAndSaveEmailConfirmation($user_id,$db->escape($email));
            $db->commit();



            //Send Notification to Affiliates System
            if($affiliate_id) {

                $encoded_to_parent_user_id = IFn::decodeAffiliateIdToUserId($affiliate_id);

                //If Kyoh Then Assing Kyoh as parent Id
                if($affiliate_id == "apple1") {
                    $encoded_to_parent_user_id = 38;
                }



                if($encoded_to_parent_user_id) {
                    try {

                        $payload = [
                            "user_id"=>$user_id,
                            "parent_id"=>$encoded_to_parent_user_id,
                            "email"=>$email,
                            "country"=>$core_countries_id,
                            "hash"=>hash('sha256', $user_id.$encoded_to_parent_user_id.$email.$core_countries_id.$config['affiliates_request_key'])
                        ];

//                        print_r($payload);

                        $data_string = json_encode($payload);

                        $ch = curl_init($config['affiliates_url']."/api/add_user");
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt(
                            $ch,
                            CURLOPT_HTTPHEADER,
                            array(
                                'Content-Type: application/json'
                            )
                        );

                        $result = curl_exec($ch);
                        try {
                            $as_arr =  json_decode($result);
//                            print_r($as_arr);
                        }catch(Exception $e) {

                        }

                        $log->debug("Response from Affiliation system when adding user: ".$result);
                    } catch (Exception $e) {
                        echo $e->getMessage();
                        $log->error("Cant Save Affiliate Appropriately: Parent=".$encoded_to_parent_user_id.",Child=".$user_id);
                        $log->error($e->getMessage());
                    }
                }
            }

            //If No Affiliate Id Save 0 as Parent
            else {
                $payload = [
                    "user_id"=>$user_id,
                    "parent_id"=>0,
                    "email"=>$email,
                    "country"=>$core_countries_id,
                    "hash"=>hash('sha256', $user_id."0".$email.$core_countries_id.$config['affiliates_request_key'])
                ];
//                print_r($payload);
                $data_string = json_encode($payload);
                $ch = curl_init($config['affiliates_url']."/api/add_user");
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt(
                    $ch,
                    CURLOPT_HTTPHEADER,
                    array(
                        'Content-Type: application/json'
                    )
                );
                $result = curl_exec($ch);
                try {
                    $as_arr =  json_decode($result);
                }catch(Exception $e) {

                }
            }


            try {
                $db->insert("old_used_passwords",array(
                    "core_users_id"=>$user_id,
                    "password"=>$data['password']
                ));
            }catch(Exception $e) {

            }

            return array("code" => 10);
        }

//        var_dump($db->getLastError());
        $db->rollback();
        return array("code"=>30);


    }



    /**
     *
     * Send And Save Phone Confirmation
     * @param $email
     * @param $user_id
     * @return bool
     */
    private function sendAndSaveEmailConfirmation($user_id,$email) {
        global $langPackage;
        global $config;
        global $lang;

        $db = $this->db;

        //Generate OneTime Token For Email Activation
        $code = $this->generateToken();
        //Prepare And Send Email
        $url = "<a href='$config[base_href]/confirmations_email/init/$code/$lang'>$langPackage[confirmation_link_text]</a>";
        $text = str_replace("{token}",$url,$langPackage['email_confirmation_text_registration']);

        $email_sender_service = $this->loadService("common/_emailsender");
        $sent = $email_sender_service->sendPublicMail($email,$langPackage['email_confirmation_subject'],$text);


        //If Email Was Sent Save Email Activation Token In DB
        if($sent) {
            $insert = $db->insert("core_email_confirmations",array(
                "core_users_id"=>$user_id,
                "confirmation_code"=>$code
            ));
            return $insert;
        }
    }


    /**
     * @return string
     */
    protected function generateToken() {
        return md5(sha1(time().session_id()."Salt#$"));
    }


    /**
     * @param string $username
     * @return array
     */
    public function usernameExists($username = "") {

        $db = $this->db;


        //If param username wasnot provided it was from client request
        if(!$username) {
            if(!isset($_POST['username'])) {
                return array("success"=>false);
            }

            $username = $db->escape($_POST['username']);
        }


        $db = $this->db;
        $db->where("username",$username);
        $getUser = $db->getOne("core_users","1");

        if($getUser) {
            return array("success"=>true,"exists"=>true);
        } else {
            return array("success"=>true,"exists"=>false);
        }

    }


    /**
     * @param string $email
     * @return array
     */
    public function emailExists($email = "") {
        $db = $this->db;


        //If param username wasnot provided it was from client request
        if(!$email) {
            if(!isset($_POST['email'])) {
                return array("success"=>false);
            }

            $email = $db->escape($_POST['email']);
        }


        $db = $this->db;
        $db->where("email",$email);
        $getUser = $db->getOne("core_users","id");

        if($getUser) {
            return array("success"=>true,"exists"=>true);
        } else {
            return array("success"=>true,"exists"=>false);
        }
    }

    /**
     * @param string $phone
     * @return array
     */
    public function phoneExists($phone = "") {
        $db = $this->db;


        //If param username wasnot provided it was from client request
        if(!$phone) {
            if(!isset($_POST['phone'])) {
                return array("success"=>false);
            }

            $phone = $db->escape($_POST['phone']);
        }


        $db = $this->db;
        $db->where("phone",$phone);
        $getUser = $db->getOne("core_users","1");

        if($getUser) {
            return array("success"=>true,"exists"=>true);
        } else {
            return array("success"=>true,"exists"=>false);
        }
    }


    /**
     * @param $email
     * @return bool
     */
    private function isEmailValid($email) {

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * @param $data
     * @return array
     */
    private function is_valid($data) {
        $db = $this->db;

        //Define Method Variables
        global $langPackage;
        $found_error = false;


        //Set Variables To Save Fields Errors
        $err['username'] = array();
        $err['first_name'] = array();
        $err['last_name'] = array();
        $err['birthdate'] = array();
        $err['gender'] = array();
        $err['email'] = array();
        $err['core_countries_id'] = array();
        $err['address'] = array();
        $err['phone'] = array();
        $err['password'] = array();
        $err['password_confirm'] = array();


        /**********************************/
        /*Check If Any Field Is Empty*/
        /**********************************/
        if(empty($data['username'])) {
            $found_error = true;
            $err['username'][] = $langPackage['field_is_empty'];
        }
        if(empty($data['first_name'])) {
            $found_error = true;
            $err['first_name'][] = $langPackage['field_is_empty'];
        }
        if(empty($data['last_name'])) {
            $found_error = true;
            $err['last_name'][] = $langPackage['field_is_empty'];
        }
        if(empty($data['birthdate'])) {
            $found_error = true;
            $err['birthdate'][] = $langPackage['field_is_empty'];
        }
        if(empty($data['gender'])) {
            $found_error = true;
            $err['gender'][] = $langPackage['field_is_empty'];
        }
        if(empty($data['email'])) {
            $found_error = true;
            $err['email'][] = $langPackage['field_is_empty'];
        }
        if(empty($data['core_countries_id'])) {
            $found_error = true;
            $err['core_countries_id'][] = $langPackage['field_is_empty'];
        }
        if(empty($data['address'])) {
            $found_error = true;
            $err['address'][] = $langPackage['field_is_empty'];
        }
        if(empty($data['phone'])) {
            $found_error = true;
            $err['phone'][] = $langPackage['field_is_empty'];
        }
        if(empty($data['city'])) {
            $found_error = true;
            $err['city'][] = $langPackage['field_is_empty'];
        }
        if(empty($data['password'])) {
            $found_error = true;
            $err['password'][] = $langPackage['field_is_empty'];
        }
        if(empty($data['password_confirm'])) {
            $found_error = true;
            $err['password_confirm'][] = $langPackage['field_is_empty'];
        }
        /**********************************/
        /* End Check If Any Field Is Empty*/
        /**********************************/


        //Check Username Exists
        $exists = $this->usernameExists($data['username']);
        if($exists['exists']) {
            $found_error = true;
            $err['username'][] = $langPackage['username_exists'];
        }

        //Check Email exists
        $exists = $this->emailExists($data['email']);
        if($exists['exists']) {
            $found_error = true;
            $err['email'][] = $langPackage['email_exists'];
        }

        //Check Email Validity
        $is_Valid = $this->isEmailValid($data['email']);
        if(!$is_Valid) {
            $found_error = true;
            $err['email'][] = $langPackage['email_invalid'];
        }

        //Check phone Exists
        $exists = $this->phoneExists($data['phone']);
        if($exists['exists']) {
            $found_error = true;
            $err['phone'][] = $langPackage['phone_exists'];
        }


        //Calculate Age
        $age_calculation = $this->calculateAge($data['birthdate']);
        if($age_calculation<18) {
            $found_error = true;
            $err['birthdate'][] = $langPackage['at_least_18'];
        }

        if($data['core_countries_id'] == 70) {
            if($age_calculation<21) {
                $found_error = true;
                $err['birthdate'][] = $langPackage['at_least_21'];
            }
        }


        /**********************************/
        /*Password Consistency*/
        /**********************************/
        $uppercase = preg_match('@[A-Z]@', $data['password']);
        $lowercase = preg_match('@[a-z]@', $data['password']);
        $number    = preg_match('@[0-9]@', $data['password']);
        if(!$uppercase || !$lowercase || !$number || strlen($data['password']) < 8) {
            $found_error = true;
            $err['passwrod'][] = "Password isn't strong enough!";
        } else {
            if($data['password']!=$data['password_confirm']) {
                $found_error = true;
                $err['password_confirm'][] = $langPackage['passwords_dont_match'];
            }
        }
        /**********************************/
        /*End Password Consistency*/
        /**********************************/



        if(!$found_error) {
            return array("code"=>10);
        }

        else {
            return array("code"=>20,'errors'=>$err);
        }
    }


    /**
     * @param $fb_id
     * @param $full_name
     * @param $email
     * @param $birthday
     * @param $gender
     * @return array
     */
    public function fb_registration($fb_id,$full_name,$email,$birthday,$gender) {

        //If Any parameter Is Empty
        if(empty($fb_id) || empty($full_name) || empty($email) || empty($birthday) || empty($gender) ) {
            return array("code"=>50);
        }


        $db = $this->db;

        $fb_id = $db->escape($fb_id);
        $full_name = $db->escape($full_name);
        $email = $db->escape($email);
        $birthday = $db->escape($birthday);
        $gender = $db->escape($gender);
        $gender = $gender=="Male"?1:0;


        $age = $this->calculateAge($birthday);

        if($age<18) {
            return array("code"=>104);
        }

        $insert_data = array(
            "fb_id"=>$fb_id,
            "fullname"=>$full_name,
            "username"=>$email,
            "email"=>$email,
            "birthdate"=>$age,
            "gender"=>$gender,
            "core_countries_id"=>2
        );

        $insert_id = $db->insert("core_users",$insert_data);
        if($insert_id) {
            return array("code"=>10,"user_id"=>$insert_id);
        } else {
            return array("code"=>20);
        }
    }


    /**
     * @param $g_id
     * @param $full_name
     * @param $email
     * @param $age
     * @param $gender
     * @return array
     */
    public function google_registration($g_id,$full_name,$email,$age,$gender) {

        //If Any parameter Is Empty
        if(empty($g_id) || empty($full_name) || empty($email) || empty($age) || empty($gender) ) {
            return array("code"=>50);
        }

        $db = $this->db;

        $g_id = $db->escape($g_id);
        $full_name = $db->escape($full_name);
        $email = $db->escape($email);
        $gender = $db->escape($gender);
        $gender = $gender=="male"?1:0;


        $insert_data = array(
            "g_id"=>$g_id,
            "fullname"=>$full_name,
            "username"=>$email,
            "email"=>$email,
            "gender"=>$gender,
            "core_countries_id"=>2
        );

        $insert_id = $db->insert("core_users",$insert_data);
        if($insert_id) {
            return array("code"=>10,"user_id"=>$insert_id);
        } else {
            return array("code"=>20);
        }

    }



    /**
     * @param $birthDate - "12/17/1983"//---MM/DD/YYYY
     * @return int
     */
    private function calculateAge($birthDate) {


        $db_birthday = $birthDate;

        //explode the date to get month, day and year
        $birthDate = explode("-", $birthDate);

        $year = $birthDate[0];
        $month = $birthDate[1];
        $day = $birthDate[2];

        //get age from date or birth date
        $age = (
            date("md",
            date("U", mktime(0, 0, 0, $month, $day, $year))) > date("md")
            ?
                ((date("Y") - $year) - 1)
            :
                (date("Y") - $year)
        );



        // return array("age"=>(int)$age,"birth"=>$db_birthday);
        return $age;
    }






}














