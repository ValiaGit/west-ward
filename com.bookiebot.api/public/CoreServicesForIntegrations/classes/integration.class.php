<?php

if(!defined("APP")) {
    header('HTTP/1.0 404 Not Found');
    die("<h1>Not Found</h1>");
}



require_once("_base.class.php");


class CoreIntegrationExposed extends Base {


    /**
     * @return array
     */
    public function getBalance($params) {

        $checkHash = $this->checkHash($params);


        //If Hash Was Not Correct
        if(!$checkHash) return $this->getStatusErrorResponse(CoreErrorCodes::WRONG_HASH);

        global $db;


        $db->where('id',$params->userID);
        $user_balance = $db->getOne("core_users","balance");
        if(!$user_balance)  return $this->getStatusErrorResponse(CoreErrorCodes::USERS_ACCOUNTS_NOT_FOUND);



        return  array(
            "result"=>array(
                "statusCode"=>CoreErrorCodes::STATUS_SUCCESS,
                "amount"=>$user_balance['balance']
            )
        );
    }



    /**
     * @param $params
     * @return mixed
     */
    public function getUserInfo($params) {

        $checkHash = $this->checkHash($params);

        if(!$checkHash) return array();

        $userID = $params->userID;

        global $db;

        $db->where('id',$userID);
        $userDetails = $db->getOne('core_users','status,username,email,first_name,last_name,core_currencies_id,gender,core_countries_id,gaming_index,phone');

        if($userDetails) {
            $returnData =
                array(
                    "result"=>array(
                        'ID' => $userID,
                        'StatusID' => $userDetails['status'],
                        'OTPEnabled' => null,
                        'GamingIndex' => $userDetails['gaming_index'],
                        'ActiveNotifications' => null,
                        'CanVerifyIDDoc' => null,
                        'Name' => $userDetails['first_name'],
                        'Surname' => $userDetails['last_name'],
                        'UserName' => $userDetails['username'],
                        'PreferredCurrencyID' => $userDetails['core_currencies_id'],
                        'EMail' => $userDetails['email'],
                        'Gender' => $userDetails['gender'],
                        'CountryID' => $userDetails['core_countries_id'],
                        'TelephoneNumber' => $userDetails['phone']
                    )
                );

            return $returnData;
        } else {
            return [];
        }




    }


    /**
     * @param $params
     * @return array
     * @throws Error
     */
    public function authenticateUserByToken($params) {


        try {

            $integration_provider_id = $this->checkHash($params);

            //If Hash Was Not Correct
            if(!$integration_provider_id) {
                return $this->getErrorResponse(CoreErrorCodes::WRONG_HASH);
            }

             //If Hash Was Correct Grab User Details And Return as Result
            $user_details = $this->userDetailsByToken($params->token,$integration_provider_id);
            if(!$user_details) {
                return $this->getErrorResponse(CoreErrorCodes::TOKEN_NOT_FOUND);
            }


            return array(
                "result"=>array(
                    "responseCode"=>CoreErrorCodes::STATUS_SUCCESS,
                    "PreferredCurrencyID"=>$user_details['core_currencies_id'],
                    "userName"=>$user_details['username'],
                    "userID"=>$user_details['id'],
                    "userIP"=>$user_details['ip']

                )
            );


        }catch(Exception $e) {
            throw new Error($e->getMessage());
        }
//        return array("result"=>array("code"=>10));



    }


    /**
     * @param $token
     * @param $integration_provider_id
     * @return array|bool
     */
    private function userDetailsByToken($token,$integration_provider_id) {
        global $db;


        $db->where("guid",$token);
        $db->where("core_providers_id",$integration_provider_id);
        $db->where("create_time <= DATE_ADD(NOW(),INTERVAL 35 SECOND)");

        //betting_outright.EventEndDate < DATE_ADD(NOW(),INTERVAL $minutes MINUTE)
        $token_details = $db->getOne("core_providers_tokens","id,core_users_id,INET_NTOA(ip) as ip");


        if(!$token_details) return false;


        //
        $user_id = $token_details['core_users_id'];


        //Get User Details
        $db->where("id",$user_id);
        $user_details = $db->getOne("core_users","id,username,balance,core_currencies_id");
        $user_details['ip'] = $token_details['ip'];


        //If No User Details Where Found
        if(!$user_details) return false;



        //Delete Token Because It Was Used Once
        $db->where("id",$token_details['id']);
        $db->delete("core_providers_tokens");

        return $user_details;
    }


    /**
     * @return array
     */
    public function changeUsersStatus() {
        return array(
            "result"=>array(
                "responseCode"=>11111
            )
        );
    }



    /**
     * @return array
     */
    public function exchange($fromCurrency,$toCurrency,$amount)
    {
        return array("result"=>array("statusCode"=>10,"amount"=>100));
    }



}

//getBalance
/**
userID: UserId,
currencyID: CurrencyId,
isSingle: false
 */

//authenticateUserByToken
//{providerID: Me.CoreProviderID, token: Token, hash: hash};



