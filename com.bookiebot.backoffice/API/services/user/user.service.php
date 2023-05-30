<?php


if(!defined('APP')) {
    die();
}


class User extends Service {

    /**
     * @param array $filter
     * @return array
     */
    public function getUserList($skip=false, $pageSize=10, $filter = array()) {

        //Db Object
        $db = $this->db;

        $clause = "";

        $pageSize = (int)$pageSize;
        $skip = (int)$skip;

        $clause = $this->ReturnKendoFilterClause($filter,true,true);



        //Get Data
        $retrieve_fields = "
            core_users.id as core_users__id,
            core_users.core_countries_id,
            core_users.address,
            core_users.address_zip_code,
            core_users.status,
            core_users.last_login_date,
            core_users.phone,
            DATE_FORMAT(registration_date, '%Y-%m-%dT%TZ') as registration_date,
            core_users.birthdate,
            core_users.username,
            CONCAT(first_name,' ',last_name) as fullname,
            core_users.balance,
            core_users.gender,
            core_users.is_email_confirmed,
            core_users.is_phone_confirmed,
            core_users.is_passport_confirmed,
            core_users.email,
            core_users.last_login_date,
            core_countries.long_name
        ";


        $query = "SELECT $retrieve_fields FROM core_users,core_countries WHERE core_users.core_countries_id = core_countries.id $clause GROUP BY core_users.id ORDER BY core_users.id DESC LIMIT $pageSize OFFSET $skip";




        $data = array();

        $instance = $db->getSQLIInstance();

        if($result = $instance->query($query)) {
            while ($row = mysqli_fetch_assoc($result)) {
                if($row['status'] == 7 || $row['status'] == "7") {
                    $row['email'] = 'N/A - User is suspended permanently!';
                }
                array_push($data,$row);
            }
        }


        try {

            // $total = $db->rawQuery("SELECT COUNT(*) as cnt FROM core_users WHERE id>0 $clause");
            if($result = $instance->query("SELECT COUNT(*) as cnt FROM core_users WHERE id>0 $clause")) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $total = $row['cnt'];
                }
            }




        } catch(Exception $e) {
            $total = 0;
        }

        //Iterate Over All Users
        foreach($data as $index => $user) {
            $curUserId = $user['core_users__id'];
            //Check Has Self Exclusion
            $qs = "
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
                                      has_protections.core_users_id = $curUserId
                                    AND
                                      types.id = has_protections.core_protection_types_id
                                    AND
                                      has_protections.expire_date > NOW() AND types.id = 3
                                    ";

//            echo $qs;
//            echo "================$curUserId";

            $data_exclude = $db->rawQuery($qs);

            if($data_exclude) {
                if(count($data_exclude)) {
                    $data[$index]['email'] = 'N/A - User is self excluded!';
                }
            }




        }



        return array("code"=>10,"data"=>$data,"total"=>$total);
    }


    /**
     * @param bool $skip
     * @param int $pageSize
     * @param array $filter
     */
    public function getBalanceHistory($skip=false, $pageSize=10, $filter = array()) {
        //Db Object
        $db = $this->db;

        $clause = "";

        $pageSize = (int)$pageSize;
        $skip = (int)$skip;

        $clause = $this->ReturnKendoFilterClause($filter,false);

//echo $clause;
        $data = $db->rawQuery("
                  SELECT

                        core_daily_balance_snapshots.core_users_id as core_daily_balance_snapshots__core_users_id,
                        core_daily_balance_snapshots.balance,
                        core_daily_balance_snapshots.balance_date,
                        core_daily_balance_snapshots.datestring as core_daily_balance_snapshots__datestring

                     FROM
                      core_daily_balance_snapshots

                      $clause

                      ORDER BY core_daily_balance_snapshots.id DESC LIMIT $pageSize OFFSET $skip
             ");


        $result = $db->rawQuery("SELECT COUNT(*) as cnt FROM core_daily_balance_snapshots $clause");
        if($result) {
            if(count($result)) {
                $total = $result[0]['cnt'];
            }

        }

        return array("code"=>10,"data"=>$data,"total"=>$total);


    }


    /**
     * @param $user_id
     * @return array
     */
    public function getUser($users_id) {
        $users_id = (int)$users_id;
        if(!$users_id) {
            return array("code"=>50);

        }
        $db = $this->db;
        //Get Data
        $retrieve_fields = "
            id,
            core_countries_id,
            address,
            address_zip_code,
            city,
            status,
            phone,
            DATE_FORMAT(registration_date, '%Y-%m-%dT%TZ') as registration_date,
            birthdate,
            username,
            CONCAT(first_name,' ',last_name) as fullname,
            balance,
            gender,
            is_email_confirmed,
            is_phone_confirmed,
            is_passport_confirmed,
            email
        ";
        $db->orderBy("id","DESC");
        $db->Where("id",$users_id);
        $data = $db->get("core_users",null,$retrieve_fields);

        return array("code"=>10,"data"=>$data);

    }


    public function verifyPassport($user_id = false) {
        $db = $this->db;
        $user_id = (int)$user_id;
        $db->where("id",$user_id);

        $update = $db->update("core_users",array("is_passport_confirmed"=>1));
        if($update) {
            $this->saveLog("User passport was verified: ClientId:$user_id");
            return array("code"=>10);
        } else {
            return array("code"=>20);
        }
    }
    public function unVerifyPassport($user_id = false) {
        $db = $this->db;
        $user_id = (int)$user_id;
        $db->where("id",$user_id);
        $update = $db->update("core_users",array("is_passport_confirmed"=>0));
        if($update) {
            $this->saveLog("User passport was unverified: ClientId:$user_id");
            return array("code"=>10);
        } else {
            return array("code"=>20);
        }
    }



    public function blockUser($user_id = false) {
        $db = $this->db;
        $user_id = (int)$user_id;
        $db->where("id",$user_id);

        $update = $db->update("core_users",array("status"=>2));


        if($update) {
            $this->saveLog("User was blocked: ClientId:$user_id");
            return array("code"=>10);
        } else {
            return array("code"=>20);
        }
    }
    public function unBlockUser($user_id = false) {
        $db = $this->db;
        $user_id = (int)$user_id;
        $db->where("id",$user_id);



        $update = $db->update("core_users",array("status"=>1));
        if($update) {
            $this->saveLog("User was un blocked: ClientId:$user_id");
            return array("code"=>10);
        } else {
            return array("code"=>20);
        }
    }


    public function suspendPermanently($user_id = false) {
        $db = $this->db;
        $user_id = (int)$user_id;
        $db->where("id",$user_id);


        $update = $db->update("core_users",array("status"=>7));
        if($update) {
            $this->saveLog("User was un suspended Permanently: ClientId:$user_id");
            return array("code"=>10);
        } else {
            return array("code"=>20);
        }
    }







}

