<?php


if (!defined('APP')) {
    die();
}




class Session extends Service
{


    public function __construct()
    {
        parent::__construct();
        $this->jwt = $this->loadService("user/JsonWebToken");
    }

    /**
     * Check if Session is Alive From Clientside Request Client should provide current user_id by POST
     * This doent check grantAccess this just checks if session is Alive
     * @return array
     */
    public function checkSession()
    {
        //Check if client provided user_id
        if (!isset($_POST['user_id'])) {
            self::logout(true);
            return array("success" => false);
        }

        $db = $this->db;


        $user_id = (int)$_POST['user_id'];
        //Check Ip Is Blocked Fro Current User
        $is_blocked = $this->checkIpIsBlocked($user_id);
        if ($is_blocked['code'] == 10) {
            $this->logout(true);
            return array("code" => 20);
        }


        $token_from_request = isset($_COOKIE['session_token']) ? $_COOKIE['session_token'] : false;
        try {
            $headers = apache_request_headers();
            if($headers) {
                if(isset($headers['authorization'])) {
                    $token_from_request = $headers['authorization'];
                }
            }
        }catch(Exception $e) {

        }


        if ($token_from_request) {

            $session_token = $token_from_request;
            $decrypted = $this->jwt->decrypt($session_token);

            if ($decrypted) {


                if (isset($decrypted['ip']) && $decrypted['ip'] != IP) {
                    $this->logout(true);
                    return array("code" => 31, 'msg' => "During session your ip was changed, please re login!");
                }


                $user_id = $decrypted['id'];


                //Check If Session Expired With Inactivity
                $inactive_minutes = 60;
                $db->where('id', $user_id);
                $last_activity = $db->getOne('core_users', 'last_session_activity_time');
                if (count($last_activity)) {
                    if ($last_activity['last_session_activity_time']) {
                        try {

                            $exploded = explode(" ", $last_activity['last_session_activity_time']);
                            $datapart = explode("-", $exploded[0]);
                            $year = $datapart[0];
                            $month = $datapart[1];
                            $day = $datapart[2];

                            $timepart = explode(":", $exploded[1]);
                            $hour = $timepart[0];
                            $minute = $timepart[1];
                            $second = $timepart[2];

                            $last_session_activity_time = mktime($hour, $minute, $second, $month, $day, $year);

                            //2016-02-18 16:22:31


                            if ($last_session_activity_time) {

                                if ($last_session_activity_time < (time() - (60 * $inactive_minutes))) {
                                    $this->logout(true);
                                    return array("code" => 20, "msg" => "You are logged out for inactivity!");
                                }

                            }
                            $last_activity['last_session_activity_time'];
                        } catch (Exception $e) {

                        }
                    }
                }


                //Check Simultaneous Login And Deny Permission
                $grantSessionToken = $decrypted['grantSessionToken'];

                $checkSessionInDb = $db->rawQuery("
                    SELECT
                      u.id,
                      u.username,
                      CONCAT(u.first_name,' ',u.last_name) as fullname,
                      u.first_name,
                      u.last_name,
                      u.balance,
                      u.gender,
                      u.email,
                      u.grantSession,
                      u.phone,
                      u.status,
                      u.is_email_confirmed,
                      u.is_passport_confirmed,
                      u.core_currencies_id,
                      u.parent_affiliate_id,
                      u.affiliate_type,
                      currency.iso_code as currency_code,
                      currency.iso_name as currency_name
                      
                    FROM
                      core_users u,
                      core_currencies currency
                    WHERE
                      u.id = ?
                      AND 
                      u.grantSession = ?
                      AND 
                      currency.id = u.core_currencies_id
                    LIMIT 1
                ", array($user_id, $grantSessionToken));




                if (!$checkSessionInDb) {
//                    $this->logout();
                    return array("code" => 20);
                }

                if (count($checkSessionInDb)) {
                    $checkSessionInDb = $checkSessionInDb[0];
                }

                $status = $checkSessionInDb['status'];
                if ($status != 1) {

                    if ($status == 2) {
                        return array(
                            "code" => -185,
                            "msg" => "Your account is blocked! Please contact support@bookiebot.com"
                        );
                    }
                    if ($status == 3) {
                        return array(
                            "code" => -185,
                            "msg" => "Your account is suspended! Please contact support@bookiebot.com"
                        );
                    }
                    if ($status == 4) {
                        return array(
                            "code" => -185,
                            "msg" => "Your account is self exluded! Please contact support@bookiebot.com for info"
                        );
                    }
                }

                $checkSessionInDb['thumb'] = $this->loadService("user/settings")->getUserImage($user_id, "thumb", "24x24");

                $response = array(
                    "code" => 10,
                    'user' => $checkSessionInDb,
                    "server" => APP_ID
                );
                if (isset($decrypted['kick_off_time'])) {

                    if ($decrypted['kick_off_time'] <= time()) {
                        $this->logout(true);
                        return array("code" => 20, "msg" => "Session TimeOut Protection Logged you out!");
                    }

                    $response['kick_off_time'] = $decrypted['kick_off_time'];
                    $response['until_cick_off'] = $decrypted['kick_off_time'] - time();


                }


                $db->rawQuery("UPDATE core_users SET last_session_activity_time=NOW() WHERE id=$user_id");

                return $response;
            } else {
                $this->logout(true);
                return array(
                    "code" => 20
                );
            }


        }



        else {

            $this->logout(true);
            return array(
                "code" => 20
            );
        }


    }

    /**
     * Login User via API
     * Gets username and password with POST method
     * @return array|bool
     */
    public function login($username = false, $password = false)
    {

        global $config;


        //Check Restriction On Wrong Password Attempts
        $restriction_check = $this->checkAttempts($username);
        if ($restriction_check['isRestricted'] == true) {
            return array(
                "code" => -2,
                "restriction_expiry_time" => $restriction_check['restriction_expiry_time'],
                "ip" => IP);
        }


        //Check if service provided username and password values
        if (!$username || !$password) {
            if (!isset($_POST['username']) || !isset($_POST['password'])) {
                return array("code" => 20);
            }
        }


        //Create Instance To Work With Database
        $db = $this->db;


        $user = $db->rawQuery("SELECT
                              u.id,
                              u.username,
                              CONCAT(u.first_name,' ',u.last_name) as fullname,
                              u.first_name,
                              u.last_name,
                              u.balance,
                              u.gender,
                              u.email,
                              u.phone,
                              u.status,
                              u.status,
                              u.is_email_confirmed,
                              u.is_passport_confirmed,
                              u.core_currencies_id,
                              u.parent_affiliate_id,
                              u.affiliate_type,
                              currncy.iso_code as currency_code,
                              currncy.iso_name as currency_name
                      FROM
                        core_users u ,
                        core_currencies currncy
                        WHERE
                        (
                          u.username='" . $db->escape($username) . "'
                          OR
                          u.email = '" . $db->escape($password) . "'
                        )
                        AND
                            currncy.id = u.core_currencies_id
                        AND
                        u.password='" . sha1($db->escape($password) . $config['password_sault']) . "' AND status=1");


        //If User Found Start Session
        if (isset($user[0])) {
            $user = $user[0];


            if ($user['status'] != 1) {

                switch ($user['status']) {
                    case 2:
                        return array(
                            "code" => -185,
                            "msg" => "Your account is blocked! Please contact support@bookiebot.com"
                        );
                        break;
                    case 3:
                        return array(
                            "code" => -185,
                            "msg" => "Your account is suspended! Please contact support@bookiebot.com"
                        );
                        break;
                    case 9:
                        return array(
                            "code" => -185,
                            "msg" => "Your account is de-registered! You can not use this account any more!"
                        );
                        break;
                    case 4:
                        return array(
                            "code" => -185,
                            "msg" => "Your account is self exluded! Please contact support@bookiebot.com for info!"
                        );
                        break;
                }

                return false;
            }


            //Check If User Is Self Excluded
            $protection_service = $this->loadService("user/protection");
            $protections = $protection_service->_checkProtection($user['id']);

            $has_session_timeout_protection = false;
            $has_session_timeout_duration_minutes = false;


            if ($protections['code'] == 10) {
                if (isset($protections['protections'][3])) {
                    return array(
                        "code" => -85,
                        "msg" => "Your account has self exclusion protection!",
                        "protection" => $protections['protections'][3]
                    );
                }


                if (isset($protections['protections'][1])) {
                    return array(
                        "code" => -89,
                        "msg" => "Your account has time out protection!",
                        "protection" => $protections['protections'][1]
                    );
                }

                if (isset($protections['protections'][6])) {
                    $has_session_timeout_protection = true;
                    $has_session_timeout_duration_minutes = $protections['protections'][6]['period_minutes'];
                }

            }


            //Check Ip Is Blocked Fro Current User
            $is_blocked = $this->checkIpIsBlocked($user['id']);
            if ($is_blocked['code'] == 10) {
                return array("code" => -65, "email" => $user['email'], "msg" => "Ip is restricted for current user!");
            }

            $grantSessionToken = $this->getAuthGrantSessionToken();
            $user['grantSessionToken'] = $grantSessionToken;
            $db->where('id', $user['id']);
            $save_grant_session = $db->update("core_users", array("grantSession" => $grantSessionToken));

            if ($save_grant_session) {

                if ($has_session_timeout_protection && $has_session_timeout_duration_minutes) {
                    $user['kick_off_time'] = time() + ($has_session_timeout_duration_minutes * 60);
                } else {
                    $user['kick_off_time'] = time() + (180 * 60);
                }

                $db->rawQuery("UPDATE core_users SET last_login_date=NOW() WHERE id=" . $user['id']);
                $db->rawQuery("UPDATE core_users SET last_session_activity_time=NOW() WHERE id=" . $user['id']);

                $user['ip'] = IP;
                $user['affiliation_id'] = "";
                try {
                    $user['affiliation_id'] = Fn::encodeUserIdToAffiliateID($user['id']);
                }catch(Exception $e) {

                }
                $token = $this->jwt->encrypt($user);

                if(isset($_POST['is_from_mobile'])) {
                    $user['session_token'] = $token;
                }

                setcookie("session_token", $token , time() + 9800, "/", $config['cookie_domain'], false, true);
                setcookie("user_id", $user['id'], time() + 9800, "/", $config['cookie_domain'], false, false);
                setcookie("currency_id", $user['core_currencies_id'], time() + 9800, "/", $config['cookie_domain'], false, false);
                setcookie("currency_name", $user['currency_name'], time() + 9800, "/", $config['cookie_domain'], false, false);
                setcookie("currency_code", $user['currency_code'], time() + 9800, "/", $config['cookie_domain'], false, false);
                setcookie("affiliation_id", $user['affiliation_id'], time() + 9800, "/", $config['cookie_domain'], false, false);
                setcookie("parent_affiliate_id", $user['parent_affiliate_id'], time() + 9800, "/", $config['cookie_domain'], false, false);


                $this->saveAccessLog($user['id']);
                $this->resetLoginAttempts($username);
                $user['thumb'] = $this->loadService("user/settings")->getUserImage($user['id'], "thumb");



                return array("code" => 10, "user" => $user);
            } else {
                $this->saveFailedAttempt($db->escape($username));
                return array("code" => 20);
            }


        } else {
            $this->saveFailedAttempt($db->escape($username));
            return array("code" => 20);
        }

    }

    /**
     * Generates Token Which Is Saved In Database After user Logs in
     * To Commit Future Actions
     * @return string
     */
    private function getAuthGrantSessionToken()
    {
        global $config;
        $token = base64_encode(hash("md5", strrev(time()) . $config['auth_sault'], True));
        return $token;
    }

    /**
     * If User Provided Wrong Credentials On Log In
     * Register Attempt To Restrict Future Attempts
     */
    private $ip_restriction_minutes = 30;
    private $login_attempts_number = 3;

    private function saveFailedAttempt($username)
    {
        if (!isset($_SERVER['REMOTE_ADDR']) || $_SERVER['REMOTE_ADDR'] == "") {
            return false;
        }
        $db = $this->db;
        $ip = ip2long(IP);
//        echo $ip;

        $db->where("username", $username);
        $has_failed_attempts = $db->getOne("core_attempt_restrictions", "restriction_expiry_time,attempts");


        //If Fail Attempt Was First For Provided IP
        if (!$has_failed_attempts) {
            $insert_data = array(
                "ip" => $ip,
                "attempts" => 1,
                "username" => $username
            );
            $isnert = $db->insert("core_attempt_restrictions", $insert_data);
//            var_export($db->getLastError());

        } //If Had Fail Actions Get Fails Number
        else {


            if ($has_failed_attempts['attempts'] < $this->login_attempts_number) {
                $restriction_expiry_time = "";
                if ($has_failed_attempts['attempts'] + 1 == $this->login_attempts_number) {
                    $restriction_expiry_time = ",restriction_expiry_time='" . date('Y-m-d H:i:s', strtotime("+" . $this->ip_restriction_minutes . " minutes")) . "'";
                }
                $db->rawQuery("update core_attempt_restrictions set attempts = attempts+1 $restriction_expiry_time WHERE username='$username'");
            }


            if ($has_failed_attempts['restriction_expiry_time'] != NULL
                &&
                strtotime($has_failed_attempts['restriction_expiry_time']) < time()
                &&
                $has_failed_attempts['attempts'] >= $this->login_attempts_number
            ) {
                $db->rawQuery("update core_attempt_restrictions set attempts = 1,restriction_expiry_time=NULL WHERE username='$username'");
            }


        }
    }


    private function checkAttempts($username)
    {
        if (!isset($_SERVER['REMOTE_ADDR']) || $_SERVER['REMOTE_ADDR'] == "") {
            return false;
        }
        $db = $this->db;
        $ip = ip2long(IP);

        $data = $db->rawQuery("
                              SELECT
                                restriction_expiry_time,
                                attempts
                            FROM
                                core_attempt_restrictions
                            WHERE
                              username='$username'
                              AND
                              restriction_expiry_time IS NOT NULL
                              AND
                              restriction_expiry_time > NOW()
                              AND
                              attempts >= $this->login_attempts_number
                              LIMIT 1
                             ");
        if (isset($data[0])) {
            return array("isRestricted" => true, "restriction_expiry_time" => $data[0]['restriction_expiry_time']);
        } else {
            return array("isRestricted" => false);
        }

    }

    private function resetLoginAttempts($username)
    {
        if (!isset($_SERVER['REMOTE_ADDR']) || $_SERVER['REMOTE_ADDR'] == "") {
            return false;
        }
        $db = $this->db;
        $ip = ip2long(IP);

        $db->where("username", $username);
        $db->update("core_attempt_restrictions", array("attempts" => 0, "restriction_expiry_time" => NULL));
    }

    /**
     * Destroy Session And Make Logout
     * @return array
     */
    public function logout($forced = false)
    {
        global $config,$db;

        if (!$forced) {
            $user_data = $this->checkUserAccess();
            if ($user_data) {
                $user_id = $user_data['id'];


                $db->where("id",$user_id);
                $db->update("core_users",['grantSession'=>md5(time().rand(1,1000))]);

                try {
                    if (isset($_COOKIE['session_token'])) {
                        unset($_COOKIE['session_token']);
                        setcookie('session_token', '', time() - 3600, '/', $config['cookie_domain'], false, true);
                    }
                    if (isset($_COOKIE['user_id'])) {
                        unset($_COOKIE['user_id']);
                        setcookie('user_id', '', time() - 3600, '/', $config['cookie_domain'], false, false);
                    }


                    $logoff_log = $this->saveLogoffLog($user_id);

                } catch (Exception $e) {
                    return array("success" => false);
                }
            }
        } else {
            if (isset($_COOKIE['session_token'])) {
                unset($_COOKIE['session_token']);
                setcookie('session_token', '', time() - 3600, '/', $config['cookie_domain'], false, true);
            }
            if (isset($_COOKIE['user_id'])) {
                unset($_COOKIE['user_id']);
                setcookie('user_id', '', time() - 3600, '/', $config['cookie_domain'], false, false);
            }
        }


        return array("success" => true);
    }

    /**
     * Check If User Is Authenticated and Has Access
     * Every Client Method That uses this method should send user_id with post
     **/
    public function hasAccess($needs_email_confirmation = false)
    {

        $session_data = $this->checkSession();
        if ($session_data) {
            if (isset($session_data['code'])) {
                if ($session_data['code'] == 10) {
                    return $session_data['user'];
                } else {
                    return false;
                }
            }

        } else {
            return false;
        }

    }


    /**
     * Save Access When User Logs in System
     **/
    private function saveAccessLog($user_id)
    {
        $user_id = (int)$user_id;
        $db = $this->db;
        if (!isset($_SERVER['REMOTE_ADDR']) || $_SERVER['REMOTE_ADDR'] == "") {
            return false;
        }

        $ip = ip2long(IP);
        $data = array(
            "core_users_id" => $user_id,
            "access_ip" => "$ip"
        );

        $insert_id = $db->insert("core_accesslog", $data);
        if ($insert_id) {
            return true;
        }
        return false;
    }

    /**
     * @param $user_id
     * @return bool
     */
    private function saveLogoffLog($user_id)
    {
        $user_id = (int)$user_id;
        $db = $this->db;

        $ip = ip2long(IP);
        $data = array(
            "core_users_id" => $user_id,
            "logoff_ip" => "$ip"
        );
        $insert_id = $db->insert("core_logofflog", $data);

        if ($insert_id) {
            return true;
        }
        return false;
    }

    /**
     * @return array
     */
    public function notifications()
    {
        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            $friends_service = $this->loadService("social/friends");
            $messages_service = $this->loadService("social/messaging");


            $friend_requests_count = $friends_service->getUnSeenRequestsCount($user_id);
            $new_messages_count = 0;
            $messages_service->getUnseenMessagesCount($user_id);

            $data = array(
                "friend_requests" => round($friend_requests_count),
                "new_messages_count" => round($new_messages_count)
            );

            return array("code" => 10, "data" => $data);
        } else {
            return array("code" => 40);
        }

    }

    /**
     * @param int $limit
     * @return array
     */
    public function getAccessLog($limit = 100)
    {
        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            $db = $this->db;
            $data = $db->rawQuery("
                                    SELECT
                                      accesslog.id,
                                      accesslog.access_time as t,
                                      INET_NTOA(accesslog.access_ip) as ip,
                                      blocked_ips.id as block_ip_id
                                    FROM
                                      core_accesslog accesslog

                                    LEFT JOIN
                                      core_blocked_ips blocked_ips
                                    ON blocked_ips.blocked_ip = accesslog.access_ip
                                    WHERE
                                      accesslog.core_users_id=?
                                    ORDER BY
                                      accesslog.access_time
                                    DESC
                                      LIMIT $limit
                                    ",
                array($user_id));


            if (count($data)) {
                return array(
                    "code" => 10,
                    "data" => $data
                );
            } else {
                return array("code" => 20);
            }
        } else {
            return array("code" => 40);
        }
    }


    /**
     * CHECK PASSWORD FOR CURRENT LOGGED IN USER
     * @param $password
     * @return array
     */
    public function checkPassword($password)
    {
        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            global $config;
            $db = $this->db;
            $password = sha1($db->escape($password) . $config['password_sault']);

            $db->where("id", $user_id);
            $db->where("password", $password);
            $check_password = $db->getOne("core_users", "1");
            if ($check_password) {
                return array("code" => 10);
            } else {
                return array("code" => 20);
            }

        } else {
            return array("code" => 20);
        }
    }

