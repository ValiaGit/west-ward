<?php


if(!defined("APP")) {
    header('HTTP/1.0 404 Not Found');
    die("<h1>Not Found</h1>");
}

require_once('error_codes.php');


class Base {



    /**
     * @param $parameters
     * @return bool
     */
    public function checkHash($parameters) {


        //Validate Parameters Passed To THis Function
        if(gettype($parameters) == 'object') {
            $parameters = json_decode(json_encode($parameters), true);
        }
        if(!$parameters) return false;



        $hashString = "";


        $providerID = $parameters['providerID'];
        if(!$providerID) return false;


        global $db;

        //Get SecretKeyFrom Providers Table
        $db->where("guid",$providerID);
        $provider_data = $db->getOne("core_providers","guid_secret,id");

        if(!$provider_data) return false;


        $hashString.=$providerID;

        $kk = "";

        foreach ($parameters as $paramKey=>$paramValue) {
            if ($paramKey != 'providerID' && $paramKey != 'hash') {


                if ($paramKey == "isVerified" || $paramKey == "isSingle" || $paramKey == "isActive" || $paramKey == "isInvite" || $paramKey == "transactionIsCash" || $paramKey == "isCardVerification" || $paramKey == "isCoreTransactionID" || $paramKey == "useProviderID" || $paramKey == "shouldWaitForApproval")
                    $hashString .= (int)$parameters[$paramKey] == 1 ? "true" : "false";
                else
                    $hashString .= $parameters[$paramKey];
            }
        }
        $hashString.=$provider_data['guid_secret'];



        $calculated_hash = md5($hashString);

        $hash = $parameters['hash'];
        if($calculated_hash != $hash) return false;


        return $provider_data['id'];
    }


    /**
     * @param $object
     * @return mixed
     */
    public function ObjectToArray($object) {
        if(gettype($object) == 'object') {
            return json_decode(json_encode($object), true);
        }

        return $object;
    }



    /**
     * @param $code
     * @return array
     */
    public function getErrorResponse($code,$returnValue = "") {

        $return = array();
        $return['result'] = array(
            "responseCode"=>$code
        );

        if($returnValue) {
            $return['result']['transactionID'] = $returnValue;
        }


        return $return;
    }

    /**
     * @param $code
     * @return array
     */
    public function getStatusErrorResponse($code,$returnValue = false) {
        $return = array();
        $return['result'] = array(
            "statusCode"=>$code
        );

        if($returnValue) {
            $return['result']['transactionID'] = $returnValue;
        }


        return $return;
    }




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