<?php


namespace App\Integrations\Casino\Singular;

use App\Integrations\Casino\CasinoCoreInterface;
use App\Integrations\Casino\Singular\ErrorCodes;
use App\Integrations\Constants\GISErrorCodes;
use App\Integrations\ResponderTrait;


/**
 * Class SingularCasinoCore  -  Implementation Of integration With Singular Casino Core
 * @package App\Integrations\Caasino\Singular
 */
class CasinoCore implements CasinoCoreInterface
{

    use ResponderTrait;


    //Identifier Of Provider
    private static $provider_id;


    //Secret For Provider
    private static $secret;



    /**
     * SingularCasinoCore constructor.
     * @param $provider_id
     * @param $secret
     * @internal param $provider
     */
    public function __construct($provider_id, $secret)
    {
        //Set Integration Credentials And Config Locally
        self::$provider_id = $provider_id;
        self::$secret = $secret;

    }


    /**
     * This method in some cases can sacve Access token for subsequent queries with Casino Core
     * @param $token
     * @return array =
     *          SuccessResponse [ code=200, message='', data={}, external_success_code="" ]
     *          SuccessData Structure[
     *              userId          =>  '',
     *              userName        =>  '',
     *              currency        =>  '', ISO3 Code
     *              currencyId      =>  '', Optional
     *              ip              =>  '', Optional
     *              balance         =>  '', Optional
     *          ]
     *          FailResponse    [ code=-1, error_code="", error_message="",external_error_code]
     *          FailResponseErrorCode Possibilities = [
     *              GISErrorCodes::FORBIDDEN,
     *              GISErrorCodes::GENERAL_ERROR
     *          ]
     */
    public function auth( $token )
    {

        //Set Parameters Fro Call
        $parameters = [
            'providerID'=>self::$provider_id,
            'token' => $token
        ];

        //Call Service And Return Response
        $AuthResponse = $this->call(Config::CASINO_CORE_WEB_SERVICE_WSDL(), "authenticateUserByToken", $parameters);

        //If Response Doesn't Include result node
        if (!$AuthResponse || !isset($AuthResponse['result'])) {
            //TODO Log Properly
            //Log::warn("Core Responded with wrong data on authentication: ", $AuthResponse);
            return $this->respondError(GISErrorCodes::GENERAL_ERROR, 'Response From Core was wrong');
        }

        //Save Data In Local Variables
        $result = $AuthResponse['result'];
        $responseCode = $result['responseCode'];


        //If Authentication Of Token Was Successfull
        if ($responseCode == ErrorCodes::STATUS_SUCCESS) {


            //Auth Response That should be returned to game vendors
            $returnData = [
                "userId" => $result['userID'],
                "userName" => $result['userName'],
                "currency" => Config::CURRENCY_MAPPING[$result['PreferredCurrencyID']],
                "currencyId" => $result['PreferredCurrencyID'],
                "ip" => isset($result['userIP']) ? $result['userIP'] : null,
                "balance" => null//Some casinos may return balance with authenticationcall
            ];


            //TODO Wil be good to save userDetails In Session, and this can be used in subsequent requests


            //Return Successful Authentication Response To Game Vendors
            return $this->respondSuccess($returnData, 'Authentication Was Successful');

        }

        //If provided Token was expired
        else if ($responseCode == ErrorCodes::TOKEN_IS_EXPIRED) {
            //TODO Log Properly
            return $this->respondError(GISErrorCodes::FORBIDDEN, 'Token is expired', $responseCode);
        }

        //If Unhandled Error Code Happened
        else {
            //TODO Log Properly
            return $this->respondError(GISErrorCodes::FORBIDDEN, 'Authentication Failed', $responseCode);
        }


    }


