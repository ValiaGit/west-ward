<?php


if(!defined('APP')) {
    die();
}

use WideImage\WideImage;

class Settings extends Service {
    private $db;

    
	/**
	* Get Info About Current User
	**/
    public function getUserInfo() {


        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];


            $db = $this->db;
            $db->where("id",$user_id);

            $data = $db->rawQuery("SELECT
                                        u.id as userId,
                                        u.username,
                                        u.first_name,
                                        u.last_name,
                                        u.nickname,
                                        u.address,
                                        u.address_zip_code,
                                        u.core_countries_id as cId,
                                        u.city,
                                        u.email,
                                        u.gender,
                                        u.phone,
                                        u.birthdate,
                                        u.name_privacy,
                                        u.bet_privacy,
                                        u.core_currencies_id,
                                        u.parent_affiliate_id,
                                        u.affiliate_type,
                                        
                                        is_email_confirmed,
                                        is_phone_confirmed,
                                        is_passport_confirmed,
                                        country.iso2 as country_iso,
                                        country.iso3 as country_iso3,
                                        country.short_name as country_name,
                                        
                                        
                                        currency.iso_code as currency_code,
                                        currency.iso_name as currency_name
                                   FROM
                                        core_users u,
                                        core_countries country,
                                        core_currencies currency
                                        

                                   WHERE
                                        u.id=?
                                        AND
                                        country.id = u.core_countries_id
                                        AND 
                                        currency.id = u.core_currencies_id
                                  ",array($user_id));
            $data = $data[0];
            if($data) {
                $data['thumbnail'] = $this->getUserImage($user_id,"thumb");
                return array("code"=>10,"data"=>$data,"server"=>APP_ID);
            }
            else {
                return array("code"=>30);
            }

        } else {
            return array("code"=>40);
        }
    }


    /**
     * Update Current User Account Information
     * @return array
     */
    public function updateUserInfo(
        $field_phone = false,
        $field_email = false,
        $field_city = false,
        $field_address = false,
        $field_nickname = false,
        $field_country = false,
        $field_password = false
    ) {
        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            $db = $this->db;

            //CHECK PASSWORD TO AFFECT CHANGES
            $session_service = $this->loadService("user/session");
            $check_password = $session_service->checkPassword($field_password);
            if($check_password['code'] != 10) {
                return array("code"=>-102,"msg"=>"Account Password is Wrong!");
            }

            $field_phone = $db->escape($field_phone);
            $field_email = $db->escape($field_email);
            $field_city = $db->escape($field_city);
            $field_address = $db->escape($field_address);
            $field_nickname = $db->escape($field_nickname);
            $field_country = $db->escape($field_country);

            $email_change = false;
            $phone_change = false;


            $update_data = array(
                "phone"=>$field_phone,
                "city"=>$field_city,
                "email"=>$field_email,
                "address"=>$field_address,
                "nickname"=>$field_nickname,
                "core_countries_id"=>$field_country,
            );


            $db->where("id",$user_id);
            $update = $db->update("core_users",$update_data);

            if($update) {


                //If User Changes Email He Has To Reconfirm Email
                if($field_email!= $user_data['email']) {
                    $email_change = true;
                    $db->where("id",$user_id);
                    $db->update("core_users",array("is_email_confirmed"=>0));
                    $user_data['email'] = $field_email;
                    $this->sendEmailVerification();
                }

                if($field_phone!= $user_data['phone']) {
                    $phone_change = true;
                    $db->where("id",$user_id);
                    $db->update("core_users",array("is_phone_confirmed"=>0));
                    $user_data['phone'] = $field_phone;
                    $this->sendPhoneVerification();
                }

                return array("code"=>10,"email_change"=>$email_change,"phone_change"=>$phone_change);
            }

            else {
                return array("code"=>102);
            }




        }

        else {
            return array("code"=>40);
        }
    }


    /**
     * @return array
     */
    public function updateProfileImage() {
        global $config;


        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            $image = $_FILES['image'];

            $type = $image['type'];

            if($type == "image/png" || $type == "image/jpg") {
                $tmp_file = $image['tmp_name'];
                $exploded = explode(".",$image['name']);
                $ext = end($exploded);

                $folder = UPLOADS_DIR."social/profile/".$user_id."/";

                $original_name = sha1($user_id."original");
                $thumb_name = sha1($user_id."thumb");

                $original_file = $original_name.".".$ext;

                if(!is_dir($folder)) {
                    mkdir($folder);
                }
                $file_path = $folder.$original_file;


                //If We Uploaded Original
                if(move_uploaded_file($tmp_file,$file_path)) {

                    $thumb = WideImage::load($folder.$original_file)->resize(120, 120)->FnsaveToFile($folder.$thumb_name.'.jpg');

                    if($thumb!==false) {
                        return array("code"=>10,"data"=>array(
                            "main"=>$config['base_href']."uploads/social/profile/".$user_id."/".$original_file,
                            "thumb"=>$config['base_href']."uploads/social/profile/".$user_id."/".$thumb_name.".jpg",
                        ));
                    } else {
                        return array("code"=>20);
                    }
                }

                else {
                    return array("code"=>104);
                }

            }
            else {
                return array("code"=>103,"msg"=>$type);
            }

        }

        else {
            return array("code"=>40);
        }



    }


    /**
     * Change password For Current Logged In User
     * @return array
     */
    public function changePassword() {

        global $config;

        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            $db = $this->db;

            $old_password = $db->escape($_POST['old_password']);
            $new_password = $db->escape($_POST['new_password']);
            $confirm_new_password = $db->escape($_POST['confirm_new_password']);

            if(empty($old_password) || empty($new_password) || empty($confirm_new_password)) {
                return array("code"=>50);
            }


            //If Passwords Are Confirmed
            if($new_password == $confirm_new_password) {

                    $re = "/^(?=.*[A-Z])(?=.*\\d).*$/";

                    $uppercase = preg_match('@[A-Z]@', $new_password);
                    $lowercase = preg_match('@[a-z]@', $new_password);
                    $number    = preg_match('@[0-9]@', $new_password);

                    if($old_password == $new_password) {
                        return array("code"=>70,"msg"=>"New password can not be same as old password!");
                    }

                    //Check If New Password Was Already Used In Past
                    $db->where('password',sha1($db->escape($old_password).$config['password_sault']));
                    $db->where('core_users_id',$user_id);
                    $had_password = $db->getOne("old_used_passwords","1");

                    if(($had_password)) {
                        return array("code"=>70,"msg"=>"You already used this password please choose different one!");
                    }


                    if(!$uppercase || !$lowercase || !$number ) {
                        return array("code"=>70,"msg"=>"New password is not strong enough!<br/> It should contain at least 8 characters including, minimum one uppercase, one lowercase and number!");
                    }




                    $session_service = $this->loadService("user/session");
                    $check_password = $session_service->checkPassword($old_password);

                    if($check_password['code'] == 10) {

                        $db->where("id",$user_id);
                        $update = $db->update("core_users",array("password"=>sha1($db->escape($confirm_new_password).$config['password_sault'])));
                        if($update) {

                            try {
                                $db->insert("old_used_passwords",array(
                                    "core_users_id"=>$user_id,
                                    "password"=>sha1($db->escape($confirm_new_password).$config['password_sault'])
                                ));
                            }catch(Exception $e) {

                            }

                            return array("code"=>10);
                        } else {
                            return array("code"=>30);
                        }
                    }

                    else {
                        return array("code"=>20,"errCode"=>101,"msg"=>"Old Password Is Wrong");
                    }


            }


        }

        else {
            return array("code"=>40);
        }
    }


    /**
     * @param $user_id
     * @param $type
     * @param bool $gender
     * @return string
     */
    public function getUserImage($user_id,$type,$gender = false,$suffix="") {
        global $config;


        $jwt = $this->loadService("user/JsonWebToken");
        if(isset($_COOKIE['session_token'])) {

            $session_token = $_COOKIE['session_token'];
            $decrypted = $jwt->decrypt($session_token);
            if($decrypted) {
                $gender = $decrypted['gender'];
            }

        }
        $folder = "public/uploads/social/profile/".$user_id."/";
        $original_name = sha1($user_id."original");
        $thumb_name = sha1($user_id."thumb");

        $original = ROOT_DIR."".$folder.$original_name.".jpg";
        $thumb = ROOT_DIR."".$folder.$thumb_name.".jpg";

        $folder_for_response = "uploads/social/profile/".$user_id."/";

        if(!file_exists($thumb)) {


            if($gender == 1) {
                $image = $config['client_url']."/_media/images/avatar$suffix.jpg";
            }

            else {
                $image = $config['client_url']."/_media/images/avatar0$suffix.jpg";
            }

        }

        else {
            switch($type) {
                case "original":
                    $image = $config['base_href']."".$folder_for_response.$original_name.".jpg";
                    break;
                case "thumb":
                    $image = $config['base_href']."".$folder_for_response.$thumb_name.".jpg";
                    break;
            }
        }



        return $image;


    }


    /**
     * @param int $bet_privacy
     * @param int $name_privacy - Should be seen nickname or fullname
     * @return array
     */
    public function updatePrivacyInfo($bet_privacy = 1,$name_privacy = 0) {
        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            $bet_privacy = (int) $bet_privacy;
            $name_privacy = (int) $name_privacy;

            $db = $this->db;
            $update = array(
                "bet_privacy"=>$bet_privacy,
                "name_privacy"=>$name_privacy
            );

            $db->where('id',$user_id);
            $update = $db->update("core_users",$update);
               if($update == true) {
                    return array("code"=>10);
               }
               else {
                    return array("code"=>30);
               }

        }

        else {
            return array("code"=>40);
        }
    }


    
    /**
     * Returns All The Documents User Has Added For His Identity
     */
    public function getUserDocuments() {
        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            $db = $this->db;

            $data = $db->rawQuery("
                SELECT
                  core_documents.id,
                  core_documents.identity_type,
                  core_documents.document_number,
                  DATE_FORMAT(core_documents.date_modified, '%Y-%m-%d') as date_modified,
                  IF(ISNULL(core_documents.copy_file_path),0,1) as has_uploaded,
                  core_documents.IsVerified,
                  core_countries.short_name as country
                FROM
                  core_documents,
                  core_countries
                WHERE
                  core_documents.core_countries_id = core_countries.id
                  AND
                  core_documents.core_users_id = ?
                ORDER BY
                  core_documents.id
                DESC
            ",array($user_id));



            if(count($data)) {
                return array(
                    "code"=>10,
                    "data"=>$data
                );
            }
            else {
                return array("code"=>60);
            }
        }

        else {
            return array("code"=>40);
        }
    }


    /**
     * Adds New Document To User Identity Documents
     * @param int $document_type
     * @param int $document_number
     * @param int $core_countries_id
     * @return array
     */
    public function addDocument($document_type = 0,$document_number = 0,$core_countries_id = 0) {


        if(!$document_number || !$document_type || !$core_countries_id) {
            return array("code"=>50);
        }

        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            $db = $this->db;
            $document_type = (int) $document_type;
            $core_countries_id = (int) $core_countries_id;
            $document_number = $db->escape($document_number);

            $insert_data = array(
                "core_users_id"=>$user_id,
                "identity_type"=>$document_type,
                "core_countries_id"=>$core_countries_id,
                "document_number"=>$document_number
            );

            $insert = $db->insert("core_documents",$insert_data);
            if($insert) {
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
     * @param int $document_id
     * @return array
     */
    public function addDocumentFile($document_id = 0) {

        global $config;

        if(!$document_id || !isset($_FILES['file'])) {
            return array("code"=>50);
        }

        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            $db = $this->db;
            $api_sault = $config['api_sault'];

            $user_folder = sha1(strrev($user_id.$api_sault));
            $upload_folder = UPLOADS_DIR."personal_documents/".$user_folder."/";
            if(!is_dir($upload_folder)){
                mkdir($upload_folder);
            }


            $file = $_FILES['file'];
            $type = $file['type'];

            if(IFn::CheckImageType($type)) {
                $tmp_file = $file['tmp_name'];
                $exploded = explode(".",$file['name']);
                $ext = end($exploded);


                $file_name = md5(strrev(time())).".".$ext;
                $file_path = $upload_folder.$file_name;

                //If We Uploaded Original
                if(move_uploaded_file($tmp_file,$file_path)) {
                    $thumb = WideImage::load($file_path)->resize(640, 480)->FnsaveToFile($file_path);
                    if($thumb!==false) {
                        $db->where("id",$document_id);
                        $db->where("core_users_id",$user_id);
                        $update = $db->update("core_documents",array("copy_file_path"=>"uploads/personal_documents/$user_folder/$file_name"));
                        if($update) {
                            return array("code"=>10);
                        } else {
                            return array("code"=>30);
                        }
                    } else {
                        return array("code1"=>20);
                    }
                }

                else {
                    return array("code"=>104);
                }

            }
            else {
                return array("code"=>103,"msg"=>"File type is wrong! Please upload .jpg or .png files!");
            }




        }

        else {
            return array("code"=>40);
        }

    }


    /************************************************** EMAIL CONFIRMS
     * Request Executes On This Function To Save and Send Email Confirmation
     * @return array
     */
    public function sendEmailVerification() {

        global $langPackage;
        global $config;
        global $lang;

        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];



            $saveEmailVerification = $this->saveEmailVerification($user_id);

            //If Insert Was Successfull
            if($saveEmailVerification['code'] == 10) {
                //Create Confirmation Text
                $email_confirmation_text = $langPackage['email_confirmation_text'];
                $email_confirmation_text = str_replace("{code}",$saveEmailVerification['token'],$email_confirmation_text);

                //Send Email
                $email_sender = $this->loadService("common/_emailsender");
                $email_sent = $email_sender->sendEmail($langPackage['email_confirmation_subject'],$email_confirmation_text);
                if($email_sent) {
                    return array("code"=>10);
                } else {

                    return array("code"=>40);
                }
            } else {

                return array("code"=>30);
            }




        }


        else {
            return array("code"=>20);
        }
    }


    /**
     * @param $user_id
     * @return array
     */
    private function saveEmailVerification($user_id) {
        //Create Confirmation Code
        $code = $this->generateToken();
        $db = $this->db;

        $db->where("core_users_id",$user_id);
        $db->delete("core_email_confirmations");

        //Save Code For User In Database
        $insert = $db->insert("core_email_confirmations",array(
            "core_users_id"=>$user_id,
            "confirmation_code"=>$code
        ));
        if($insert!==false) {
            return array("code"=>10,"token"=>$code);
        }
        return array("code"=>20);

    }



    /************************************************** end EMAIL CONFIRMS
     * @param string $code
     * @return array
     */
    public function verifyEmail($code = "")
    {
        if (empty($code)) {
            $code = $_POST['code'];
        }

        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            $db = $this->db;

            $code = $db->escape($code);

            $db->where('core_users_id', $user_id);
            $db->where('confirmation_code', $code);
            $confirmed = $db->getOne("core_email_confirmations", "1");
            if ($confirmed) {
                $db->where("id", $user_id);
                $update_user_as_confirmed = $db->update("core_users", array("is_email_confirmed" => 1));
                if ($update_user_as_confirmed) {

                    $db->rawQuery("DELETE FROM core_email_confirmations WHERE core_users_id=$user_id");
                    return array("code" => 10);
                } else {
                    return array("code" => 30);
                }
            } //Code is wrong
            else {
                return array("code" => 701);
            }

        } else {
            return array("code" => 20);
        }


    }



    /**************************************************PHONE CONFIRMS
     * @param bool|string $phone
     * @return array
     */
    public function sendPhoneVerification($phone = false) {

        global $config;

        $user_info = $this->getUserInfo();



        if($user_info['code'] == 10) {

            $profile_phone = $user_info['data']['phone'];
            $user_id = $user_info['data']['userId'];
            if($profile_phone == $phone) {
                $saved = $this->savePhoneConfirmation($user_id);
                if($saved['code'] == 10) {

                    //WEsTW@rder3344
                    //westward_sms

                    $phone = ltrim ($phone, '+');
                    //Send SMS
                    $MessageText = "Bookiebot!+Confirmation+code:+$saved[token]";
                    $curl = curl_init("http://api.clickatell.com/http/sendmsg?user=$config[sms_user]&password=$config[sms_pass]&api_id=$config[sms_api]&to=$phone&text=$MessageText");
                    curl_setopt($curl, CURLOPT_HEADER, false);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($curl);
                    return array("code"=>10);

                }
                else {
                    return array("code"=>-30,"msg"=>"Cant save confirmation code try again!");
                }
            }

            else {
                return array("code"=>-34,"msg"=>"Please 'Update Settings' before confirm new number!");
            }

        }

        else {
            return array("code"=>40);
        }

    }



    /**
     * @param $user_id
     * @return array
     */
    private function savePhoneConfirmation($user_id) {

        $db = $this->db;

        $code = rand(pow(10, 4-1), pow(10, 4)-1);
        $user_id = (int)$user_id;


        $db->where("core_users_id",$user_id);
        $db->delete("core_phone_confirmations");

        //Save Code For User In Database
        $insert = $db->insert("core_phone_confirmations",array(
            "core_users_id"=>$user_id,
            "confirmation_code"=>$code
        ));
        if($insert!==false) {
            return array("code"=>10,"token"=>$code);
        }
        return array("code"=>20);
    }


    /**************************************************END PHONE CONFIRMS
     * @param string $code
     * @return array
     */
    public function verifyPhoneNumber($code = false) {

        if(!(int)$code) {
            return array("code"=>50);
        }

        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            $db = $this->db;

            $code = $db->escape($code);

            $db->where('core_users_id', $user_id);
            $db->where('confirmation_code', $code);
            $confirmed = $db->getOne("core_phone_confirmations", "1");
            if ($confirmed) {
                $db->where("id", $user_id);
                $update_user_as_confirmed = $db->update("core_users", array("is_phone_confirmed" => 1));
                if ($update_user_as_confirmed) {
                    $db->rawQuery("DELETE FROM core_phone_confirmations WHERE core_users_id=$user_id");
                    return array("code" => 10);
                } else {
                    return array("code" => 30);
                }
            } //Code is wrong
            else {
                return array("code" => 701);
            }

        } else {
            return array("code" => 20);
        }
    }


    /**
     * @return string
     */
    protected function generateToken() {
        return md5(sha1(time().session_id()."Salt#$"));
    }


}