    /**
     * @param $user_id
     * @return mixed
     */
    private function checkIpIsBlocked($user_id)
    {
        //Check If Ip Is Blocked For Current User
        $block_ips_service = $this->loadService("user/blockips");
        $is_blocked = $block_ips_service->checkIpIsBlockedForUser($user_id, IP);
        return $is_blocked;
    }


    /**
     * @param $emailCode
     * @return array
     */
    public function confirmEmail($emailCode)
    {
        global $config;
        global $lang;


        $localIP = gethostbyname(trim(exec("hostname")));
        echo $localIP;
        echo "<br/>";
        echo rand();
        echo "<br/>";

        $db = $this->db;
        $emailCode = $db->escape($emailCode);

        $db->where('confirmation_code', $emailCode);
        $data = $db->getOne("core_email_confirmations", 'core_users_id');
        var_export($data);
        if ($data) {
            if ($data['core_users_id']) {

                $user_id = $data['core_users_id'];

                $db->startTransaction();

                //Save Confirmation
                $db->where("id", $user_id);
                $confirm_email = true;
                $db->update("core_users", array("is_email_confirmed" => 1));

                //delete code
                $db->where("core_users_id", $user_id);
                $delete_code = $db->delete("core_email_confirmations");

                //If ACTIONS SUCCEED
                if ($confirm_email && $delete_code) {

                    //Get user Data To Log In
                    $db->where("id", $user_id);
                    $user = $db->getOne("core_users", "id, username, CONCAT(first_name,' ',last_name) as fullname, first_name, last_name, balance, gender, email, phone");

                    //Check Ip Is Blocked Fro Current User
                    $is_blocked = $this->checkIpIsBlocked($user['id']);
                    if ($is_blocked['code'] == 10) {
                        return array("code" => -65, "email" => $user['email'], "msg" => "Ip is restricted for current user!");
                    }


                    $grantSessionToken = $this->getAuthGrantSessionToken();
                    $user['grantSessionToken'] = $grantSessionToken;
                    $db->where('id', $user['id']);
                    $save_grant_session = $db->update("core_users", array("grantSession" => $grantSessionToken));

                    if ($save_grant_session) {
                        setcookie("session_token", $this->jwt->encrypt($user), time() + 9800, "/", $config['cookie_domain'], false, true);
                        setcookie("user_id", $user['id'], time() + 9800, "/", $config['cookie_domain'], false, false);

                        $this->saveAccessLog($user['id']);
                        $this->resetLoginAttempts();
                        $db->commit();
                        echo "<script>window.location.href='$config[client_url]/$lang#email_confirmation_success';</script>";
                    } else {
                        return array("code" => 20);
                    }


                } else {
                    $db->rollback();
                    return array("code" => 30);
                }

            } else {
                return array("code" => 20);
            }
        } else {
            return array("code" => -10);
        }

    }


    /**
     * @return array
     */
    public function getBalance()
    {
        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];
            $db = $this->db;
            $db->where("id", $user_id);
            $balance = $db->getOne("core_users", "balance");
            if ($balance !== false) {
                return array("code" => 10, "balance" => $balance['balance']);
            }
            return array("code" => 30);
        } else {
            return array("code" => 20);
        }
    }

}


?>