    /**
     * @param $userId
     * @return array =
     *          SuccessResponse [ code=200,message='',data={},external_success_code ]
     *          SuccessData Structure [
     *                  'userId'=>null,
     *                  'firstName'=>null,
     *                  'lastName'=>null,
     *                  'userName'=>null,
     *                  'currency'=>null,
     *                  'currencyId'=>null,
     *                  'email'=>null,
     *                  'gender'=>null,
     *                  'country'=>null,//ISO3 CODE
     *                  'phone'=>null
     *          ]
     *          FailResponse [code = -1, error_code="", error_message="",external_error_code]
     *

     */
    public function getUserInfo($userId)
    {

        $parameters = [
            'providerID'=>self::$provider_id,
            'userID' => $userId
        ];

        //This Is BluePrint Of Mandatory Parameters, which should persist in response
        $returnData = [
            'userId' => null,
            'firstName' => null,
            'lastName' => null,
            'userName' => null,
            'currency' => null,
            'currencyId' => null,
            'email' => null,
            'gender' => null,
            'country' => null,//ISO3 CODE
            'phone' => null
        ];

        $userInfoResponse = $this->call(Config::CASINO_CORE_WEB_SERVICE_WSDL(), "getUserInfo", $parameters);

        //If User Found
        if ($userInfoResponse && isset($userInfoResponse['result'])) {

            //Result Data From Core
            $result = $userInfoResponse['result'];

            $returnData['userId'] = $result['ID'];
            $returnData['firstName'] = $result['Name'];
            $returnData['lastName'] = $result['Surname'];
            $returnData['userName'] = $result['UserName'];
            $returnData['currency'] = Config::CURRENCY_MAPPING[$result['PreferredCurrencyID']];//Translate CurrencyId in IOS3
            $returnData['currencyId'] = $result['PreferredCurrencyID'];
            $returnData['email'] = $result['EMail'];
            $returnData['gender'] = Config::GENDER_MAPPING[$result['Gender']];
            $returnData['country'] = $result['CountryID'];
            $returnData['phone'] = $result['TelephoneNumber'];


            return $this->respondSuccess($returnData, 'User data was grabbed successfully', ErrorCodes::STATUS_SUCCESS);
        }

        //Respond With Error
        else {
            return $this->respondError(GISErrorCodes::NOT_FOUND, 'User with requested Id Was Not Found');
        }


    }


    /**
     * For comments check Interface
     * @param $userId
     * @param $depositAmount
     * @param $currency
     * @param $gameTransactionRef
     * @param null $gameTransactionUniqueRef
     * @param null $gameId
     * @param null $additional_data
     * @return array
     *          SuccessResponse [ code=200,message='',data={},external_success_code='' ]
     *          SuccessData Structure [
     *                  casinoTransactionId =>''
     *          ]
     *          FailResponse [code = -1, error_code="", error_message="",external_error_code]
     *          FailResponse Possible ErrorCodes = [
     *              GISErrorCodes::TRANSACTION_ALREADY_EXISTS,
     *              GISErrorCodes::OPERATION_FAILED,
     *
     *          ]
     *
     */
    public function deposit($userId, $depositAmount, $currency, $gameTransactionRef, $gameTransactionUniqueRef = null, $userIP = null, $gameId = null, $additional_data = null)
    {

        //This blueprint is returned always from this method as response in case of success
        $returnDataBluePrint = [
            'casinoTransactionId' => null
        ];


        //Casino Core Call Parameters
        $parameters = [
            'providerID'=>self::$provider_id,
            'userID' => $userId,
            'currencyID' => array_search($currency, Config::CURRENCY_MAPPING),
            'amount' => $depositAmount,
            'isCardVerification' => false,
            'shouldWaitForApproval' => false,
            'providerUserID' => null,
            'providerOppCode' => $gameTransactionRef,
            'additionalData' => $additional_data,
            'requesterIP' => $userIP,
        ];


        //Request Deposit
        $depositResponse = $this->call(Config::CASINO_CORE_TRANSACTIONS_WSDL(), 'depositMoney', $parameters);


        //If We got 111 Error Wait 3 sec, then check transaction status and return response
        if (!$depositResponse || $depositResponse['result']['responseCode'] == ErrorCodes::GENERIC_FAILED_ERROR) {

            //Log::error("Transaction Deposit returned error: ", ['providerId' => self::$provider_id, 'response' => $depositResponse, 'parameters' => $parameters]);

            //Wait 3 seconds
            sleep(3);


            //Check Status And Response Properly
            $transactionStatusResponse = $this->checkTransactionStatus($gameTransactionRef);

            //If Transaction was procesed successfully
            if($transactionStatusResponse['code'] == GISErrorCodes::SUCCESS) {

                //Send SuccessData Back
                return $this->respondSuccess(
                    [
                        'casinoTransactionId'=>$transactionStatusResponse['data']['casinoTransactionId']
                    ],
                    'Transaction was processed successfully',
                    $transactionStatusResponse['external_success_code']
                );

            }

            //If After Transaction check status we got failed response
            else {

                //TODO LOG Properly
                return $this->respondError(
                    GISErrorCodes::OPERATION_FAILED,
                    'Transaction operation failed',
                    $transactionStatusResponse['error_code']
                );
            }


        }


        //If We got Success code return details
        elseif ($depositResponse['result']['responseCode'] == ErrorCodes::STATUS_SUCCESS) {

            //TODO Log Also Successful Transactions

            //Send SuccessData Back
            return $this->respondSuccess(
                [
                    'casinoTransactionId'=>$depositResponse['result']['returnValue']
                ],//Success Data
                'Transaction was processed successfully',//SuccessMessage
                $depositResponse['result']['responseCode']//External System Success code
            );

        }

        //If Transaction Was Already Processed
        elseif ($depositResponse['result']['responseCode'] == ErrorCodes::DUPLICATED_PROVIDERS_TRANSACTIONID) {

            //TODO Log Properly Request on duplicated transaction
            return $this->respondError(
                GISErrorCodes::TRANSACTION_ALREADY_EXISTS,
                'Transaction with provided Id already exists',
                $depositResponse['result']['responseCode']
            );
        }

        //Transaction Was not successful
        else {

            //TODO Log Properly
            return $this->respondError(
                GISErrorCodes::OPERATION_FAILED,
                'Transaction operation failed',
                $depositResponse['result']['responseCode']
            );
        }

    }



