<?php


namespace App\Integrations\Helpers;



class TokenGenerator {


    /**
     * @param array $parameters
     * @return mixed
     */
    public static function generateToken($parameters = []) {

        $time = time();
        $token_data = "";
        $string_to_hash = "";
        foreach($parameters as $key=>$value) {
            if($key == 'time' || $key == 'hash') {
                continue;
            }
            $string_to_hash.=$value;
            $token_data.=$key.'='.$value.'||';
        }
        $hash = sha1($string_to_hash . $time . env('TOKEN_CHECKSUM_KEY'));
        $token = $token_data . "time=". $time . "||hash=" . $hash;


        return UIDSecurity::encrypt($token);
    }


    /**
     * @param $token
     * @return mixed
     */
    public static function validateToken($token) {


        $token = UIDSecurity::decrypt($token);

        $parameters = explode("||", $token);

        if(!count($parameters)) return false;

        $last_item_index = count($parameters)-1;

        $data_to_return = array();


        $string_to_hash = "";
        foreach($parameters as $index=>$value) {
            if($index!=$last_item_index) {

                $split = explode("=",$value);

                $paramKey = $split[0];
                $paramValue = $split[1];

                $data_to_return[$paramKey] = $paramValue;

                $string_to_hash.=$paramValue;
            }
        }
        $string_to_hash.=env('TOKEN_CHECKSUM_KEY');

        $exploded = explode("=",$parameters[$last_item_index]);

        $hash = false;
        if(count($exploded)) {
            if(isset($exploded[1])) {
                $hash = $exploded[1];
            }
        }

        if(sha1($string_to_hash)!=$hash) {
            return false;
        }


        return $data_to_return;
    }

}


