<?php


if(!defined('APP')) {
    die();
}

use Carbon\Carbon;

class Tokens extends Service {

    /**
     *
     */
    public function generateToken($provider_id) {


        //Check Guid Validity
        if (!$provider_id) {
            return array(
                "code"=>50,
                "msg"=>"Wrong Provider ID"
            );
        }

        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user = $user_data['id'];

            $db = $this->db;

            //Check If Provider Id Exists
            $db->where ('guid', $provider_id);
            $exists_provider = $db->getOne('core_providers','id');
            if(!$exists_provider) {
                return array("code"=>50,"msg"=>"Provided Id Doesnt exist");
            }


            //Get Provider Id
            $provider_id = $exists_provider['id'];
            if(!$provider_id) {
                return array("code"=>50,"msg"=>"Provided Id Doesnt exist");
            }

            function uuid_v4()
            {
                return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                    // 32 bits for "time_low"
                    random_mcrypt(), random_mcrypt(),

                    // 16 bits for "time_mid"
                    random_mcrypt(),

                    // 16 bits for "time_hi_and_version",
                    // four most significant bits holds version number 4
                    random_mcrypt(0x0fff) | 0x4000,

                    // 16 bits, 8 bits for "clk_seq_hi_res",
                    // 8 bits for "clk_seq_low",
                    // two most significant bits holds zero and one for variant DCE1.1
                    random_mcrypt(0x3fff) | 0x8000,

                    // 48 bits for "node"
                    random_mcrypt(), random_mcrypt(), random_mcrypt()
                );
            }

            function random_mcrypt($max = 0xffff)
            {
                $int = current(unpack('S', mcrypt_create_iv(2, MCRYPT_DEV_URANDOM)));
                $factor = $max / 0xffff;
                return round($int * $factor);
            }



            //Delete All Old Tokens For current user for current provider
            $db->where("core_providers_id",$provider_id);
            $db->where("core_users_id",$user);
            $db->delete("core_providers_tokens");



            //Generate And Save Provider UUID for Current User
            $insert_data = array(
                "guid"=>uuid_v4(),
                "core_users_id"=>$user,
                "core_providers_id"=>$provider_id,
                "ip"=> ip2long(IP)
            );


            $inserted_token = $db->insert("core_providers_tokens",$insert_data);
            if($inserted_token!==false) {
                $return_array = array(
                    "code"=>10,
                    "token"=>$insert_data['guid']
                );
                return $return_array;
            } else {
                return array("code"=>30);
            }


        }
        else {
            return ['code'=>20];
        }

    }

    

}