    /**
     * @param $userId
     * @param $withdrawAmount
     * @param $currency
     * @param $gameTransactionRef
     * @param null $gameTransactionUniqueRef
     * @param null $gameId
     * @param null $additional_data
     * @return array
     *          SuccessResponse [ code=200,message='',data={},external_success_code='' ]
     *          SuccessData Structure [
     *                  casinoTransactionId =>''
     *          ]
     *          FailResponse [code = -1, error_code="", error_message="",external_error_code]
     *          FailResponse Possible ErrorCodes = [
     *              GISErrorCodes::TRANSACTION_ALREADY_EXISTS,
     *              GISErrorCodes::NOT_SUFFICIENT_FUNDS,
     *              GISErrorCodes::OPERATION_FAILED,
     *
     *          ]
     */
    public function withdraw($userId, $withdrawAmount, $currency, $gameTransactionRef, $gameTransactionUniqueRef = null, $userIP = null, $gameId = null, $additional_data = null)
    {


        //This blueprint is returned always from this method as response in case of success
        $returnDataBluePrint = [
            'casinoTransactionId' => null,
            'balance' => null,
            'userId' => $userId
        ];


        //Casino Core Call Parameters
        $parameters = [
            'providerID'=>self::$provider_id,
            'userID' => $userId,
            'currencyID' => array_search($currency, Config::CURRENCY_MAPPING),
            'amount' => $withdrawAmount,
            'shouldWaitForApproval' => false,
            'providerUserID' => null,
            'providerOppCode' => $gameTransactionRef,
            'additionalData' => $additional_data,
            'requesterIP' => $userIP,
        ];


        //Request Deposit
        $withdrawResponse = $this->call(Config::CASINO_CORE_TRANSACTIONS_WSDL(), 'withdrawMoney', $parameters);

        //If Response Was Wron or generic error, we wait 3 seconds and try to get transaction status
        if(!$withdrawResponse || !isset($withdrawResponse['result']) || $withdrawResponse['result']['responseCode'] == ErrorCodes::GENERIC_FAILED_ERROR) {


            //TODO Log Properly

            //Wait 3 seconds
            sleep(3);


            //Check Status And Response Properly
            $transactionStatusResponse = $this->checkTransactionStatus($gameTransactionRef);

            //TODO Log response after 3 seconds wait


            //If Transaction was procesed successfully
            if($transactionStatusResponse['code'] == GISErrorCodes::SUCCESS) {

                //Send SuccessData Back
                return $this->respondSuccess(
                    [
                        'casinoTransactionId'=>$transactionStatusResponse['data']['casinoTransactionId']
                    ],
                    'Transaction was processed successfully - Response failed but check in 3 seconds',
                    $transactionStatusResponse['external_success_code']
                );

            }

            //If After Transaction check status we got failed response
            else {

                //TODO LOG Properly
                return $this->respondError(
                    GISErrorCodes::OPERATION_FAILED,
                    'Transaction operation failed',
                    $transactionStatusResponse['error_code']
                );
            }



        }

        //If Withdraw Was processed succesfully
        else if($withdrawResponse['result']['responseCode'] == ErrorCodes::STATUS_SUCCESS) {

            //Send SuccessData Back
            return $this->respondSuccess(
                [
                    'casinoTransactionId'=>$withdrawResponse['result']['transactionID']
                ],//Success Data
                'Transaction was processed successfully',//SuccessMessage
                $withdrawResponse['result']['responseCode']//External System Success code
            );
        }

        //Doesn't have enought balance to make withdraw
        else if($withdrawResponse['result']['responseCode'] == ErrorCodes::INSUFFICIENT_FUNDS) {

            //Not enough balance tp make bet or withdraw money
            //TODO Log Properly
            return $this->respondError(
                GISErrorCodes::NOT_SUFFICIENT_FUNDS,
                'Transaction with provided Id already exists',
                $withdrawResponse['result']['responseCode']
            );

        }


        //This Withdraw Transaction already exists
        else if($withdrawResponse['result']['responseCode'] == ErrorCodes::DUPLICATED_PROVIDERS_TRANSACTIONID) {

            //TODO Log Properly
            return $this->respondError(
                GISErrorCodes::TRANSACTION_ALREADY_EXISTS,
                'Transaction with provided Id already exists',
                $withdrawResponse['result']['responseCode']
            );
        }


        //Transaction was declined
        else {
            //TODO Log Properly
            return $this->respondError(
                GISErrorCodes::OPERATION_FAILED,
                'Transaction operation failed',
                $withdrawResponse['result']['responseCode']
            );
        }


    }


    /**
     * @param $transactionId
     * @param null $transactionId
     * @param bool $isCasinoTransaction
     * @param null $statusNote
     * @param null $userId
     * @param null $gameId
     * @return array -
     *          SuccessResponse [ code=200,message='',data={},external_success_code ]
     *          SuccessData Structure []
     *          FailResponse [code = -1, error_code=501, error_message="",external_error_code]
     *          FailResponse Possible ErrorCodes = [
     *              GISErrorCodes::NOT_SUFFICIENT_FUNDS,
     *              GISErrorCodes::CANT_ROLLBACK_TRANSACTION,
     *          ]
     */
    public function rollback($transactionId, $isCasinoTransaction = false, $statusNote = null, $userId = null, $gameId = null)
    {
        //TODO Enable proper Logging

        if (!$statusNote) {
            $statusNote = "Transaction Was rolledback: Provder=" . self::$provider_id;
        }


        $parameters = [
            'providerID'=>self::$provider_id,
            "transactionID" => $transactionId,
            "isCoreTransactionID" => $isCasinoTransaction,
            'statusNote'=>$statusNote
        ];

        $rollbackResponse = $this->call(Config::CASINO_CORE_TRANSACTIONS_WSDL(), 'rollbackTransaction', $parameters);

        //If Rollback Message Was not received at all
        if(!$rollbackResponse || !isset($rollbackResponse['result'])) {
            //TODO Log Error
            return $this->respondError(GISErrorCodes::CANT_ROLLBACK_TRANSACTION, 'Rollback Was not successful');
        }

        //If Rollback Was Processed Successfully
        //156 = TRANSACTION_NOT_FOUND
        //157 = TRANSACTION_STATUS_SUCCESS
        //158 = TRANSACTION_STATUS_ROLLBACK
        if (in_array($rollbackResponse['result'], [ErrorCodes::STATUS_SUCCESS, ErrorCodes::TRANSACTION_NOT_FOUND, ErrorCodes::TRANSACTION_STATUS_SUCCESS, ErrorCodes::TRANSACTION_STATUS_ROLLBACK])) {

            if($rollbackResponse['result'] == ErrorCodes::TRANSACTION_NOT_FOUND) {
                return $this->respondSuccess([], 'Success, Transaction Not Found With Provided ID', $rollbackResponse['result']);
            }
            else {
                return $this->respondSuccess([], 'Rollback Was Successful', $rollbackResponse['result']);
            }



        }

        //Rollback Was Not Successful Fro Insufficient Funds
        else if ($rollbackResponse['result'] == ErrorCodes::INSUFFICIENT_FUNDS) {
            return $this->respondError(GISErrorCodes::NOT_SUFFICIENT_FUNDS, 'User doesnt have enought money to rollback transaction', $rollbackResponse['result']);
        }

        else {
            //TODO Log that transaction rollback was not successful
            return $this->respondError(GISErrorCodes::CANT_ROLLBACK_TRANSACTION, 'Rollback Was not successful', $rollbackResponse['result']);
        }

    }



    /**
     * @param $userId
     * @param null $currencyISO3 - ISO3 Code
     * @return array
     *          SuccessResponse [ code=200, message='', data={}, external_success_code ]
     *          SuccessData Structure [
     *              balance=>'',
     *              currency=>''
     *          ]
     *          FailResponse    [ code=-1, error_code=501, error_message="",external_error_code]
     *          FailResponse Possible ErrorCodes = [
     *              GISErrorCodes::CANT_DETERMINE_USER_BALANCE
     *          ]
     */
    public function getBalance($userId, $currencyISO3 = null)
    {

        //Translate From GEL,EUR to IDs, this is required by singular CORE to accept Ids instead of Currency ISO codes
        $currencyId = array_search($currencyISO3, Config::CURRENCY_MAPPING);


        if (!$currencyId) {
            //TODO LOg Properly
            return $this->respondError(GISErrorCodes::CANT_DETERMINE_USER_BALANCE, 'Currency value is wrong: ' . $currencyId);
        }

        //Set Parameters Fro Call
        $parameters = [
            'providerID'=>self::$provider_id,
            'userID' => $userId,
            "currencyID" => $currencyId,
            "isSingle" => false
        ];

        //Call Service And Return Response
        $balanceResponse = $this->call(Config::CASINO_CORE_WEB_SERVICE_WSDL(), "GetBalance", $parameters);


        //Response From Casino Was Not Handled
        if (!isset($balanceResponse['result'])) {
            //TODO LOg Properly
//            Log::warn('Getting Balance response was wrong', ['userId' => $userId, 'currencyId' => $currencyId, 'response' => $balanceResponse]);
            return $this->respondError(GISErrorCodes::CANT_DETERMINE_USER_BALANCE, 'Get Balance Response From Core was wrong');
        }

        //SAVE dATA IN LOCAL VARIABLES
        $result = $balanceResponse['result'];
        $statusCode = $result['statusCode'];

        //Balance Value was responded from Casino
        if ($statusCode == ErrorCodes::STATUS_SUCCESS) {

            $balance = isset($result['amount']) ? $result['amount'] : 0;

            return $this->respondSuccess([
                'balance' => $balance,
                'currency' => $currencyId
            ], 'Balance Get was successful');
        }


        //We didn't get balance from Casino
        else {
            return $this->respondError(GISErrorCodes::CANT_DETERMINE_USER_BALANCE, 'Cant get balance', $statusCode);
        }

    }


    /**
     * @param $userId
     * @param $withdrawAmount
     * @param $depositAmount
     * @param $currency
     * @param $gameTransactionRef
     * @param null $gameTransactionUniqueRef
     * @param null $gameId
     * @param null $additional_data
     * @return array
     *
     */
    public function withdrawAndDeposit($userId, $withdrawAmount, $depositAmount, $currency, $gameTransactionRef, $gameTransactionUniqueRef = null, $userIP = null, $gameId = null, $additional_data = null)
    {
        return [];
    }


    /**
     * @param $gameTransactionRef
     * @param null $gameTransactionUniqueRef
     * @return array =
     *          SuccessResponse [ code=200,message='',data={},external_success_code='' ]
     *          SuccessData Structure [
     *                  casinoTransactionId =>'',
     *                  transactionTime     =>''
     *          ]
     *          FailResponse [code = -1, error_code="", error_message="",external_error_code='']
     *          FailResponse Possible ErrorCodes = [
     *              GISErrorCodes::TRANSACTION_NOT_FOUND,
     *              GISErrorCodes::GENERAL_ERROR,
     *              GISErrorCodes::TRANSACTION_STATUS_REJECTED,
     *              GISErrorCodes::TRANSACTION_STATUS_ROLLBACK
     *          ]
     */
    public function checkTransactionStatus($gameTransactionRef, $gameTransactionUniqueRef = null)
    {

        $parameters = [
            'providerID'=>self::$provider_id,
            'transactionID' => $gameTransactionRef,
            'isCoreTransactionID' => false
        ];


        $checkStatusResponse = $this->call(Config::CASINO_CORE_TRANSACTIONS_WSDL(), 'checkTransactionStatus', $parameters);


        //Todo Log Request And Response as info

        if (!isset($checkStatusResponse['result'])) {
            //TODO Log Error
            return $this->respondError(GISErrorCodes::GENERAL_ERROR, 'We where not able to check transaction Status');
        }

        $result = $checkStatusResponse['result'];
        $responseCode = $result['responseCode'];

        //If Transaction processing was successful return ok
        if ($responseCode == ErrorCodes::STATUS_SUCCESS || $responseCode == ErrorCodes::TRANSACTION_STATUS_SUCCESS || $responseCode == ErrorCodes::TRANSACTION_STATUS_APPROVED) {

            return $this->respondSuccess([
                'casinoTransactionId' => $result['returnValue'],
                'transactionTime' => $result['modificationDate']
            ], 'Transaction was processed successfully', $checkStatusResponse['result']['responseCode']);
        }

        //Send Rejected Status
        else if($responseCode == ErrorCodes::TRANSACTION_STATUS_REJECTED) {
            return $this->respondError(GISErrorCodes::TRANSACTION_STATUS_REJECTED, 'Transaction was rejected', $result['responseCode']);
        }

        //Transaction is rolledback
        else if($responseCode == ErrorCodes::TRANSACTION_STATUS_ROLLBACK) {
            return $this->respondError(GISErrorCodes::TRANSACTION_STATUS_ROLLBACK, 'Transaction is rolled back', $result['responseCode']);
        }


        else if($responseCode == ErrorCodes::TRANSACTION_STATUS_PENDING) {
            //TODO Log Error this should not happen in games integreation
            return $this->respondError(GISErrorCodes::TRANSACTION_STATUS_PENDING, 'Transaction in in pending Mode', $result['responseCode']);
        }

        //TODO Save Log
        return $this->respondError(GISErrorCodes::TRANSACTION_NOT_FOUND, 'Transaction was not found', $result['responseCode']);
    }




    /**
     * Implemented Singular Specific Casino CORE API Calls
     * Using SOAP TO make requests with Singular Casino Core
     *
     * @param $wsdl
     * @param $method - Soap Method that should be invoked on Casino Side
     * @param $parameters
     * @return array|bool
     */
    private function call($wsdl, $method, $parameters)
    {

        //TODO PROPERLY Log This Method

        try {
            ini_set("soap.wsdl_cache_enabled", "0");

            //Add Provider Id In Request

            //Calculate And Add Hash In Request Params
            $hash = $this->getHash($parameters);
            $parameters['hash'] = $hash;



            //Create Soap Client
            $client = new \SoapClient($wsdl);


            //Call Soap Service And Return Response
            $ret = $client->$method($parameters);
//            print_r($ret);

        } catch (\Exception $e) {
            //TODO Log Properly

            return false;
        }

        if (is_object($ret)) {
            return $array = json_decode(json_encode($ret), true);
        }





        return $ret;
    }



    /**
     * @param $parameters
     * @return string
     */
    private function getHash($parameters)
    {

        $str = '';
        foreach ($parameters as $key => $value) {
            if ($key == "isVerified" || $key == "isSingle" || $key == "isActive" || $key == "isInvite" || $key == "transactionIsCash" || $key == "isCardVerification" || $key == "isCoreTransactionID" || $key == "useProviderID" || $key == "shouldWaitForApproval")
                $str .= (int)$parameters[$key] == 1 ? "true" : "false";
            else
                $str .= $parameters[$key];
        }
        $str .= self::$secret;


//        echo "\nH:".$str;
        return md5($str);
    }


}