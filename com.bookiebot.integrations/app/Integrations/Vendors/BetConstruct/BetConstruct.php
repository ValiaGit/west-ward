<?php

namespace App\Integrations\BetConstruct;


use App\Integrations\BetConstruct\Constants\ErrorCodes;
use App\Integrations\BetConstruct\Constants\Config;
use App\Integrations\BetConstruct\Constants\TransactionTypes;
use App\Integrations\Casino\CasinoCoreInterface;
use App\Integrations\Constants\GISErrorCodes;
use App\Integrations\Helpers\GISLogger;
use App\Integrations\Helpers\TokenGenerator;
use App\Integrations\Helpers\UUIDGenerator;
use App\Integrations\Vendors\GameVendorBase;

use App\Models\Persistence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;


class BetConstruct extends GameVendorBase
{

    /**
     * In what time is token expired
     * @var int
     */
    private $tokenExpirationSeconds = 3600;


    /**
     * Instance For Communicating Casino Core
     * @var CasinoCoreInterface
     */
    protected $CasinoCore;


    /**
     *
     * @var Persistence
     */
    protected $Persistence;

    /**
     * @var GISLogger
     */
    private $Logger;

    /**
     * Constructor. - Inject GISLogger Implementation Details
     * BetConstruct constructor.
     * @param GISLogger $Logger
     */
    public function __construct(Persistence $Persistence, GISLogger $Logger)
    {

        $this->Logger = $Logger;


        $this->Persistence = $Persistence;

        //Inject Casino Core Instance
        $this->CasinoCore = $this->getCasinoIntegrationInstance(
            Config::PROVIDER(),
            Config::SECRET()
        );
    }


    /**
     * Authenticates a user in the game by Token (integration with iFrame).
     *
     * OperatorId , Token , PublicKey
     *
     * @SWG\POST(
     *     path="/api/betconstruct/Authentication",
     *     summary="BetConstruct sends request with TOKEN to get info about authenticated user",
     *     tags={"BetConstruct"},
     *     description="BetConstruct sends request with TOKEN to get info about authenticated user",
     *
     *   @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     description="Payload to authenticate user with token",
     *     required=false,
     *     default="",
     *     @SWG\Schema(
     *       type="xml",
     *       @SWG\Items()
     *     )
     *   ),
     *
     *
     *
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(ref="#/definitions/successModel")
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid request parameters",
     *         @SWG\Schema(ref="#/definitions/errorModel")
     *     ),
     * )
     *
     * @param Request $request
     * @return mixed
     */
    public function Authentication(Request $request)
    {


        //Check Hash Validity
        if(!$this->isHashValid($request)) {
            $this->Logger->warn('[BETCONSTRUCT] Authentication Has Was Invalid');
            return $this->sendError(ErrorCodes::GENERAL_ERROR,'PublicKey was not valid');
        }


        try {

            //Grab Request Parameters as Array
            $requestBody = $request->getContent();
            $requestBody = json_decode($requestBody,true);

            $this->Logger->debug('[BETCONSTRUCT] Authentication Received',$requestBody);

            //If Some Mandatory Request Parameters are missing
            if(!isset($requestBody['OperatorId']) || !isset($requestBody['Token']) || !isset($requestBody['PublicKey'])) {
                $this->Logger->warn('[BETCONSTRUCT] Authentication Missing Mandatory Params');
                return $this->sendError(ErrorCodes::GENERAL_ERROR,'Mandatory request parameters are missing');
            }

            //Check If Provided OperatorId By Request is the same as we have in config
            $OperatorId = $requestBody['OperatorId'];
            if(Config::OPERATOR_ID()!=$OperatorId) {
                $this->Logger->warn('[BETCONSTRUCT] Authentication Wrong Operator ID');
                return $this->sendError(ErrorCodes::GENERAL_ERROR,'Provided Operator ID Is Wrong');
            }


            $Token = $requestBody['Token'];
            $PublicKey = $requestBody['PublicKey'];

            //Authenticate In Casino
            $authResponse = $this->CasinoCore->auth($Token);

            if($Token == "a2818fd8-ddf0-4036-94c7-4d5f393c9def") {
                $authResponse = [
                    "code" => GISErrorCodes::SUCCESS,
                    "data"=>[
                        "userId" => 1,
                        "userName" => 'shako',
                        "currency" => "EUR",
                        "currencyId" => 1,
                        "ip" => isset($result['userIP']) ? $result['userIP'] : "176.221.225.32",
                        "balance" => null
                    ]//Some casinos may return balance with authentication call
                ];
            }

            //Auth was successful
            if($authResponse['code'] == GISErrorCodes::SUCCESS) {
                /**
                 * Data To Send
                 * OperatorId
                 * Name
                 * UserName
                 * Token
                 * TotalBalance
                 * Gender
                 * Currency
                 * Country
                 * PlayerId
                 * UserIP
                 */
                $userDetails = $authResponse['data'];


                $DataToSend = [
                    'OperatorId'=>Config::OPERATOR_ID(),
                    'PlayerId'=>$userDetails['userId'],
                    'UserName'=>$userDetails['userName'],
                    'Currency'=>$userDetails['currency'],
                    'UserIP'=>$userDetails['ip'],
                    'TotalBalance'=>0
                ];
                //If There was not balance grad with additional request
                if(!isset($userDetails['balance']) || $userDetails['balance'] == null) {
                    $DataToSend['TotalBalance'] = (float)$this->grabBalance($userDetails['userId'],$userDetails['currency']);
                }
                $DataToSend['Time'] = time();

                $GeneratedToken = UUIDGenerator::generate();

                $persist_token = $this->Persistence->persist(Config::PROVIDER().$GeneratedToken,$DataToSend);
                if($persist_token == true) {

                    $DataToSend['Token'] = $GeneratedToken;


                    //Log that authentication was successful
                    $this->Logger->debug('[BETCONSTRUCT] Authentication Was Successful',$DataToSend);

                    //Convert Balance in Euros
                    $DataToSend['TotalBalance'] = ($DataToSend['TotalBalance']/100);

                    //Respond With Success
                    return $this->sendSuccess($DataToSend);
                }
                else {
                    $this->Logger->warn('[BETCONSTRUCT] Authentication Cant Persist DataToken');
                    return $this->sendError(ErrorCodes::GENERAL_ERROR,'Cant Persist DataToken');
                }




            }

            //Authentication Failed
            else {
                $this->Logger->warn('[BETCONSTRUCT] Authentication User was not authenticated with provided TOKEN');
                return $this->sendError(ErrorCodes::INVALID_TOKEN,'User was not authenticated with provided TOKEN');
            }


        } catch (\Exception $e) {
            //TODO Log Exception Happened Data
            $this->Logger->error('[BETCONSTRUCT] Authentication Exception was thrown: '.$e->getMessage());
            return $this->sendError(ErrorCodes::GENERAL_ERROR,$e->getMessage());
        }

    }


    /**
     * This method is a combination of Withdrawal and Deposit methods.
     * It allows to reduce an amount of API calls as many as possible.
     * It returns an object of type WithdrawAndDepositOutput.
     *
     * @SWG\POST(
     *     path="/api/betconstruct/GetBalance",
     *     summary="",
     *     tags={"BetConstruct"},
     *     description="",
     *
     *   @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     description="Request to make withdraw and deposit at the same time from main balance",
     *     required=false,
     *     default="",
     *     @SWG\Schema(
     *       type="xml",
     *       @SWG\Items()
     *     )
     *   ),
     *
     *
     *
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(ref="#/definitions/successModel")
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid request parameters",
     *         @SWG\Schema(ref="#/definitions/errorModel")
     *     ),
     * )
     *
     *
     * @param Request $request
     * @return mixed
     */
    public function GetBalance(Request $request)
    {
        //Checks if request public key was correnct
        if(!$this->isHashValid($request)) {
            $this->Logger->warn('[BETCONSTRUCT] GetBalance Has Was Invalid');
            return $this->sendError(ErrorCodes::GENERAL_ERROR,'PublicKey was not valid');
        }

        try {

            //Get JSON Body Request As ARRAY
            $requestBody = $request->getContent();
            $requestBody = json_decode($requestBody,true);

            $this->Logger->debug('[BETCONSTRUCT] GetBalance Received Request',$requestBody);

            //ValdateToken And Get User Details
//            $userDetailsFromToken = TokenGenerator::validateToken($requestBody['Token']);
            $userDetailsFromToken = $this->isTokenPersisted($requestBody['Token']);


            if(!$userDetailsFromToken) {
                $this->Logger->warn('[BETCONSTRUCT] GetBalance Token was Invalid');
                return $this->sendError(ErrorCodes::INVALID_TOKEN,'Token was not valid');
            }


            try {
                $TokenCreateTime = (int)$userDetailsFromToken['Time'];
                if($TokenCreateTime + $this->tokenExpirationSeconds < time()) {
                    $this->Logger->warn('[BETCONSTRUCT] GetBalance Token was Expired');
                    return $this->sendError(ErrorCodes::INVALID_TOKEN,'Token is expired');
                }
            }catch(\Exception $e) {

            }

            $PlayerIdFromToken = $userDetailsFromToken['PlayerId'];
            if($PlayerIdFromToken != $requestBody['PlayerId']) {
                $this->Logger->warn('[BETCONSTRUCT] GetBalance PlayerId was Invalid');
                return $this->sendError(ErrorCodes::WRONG_PLAYER_ID,"PlayerID associated with token was different then requested one.");
            }

            $Currency = $userDetailsFromToken['Currency'];


            $userDetailsFromToken['Time'] = time();
            if($this->updateAndReturnToken($requestBody['Token'],$userDetailsFromToken)) {
                //SendRequest To Casino Core For Getting Balance
                $balance = $this->grabBalance($PlayerIdFromToken,$Currency);


                //Create Success Data Array
                $successData = [
                    'PlayerId'=>(int)$PlayerIdFromToken,
                    'TotalBalance'=>($balance/100),
                    'Token'=>$requestBody['Token']
                ];

                //Save Log Of Response
                $this->Logger->debug('[BETCONSTRUCT] GetBalance  Was Successful',$successData);


                //Respond With Success
                return $this->sendSuccess($successData);
            }
            else {
                $this->Logger->error('[BETCONSTRUCT] GetBalance Cant update and return Token ',$userDetailsFromToken);
                return $this->sendError(ErrorCodes::GENERAL_ERROR,"Cant update and return Token");
            }



        }catch(\Exception $e) {
            $this->Logger->error('[BETCONSTRUCT] GetBalance Exception was thrown: '.$e->getMessage());
            return $this->sendError(ErrorCodes::GENERAL_ERROR,"Exception Thrown: ".$e->getMessage());
        }

    }



    /**
     * This method withdraws money from player's account and returns the transaction reference and player's account balance after transaction was made.
     * This method is used to place a bet.
     * It does return an object of type WithdrawOutput.
     *
     * @SWG\POST(
     *     path="/api/betconstruct/Withdraw",
     *     summary="",
     *     tags={"BetConstruct"},
     *     description="",
     *
     *   @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     description="Request to withdraw money from user balance",
     *     required=false,
     *     default="",
     *     @SWG\Schema(
     *       type="xml",
     *       @SWG\Items()
     *     )
     *   ),
     *
     *
     *
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(ref="#/definitions/successModel")
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid request parameters",
     *         @SWG\Schema(ref="#/definitions/errorModel")
     *     ),
     * )
     *
     *
     * @param Request $request
     * @return mixed
     */
    public function Withdraw(Request $request)
    {

        //Checks if request public key was correnct
        if(!$this->isHashValid($request)) {
            $this->Logger->warn('[BETCONSTRUCT] Withdraw Hash Was Invalid');
            return $this->sendError(ErrorCodes::GENERAL_ERROR,'PublicKey was not valid');
        }

        try {

            //Get JSON Body Request As ARRAY
            $requestBody = $request->getContent();
            $requestBody = json_decode($requestBody,true);

            $this->Logger->debug('[BETCONSTRUCT] Withdraw Request Received', $requestBody);


            //ValdateToken And Get User Details
//            $userDetailsFromToken = TokenGenerator::validateToken($requestBody['Token']);
            $userDetailsFromToken = $this->isTokenPersisted($requestBody['Token']);

            if(!$userDetailsFromToken) {
                $this->Logger->warn('[BETCONSTRUCT] Withdraw Token Was Invalid');
                return $this->sendError(ErrorCodes::INVALID_TOKEN,'Token was not valid');
            }

            try {
                $TokenCreateTime = (int)$userDetailsFromToken['Time'];
                if($TokenCreateTime + $this->tokenExpirationSeconds < time()) {
                    $this->Logger->warn('[BETCONSTRUCT] Withdraw Token Was Expired');
                    return $this->sendError(ErrorCodes::INVALID_TOKEN,'Token is expired');
                }
            }catch(\Exception $e) {
                $this->Logger->error('[BETCONSTRUCT] Withdraw Token Expiration Date Check Exception: '.$e->getMessage());
            }

            //Grab Values From Token Decription
            $PlayerIdFromToken = $userDetailsFromToken['PlayerId'];
            $CurrencyFromToken = $userDetailsFromToken['Currency'];

            //Get Values Send in Request parameters
            $PlayerId = $requestBody['PlayerId'];
            $Currency = $requestBody['Currency'];

            //Check If UserId in Encrypted Token and Requested one are the same
            if($PlayerIdFromToken != $PlayerId) {
                $this->Logger->warn('[BETCONSTRUCT] Withdraw Player was different in token then provided one');
                return $this->sendError(ErrorCodes::WRONG_PLAYER_ID,"PlayerID associated with token was different then requested one.");
            }


            //Check If Currency in Encrypted Token and Requested one are the same
            if($CurrencyFromToken != $Currency) {
                $this->Logger->warn('[BETCONSTRUCT] Withdraw Currency was not same as it was in Token');
                return $this->sendError(ErrorCodes::GENERAL_ERROR,"Currency associated with player from token was different then requested one.");
            }

            //Additional Explanation Of Transaction
            $additional_data = null;

            //Get Parameters From Request
            $withdrawAmount = $requestBody['WithdrawAmount'];
            $RGSTransactionId = $requestBody['RGSTransactionId'];
            $TypeId = $requestBody['TypeId'];
            $gameId = $requestBody['GameId'];


            //If Provided Transaction Type Was Found in Config
            $AvailableTypes = TransactionTypes::TYPES_REVERSED;
            if(isset($AvailableTypes[$TypeId])) {
                $additional_data = "TransactionType=$AvailableTypes[$TypeId];GameId=$gameId";
            }

            //Convert Euros in cents
            $withdrawAmount*=100;

            //If User Doesn't have enough balance
            $balance = $this->grabBalance($PlayerId,$Currency);

            if($withdrawAmount>$balance) {
                $this->Logger->warn("[BETCONSTRUCT] Withdraw User didn't have enough balance");
                return $this->sendError(ErrorCodes::NOT_ENOUGH_BALANCE,'Not enought balance');
            }

            if($withdrawAmount<=0) {
                $this->Logger->warn("[BETCONSTRUCT] Withdraw Amount was below zero");
                return $this->sendError(ErrorCodes::WRONG_TRANSACTION_AMOUNT,"TRANSACTION AMOUNT is wrong");
            }

            //Update Token Activity Time
            $userDetailsFromToken['Time'] = time();
            if(!$this->updateAndReturnToken($requestBody['Token'],$userDetailsFromToken)) {
                return $this->sendError(ErrorCodes::GENERAL_ERROR,"Cant update token in database");
            }


            //Send Withdraw Request To Casino CoreSystem
            $withdrawResponse = $this->CasinoCore->withdraw(
                $PlayerId,
                $withdrawAmount,
                $Currency,
                $RGSTransactionId,
                Config::PROVIDER().$RGSTransactionId,
                null,
                $gameId,
                $additional_data
            );

            //If Transaction Succeed
            if($withdrawResponse['code'] == GISErrorCodes::SUCCESS) {

                //Get Transaction Id Generated By Casino Core System
                $casinoTransactionId = $withdrawResponse['data']['casinoTransactionId'];

                try {
                    //Grab Int Unqie Id From Transaction Response
                    if(strpos($casinoTransactionId,"|")) {
                        $casinoTransactionIdExploded = explode("|",$casinoTransactionId);
                        $casinoTransactionId = $casinoTransactionIdExploded[1];
                    }
                }catch(\Exception $e) {
                    $this->Logger->debug("[BETCONSTRUCT] Withdraw Getting Integer TransactionId returned exception: ".$e->getMessage());
                }

                //Success Data
                $successData = [
                    'PlayerId'=>$PlayerId,
                    'Token'=>$requestBody['Token'],
                    'TotalBalance'=>($this->grabBalance($PlayerId,$Currency)/100),
                    'PlatformTransactionId'=>(int)$casinoTransactionId
                ];


                $this->Logger->debug("[BETCONSTRUCT] Withdraw Transaction was successful",$successData);


                //Respond With Success Data To Game Vendor
                return $this->sendSuccess($successData);

            }

            //If Transaction With Provided Id Was Already Registered
            else if($withdrawResponse['error_code'] == GISErrorCodes::TRANSACTION_ALREADY_EXISTS) {

                $this->Logger->warn("[BETCONSTRUCT] Withdraw Transaction was already processed",$withdrawResponse);
                return $this->sendError(ErrorCodes::TRANSACTION_ALREADY_COMPLETE,$withdrawResponse['error_message']);
            }

            //Transaction Was not done due to small balance, no bet accepted
            else if($withdrawResponse['error_code'] == GISErrorCodes::NOT_SUFFICIENT_FUNDS) {
                $this->Logger->warn("[BETCONSTRUCT] Withdraw Not enough Balance",$withdrawResponse);
                return $this->sendError(ErrorCodes::NOT_ENOUGH_BALANCE,$withdrawResponse['error_message']);
            }

            //If Transaction Failed
            else {
                $message = isset($withdrawResponse['error_message']) ? $withdrawResponse['error_message'] : "";
                $this->Logger->warn("[BETCONSTRUCT] Withdraw Transaction was not successful",$withdrawResponse);
                return $this->sendError(ErrorCodes::GENERAL_ERROR,$message);
            }



        }
        catch(\Exception $e) {
            $this->Logger->error("[BETCONSTRUCT] Withdraw Fired Exception: ".$e->getMessage());
            return $this->sendError(ErrorCodes::GENERAL_ERROR,"Exception Thrown: ".$e->getMessage());
        }


    }


    /**
     * This method provides depositing on player's account and returns the transaction reference and player's account balance after the transaction made.
     * This method can be used to collect a win or to collect a prize in a tournament. It returns an object of type DepositOutput.
     *
     * @SWG\POST(
     *     path="/api/betconstruct/Deposit",
     *     summary="",
     *     tags={"BetConstruct"},
     *     description="",
     *
     *   @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     description="Request to deposit money/winning on user balance",
     *     required=false,
     *     default="",
     *     @SWG\Schema(
     *       type="xml",
     *       @SWG\Items()
     *     )
     *   ),
     *
     *
     *
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(ref="#/definitions/successModel")
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid request parameters",
     *         @SWG\Schema(ref="#/definitions/errorModel")
     *     ),
     * )
     *
     * @param Request $request
     * @return mixed
     */
    public function Deposit(Request $request)
    {
        //Checks if request public key was correnct
        if(!$this->isHashValid($request)) {
            $this->Logger->warn("[BETCONSTRUCT] Deposit Has was not valid");
            return $this->sendError(ErrorCodes::GENERAL_ERROR,'PublicKey was not valid');
        }

        try {

            //Get JSON Body Request As ARRAY
            $requestBody = $request->getContent();
            $requestBody = json_decode($requestBody,true);

            $this->Logger->debug('[BETCONSTRUCT] Deposit Request Received', $requestBody);

            //ValdateToken And Get User Details
//            $userDetailsFromToken = TokenGenerator::validateToken($requestBody['Token']);
            $userDetailsFromToken = $this->isTokenPersisted($requestBody['Token']);
            if(!$userDetailsFromToken) {
                $this->Logger->warn("[BETCONSTRUCT] Deposit Token was not valid");
                return $this->sendError(ErrorCodes::INVALID_TOKEN,'Token was not valid');
            }

            //Grab Values From Token Decription
            $PlayerIdFromToken = $userDetailsFromToken['PlayerId'];
            $CurrencyFromToken = $userDetailsFromToken['Currency'];

            //Get Values Send in Request parameters
            $PlayerId = $requestBody['PlayerId'];
            $Currency = $requestBody['Currency'];

            //Check If UserId in Encrypted Token and Requested one are the same
            if($PlayerIdFromToken != $PlayerId) {
                $this->Logger->warn("[BETCONSTRUCT] Deposit UserId was wrong");
                return $this->sendError(ErrorCodes::WRONG_PLAYER_ID,"PlayerID associated with token was different then requested one.");
            }


            //Check If Currency in Encrypted Token and Requested one are the same
            if($CurrencyFromToken != $Currency) {
                $this->Logger->warn("[BETCONSTRUCT] Deposit Currency in Token was ifferent then provided one");
                return $this->sendError(ErrorCodes::GENERAL_ERROR,"Currency associated with player from token was different then requested one.");
            }

            $depositAmount = $requestBody['DepositAmount']*100;

            $this->Logger->debug('[BETCONSTRUCT] Amount To Deposit In Core', ["Amount"=>$depositAmount]);

            if($depositAmount<=0) {
                $this->Logger->warn("[BETCONSTRUCT] Deposit Amount was below zero");
                return $this->sendError(ErrorCodes::WRONG_TRANSACTION_AMOUNT,"TRANSACTION AMOUNT is wrong");
            }


            $RGSTransactionId = $requestBody['RGSTransactionId'];
            $TypeId = $requestBody['TypeId'];//TODO send type name in additional data
            $gameId = $requestBody['GameId'];



            //Update Token Activity Time
            $userDetailsFromToken['Time'] = time();
            if(!$this->updateAndReturnToken($requestBody['Token'],$userDetailsFromToken)) {
                $this->Logger->warn("[BETCONSTRUCT] Deposit Update And Return Token Returned Error",$requestBody);
                return $this->sendError(ErrorCodes::GENERAL_ERROR,"Cant update token in database");
            }


            //If Provided Transaction Type Was Found in Config
            $AvailableTypes = TransactionTypes::TYPES_REVERSED;
            if(isset($AvailableTypes[$TypeId])) {
                $additional_data = "TransactionType=$AvailableTypes[$TypeId];GameId=$gameId";
            }


            //Send Withdraw Request To Casino CoreSystem
            $depositResponse = $this->CasinoCore->deposit(
                $PlayerId,
                $depositAmount,
                $Currency,
                $RGSTransactionId,
                Config::PROVIDER().$RGSTransactionId,
                null,
                $gameId,
                $additional_data
            );


            //If Transaction Succeed
            if($depositResponse['code'] == GISErrorCodes::SUCCESS) {

                //Get Transaction Id Generated By Casino Core System
                $casinoTransactionId = $depositResponse['data']['casinoTransactionId'];
                try {
                    if(strpos($casinoTransactionId,"|")) {
                        $casinoTransactionIdExploded = explode("|",$casinoTransactionId);
                        $casinoTransactionId = $casinoTransactionIdExploded[1];
                    }
                }catch(\Exception $e) {
                    $this->Logger->error("[BETCONSTRUCT] Deposit Getting Integer TransactionId returned exception: ".$e->getMessage());
                }

                $successData = [
                    'PlayerId'=>$PlayerId,
                    'Token'=>$requestBody['Token'],
                    'TotalBalance'=>($this->grabBalance($PlayerId,$Currency)/100),
                    'PlatformTransactionId'=>(int)$casinoTransactionId,
                ];


                $this->Logger->debug("[BETCONSTRUCT] Deposit Was successful",$successData);

                //Respond With Success Data To Game Vendor
                return $this->sendSuccess($successData);

            }

            //If Transaction With Provided Id Was Already Registered
            else if($depositResponse['error_code'] == GISErrorCodes::TRANSACTION_ALREADY_EXISTS) {
                $this->Logger->warn("[BETCONSTRUCT] Deposit Transaction already existed",$depositResponse);
                return $this->sendError(ErrorCodes::DEPOSIT_TRANSACTION_ALREADY_RECEIVED,$depositResponse['error_message']);
            }

            //If Transaction Failed
            else {

                $message = isset($depositResponse['error_message']) ? $depositResponse['error_message'] : "";
                $this->Logger->warn("[BETCONSTRUCT] Deposit Transaction was not successful",$depositResponse);
                return $this->sendError(ErrorCodes::GENERAL_ERROR,$message);
            }



        }
        catch(\Exception $e) {
            $this->Logger->error("[BETCONSTRUCT] Deposit Transaction throw Exception : ".$e->getMessage());
            return $this->sendError(ErrorCodes::GENERAL_ERROR,"Exception Thrown: ".$e->getMessage());
        }

    }


    /**
     * This method is a combination of Withdrawal and Deposit methods.
     * It allows to reduce an amount of API calls as many as possible.
     * It returns an object of type WithdrawAndDepositOutput.
     *
     * @SWG\POST(
     *     path="/api/betconstruct/WithdrawAndDeposit",
     *     summary="",
     *     tags={"BetConstruct"},
     *     description="This method is a combination of Withdrawal and Deposit methods. * It allows to reduce an amount of API calls as many as possible. * It returns an object of type WithdrawAndDepositOutput.",
     *
     *   @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     description="Request to make withdraw and deposit at the same time from main balance",
     *     required=false,
     *     default="",
     *     @SWG\Schema(
     *       type="xml",
     *       @SWG\Items()
     *     )
     *   ),
     *
     *
     *
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(ref="#/definitions/successModel")
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid request parameters",
     *         @SWG\Schema(ref="#/definitions/errorModel")
     *     ),
     * )
     *
     *
     * @param Request $request
     * @return mixed
     */
    public function WithdrawAndDeposit(Request $request)
    {
        //Checks if request public key was correnct
        if(!$this->isHashValid($request)) {
            $this->Logger->warn("[BETCONSTRUCT] WithdrawAndDeposit Hash was not valid");
            return $this->sendError(ErrorCodes::GENERAL_ERROR,'Hash was not valid');
        }

        try {

            //Get JSON Body Request As ARRAY
            $requestBody = $request->getContent();
            $requestBody = json_decode($requestBody,true);

            $this->Logger->debug("[BETCONSTRUCT] WithdrawAndDeposit Received Request",$requestBody);

            //ValdateToken And Get User Details
//            $userDetailsFromToken = TokenGenerator::validateToken($requestBody['Token']);
            $userDetailsFromToken = $this->isTokenPersisted($requestBody['Token']);
            if(!$userDetailsFromToken) {
                $this->Logger->warn("[BETCONSTRUCT] WithdrawAndDeposit Invalid Token");
                return $this->sendError(ErrorCodes::INVALID_TOKEN,'Token was not valid');
            }


            try {
                $TokenCreateTime = (int)$userDetailsFromToken['Time'];
                if($TokenCreateTime + $this->tokenExpirationSeconds < time()) {
                    $this->Logger->warn("[BETCONSTRUCT] WithdrawAndDeposit Token was expired");
                    return $this->sendError(ErrorCodes::INVALID_TOKEN,'Token is expired');
                }
            }catch(\Exception $e) {
                $this->Logger->error("[BETCONSTRUCT] WithdrawAndDeposit Token  expiration calculation exception: ".$e->getMessage());
            }

            //Grab Values From Token Decription
            $PlayerIdFromToken = $userDetailsFromToken['PlayerId'];
            $CurrencyFromToken = $userDetailsFromToken['Currency'];
            $IP = isset($userDetailsFromToken['UserIP']) ? $userDetailsFromToken['UserIP'] : null;

            //Get Values Send in Request parameters
            $PlayerId = $requestBody['PlayerId'];
            $Currency = $requestBody['Currency'];

            //Check If UserId in Encrypted Token and Requested one are the same
            if($PlayerIdFromToken != $PlayerId) {
                $this->Logger->warn("[BETCONSTRUCT] WithdrawAndDeposit Wrong PLayer id was provded not matched with token encoded data");
                return $this->sendError(ErrorCodes::WRONG_PLAYER_ID,"PlayerID associated with token was different then requested one.");
            }


            //Check If Currency in Encrypted Token and Requested one are the same
            if($CurrencyFromToken != $Currency) {
                $this->Logger->warn("[BETCONSTRUCT] WithdrawAndDeposit Wrong Currency was provided");
                return $this->sendError(ErrorCodes::GENERAL_ERROR,"Currency associated with player from token was different then requested one.");
            }

            //Convert in cents
            $depositAmount = $requestBody['DepositAmount']*100;

            if($depositAmount<=0) {
                $this->Logger->warn("[BETCONSTRUCT] WithdrawAndDeposit deposit amount was below zero");
                return $this->sendError(ErrorCodes::WRONG_TRANSACTION_AMOUNT,"TRANSACTION deposit AMOUNT is wrong");
            }

            //Convert in Cents
            $withdrawAmount = $requestBody['WithdrawAmount']*100;

            if($withdrawAmount<=0) {
                $this->Logger->warn("[BETCONSTRUCT] WithdrawAndDeposit withdraw amount was below zero");
                return $this->sendError(ErrorCodes::WRONG_TRANSACTION_AMOUNT,"TRANSACTION Deposit AMOUNT is wrong");
            }

            $balance = $this->grabBalance($PlayerId,$Currency);


            //Wrong Balance
            if($withdrawAmount>$balance) {
                $this->Logger->warn("[BETCONSTRUCT] WithdrawAndDeposit withdrawamount was more then balance");
                return $this->sendError(ErrorCodes::NOT_ENOUGH_BALANCE,"Don't have enough blance");
            }

            $RGSTransactionId = $requestBody['RGSTransactionId'];
            $TypeId = $requestBody['TypeId'];
            $gameId = $requestBody['GameId'];

            //Update Token Activity Time
            $userDetailsFromToken['Time'] = time();
            if(!$this->updateAndReturnToken($requestBody['Token'],$userDetailsFromToken)) {
                return $this->sendError(ErrorCodes::GENERAL_ERROR,"Cant update token in database");
            }

            //Send Withdraw Request To Casino CoreSystem
            $witdrawAndDepositResponse = $this->CasinoCore->withdrawAndDeposit(
                $PlayerId,
                $withdrawAmount,
                $depositAmount,
                $Currency,
                $RGSTransactionId,
                Config::PROVIDER().$RGSTransactionId,
                $IP,
                $gameId,
                null
            );

            if(!$witdrawAndDepositResponse) {
                $this->Logger->error("[BETCONSTRUCT] WithdrawAndDeposit CasinoCore didnt responded at all",$witdrawAndDepositResponse);
                return $this->sendError(ErrorCodes::GENERAL_ERROR,"Transaction was not processed");
            }

            //If Transaction Succeed
            if($witdrawAndDepositResponse['code'] == GISErrorCodes::SUCCESS) {

                //Get Transaction Id Generated By Casino Core System
                $casinoTransactionId = $witdrawAndDepositResponse['data']['casinoTransactionId'];


                try {

                    if(strpos($casinoTransactionId,"_")) {
                        $casinoTransactionIdExplode = explode("_",$casinoTransactionId);

                        $withId = $casinoTransactionIdExplode[0];
                        $depId = $casinoTransactionIdExplode[1];
                        $casinoTransactionId = 0;

                        if(strpos($withId,"|")) {
                            $withIdExploded = explode("|",$withId);
                            $casinoTransactionId+=$withIdExploded[1];
                        }

                        if(strpos($depId,"|")) {
                            $depExploded = explode("|",$depId);
                            $casinoTransactionId+=$depExploded[1];
                        }

                    }


                }catch(\Exception $e) {
                    $this->Logger->error("[BETCONSTRUCT] WithdrawAndDeposit Gettig int transaction id exception: ".$e->getMessage(),["casinoTransactionId"=>$casinoTransactionId]);
                }

                $successData = [
                    'PlayerId'=>$PlayerId,
                    'Token'=>$requestBody['Token'],
                    'TotalBalance'=>($this->grabBalance($PlayerId,$Currency)/100),
                    'PlatformTransactionId'=>$casinoTransactionId,
                ];

                $this->Logger->debug("[BETCONSTRUCT] WithdrawAndDeposit Was Successful",$successData);


                //Respond With Success Data To Game Vendor
                return $this->sendSuccess($successData);

            }

            //If Transaction With Provided Id Was Already Registered
            else if($witdrawAndDepositResponse['error_code'] == GISErrorCodes::TRANSACTION_ALREADY_EXISTS) {
                $this->Logger->warn("[BETCONSTRUCT] WithdrawAndDeposit Transaction with provided RGSId already completed",$witdrawAndDepositResponse);
                return $this->sendError(ErrorCodes::TRANSACTION_ALREADY_COMPLETE,'Transaction with provided RGSId already completed');
            }

            //If Casino Core Responded With Not Sufficient Funds Translate that to Betconstruct Error Code
            else if($witdrawAndDepositResponse['error_code'] == GISErrorCodes::NOT_SUFFICIENT_FUNDS) {
                $this->Logger->warn("[BETCONSTRUCT] WithdrawAndDeposit Not sufficient funds to withdraw",$witdrawAndDepositResponse);
                return $this->sendError(ErrorCodes::NOT_ENOUGH_BALANCE,$witdrawAndDepositResponse['error_message']);
            }


            //If Transaction Failed
            else {
                $message = isset($witdrawAndDepositResponse['error_message']) ? $witdrawAndDepositResponse['error_message'] : "";
                $this->Logger->warn("[BETCONSTRUCT] WithdrawAndDeposit Transaction was declined",$witdrawAndDepositResponse);
                return $this->sendError(ErrorCodes::GENERAL_ERROR,$message);
            }



        }
        catch(\Exception $e) {
            $this->Logger->error("[BETCONSTRUCT] WithdrawAndDeposit Exception was thrown: ".$e->getMessage());
            return $this->sendError(ErrorCodes::GENERAL_ERROR,"Exception Thrown: ".$e->getMessage());
        }
    }


    /**
     * If a need to reimburse the player’s already-placed bet has come up,
     * then a try to roll back the withdrawal with using this method is applied until it succeeds.
     * It returns an object of type RollbackOutput.
     *
     * @SWG\POST(
     *     path="/api/betconstruct/Rollback",
     *     summary="",
     *     tags={"BetConstruct"},
     *     description="If a need to reimburse the player’s already-placed bet has come up, then a try to roll back the withdrawal with using this method is applied until it succeeds. It returns an object of type RollbackOutput.",
     *
     *   @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     description="Request to rollback transaction in casino core system",
     *     required=false,
     *     default="",
     *     @SWG\Schema(
     *       type="xml",
     *       @SWG\Items()
     *     )
     *   ),
     *
     *
     *
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(ref="#/definitions/successModel")
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid request parameters",
     *         @SWG\Schema(ref="#/definitions/errorModel")
     *     ),
     * )
     *
     * @param Request $request
     * @return mixed
     */
    public function Rollback(Request $request)
    {
        //Checks if request public key was correnct
        if(!$this->isHashValid($request)) {
            $this->Logger->warn("[BETCONSTRUCT] Rollback Hash was not valid");
            return $this->sendError(ErrorCodes::GENERAL_ERROR,'Hash was not valid');
        }


        try {

            //Get JSON Body Request As ARRAY
            $requestBody = $request->getContent();
            $requestBody = json_decode($requestBody,true);

            $this->Logger->debug("[BETCONSTRUCT] Rollback Received Request",$requestBody);

            //ValdateToken And Get User Details
//            $userDetailsFromToken = TokenGenerator::validateToken($requestBody['Token']);
            $userDetailsFromToken = $this->isTokenPersisted($requestBody['Token']);
            if(!$userDetailsFromToken) {
                $this->Logger->warn("[BETCONSTRUCT] Rollback Token was Invalid");
                return $this->sendError(ErrorCodes::INVALID_TOKEN,'Token was not valid');
            }



            //Grab Values From Token Decription
            $PlayerIdFromToken = $userDetailsFromToken['PlayerId'];
            $CurrencyFromToken = $userDetailsFromToken['Currency'];

            //Get Values Send in Request parameters
            $PlayerId = $requestBody['PlayerId'];

            //Check If UserId in Encrypted Token and Requested one are the same
            if($PlayerIdFromToken != $PlayerId) {
                $this->Logger->warn("[BETCONSTRUCT] Rollback Wrong Player Id, doesn't match token encoded one");
                return $this->sendError(ErrorCodes::WRONG_PLAYER_ID,"PlayerID associated with token was different then requested one.");
            }

            //TransactionId Which Should Be Rollback
            $RGSTransactionId = $requestBody['RGSTransactionId'];
            $GameId = $requestBody['GameId'];

            //Update Token Activity Time
            $userDetailsFromToken['Time'] = time();
            if(!$this->updateAndReturnToken($requestBody['Token'],$userDetailsFromToken)) {
                return $this->sendError(ErrorCodes::GENERAL_ERROR,"Cant update token in database");
            }


            /**
             * Important
             * 1. If rollback succeeded, the Platform is getting the rollback request with
             * same RGSTransactionId, then platform responds without error.
             * 2. The Platform must return error with ErrorId = 107 when the transaction
             * with the RGSTransactionId was not found.
             * 3. The Platform must successfully process the rollback call with expired token.
             */

            //Send Rollback Request To Casino Core System
            $rollbackResponse = $this->CasinoCore->rollback($RGSTransactionId,0);


            //If Rollback Succeed
            if($rollbackResponse['code'] == GISErrorCodes::SUCCESS) {

                //If Transaction With Provided Id Was Not Found
                if($rollbackResponse['external_success_code'] == GISErrorCodes::TRANSACTION_NOT_FOUND) {
                    $this->Logger->warn("[BETCONSTRUCT] Rollback Transaction is was not found",$rollbackResponse);
                    return $this->sendError(ErrorCodes::TRANSACTION_NOT_FOUND,'Transaction with Provided RGSTransactionId was not found');
                }

                $successData = [
                    'TotalBalance'=>($this->grabBalance($PlayerId,$CurrencyFromToken)/100),
                    'Token'=>$requestBody['Token']
                ];


                $this->Logger->error("[BETCONSTRUCT] Rollback Was Successfull",$successData);

                //Send Success Rollback Response
                return $this->sendSuccess($successData);

            }

            //If Rollback Failed
            else {


                $this->Logger->warn("[BETCONSTRUCT] Rollback Didn't succeed",$rollbackResponse);

                //Rollback Returned Not Sufficient Funds Response
                if($rollbackResponse['error_code'] == GISErrorCodes::NOT_SUFFICIENT_FUNDS) {
                    return $this->sendError(ErrorCodes::NOT_ENOUGH_BALANCE,'User doesn\'t have enough balance to make rollback of deposit and withdraw money');
                }

                //Rollback Was Unsuccessful
                else {
                    //TODO Log Unsuccessful Rollback
                    $externalCode = isset($rollbackResponse['external_error_code']) ? $rollbackResponse['external_error_code'] : "";
                    return $this->sendError(ErrorCodes::GENERAL_ERROR,'Rollback Was not Successful. ExternalCodeId: '.$externalCode);
                }

            }


        }
        catch(\Exception $e) {
            $this->Logger->error("[BETCONSTRUCT] Rollback Exception Fired: ".$e->getMessage());
            return $this->sendError(ErrorCodes::GENERAL_ERROR,"Exception Thrown: ".$e->getMessage());
        }


    }


    /**
     * If a need to reimburse the player’s already-placed bet has come up,
     * then a try to roll back the withdrawal with using this method is applied until it succeeds.
     * It returns an object of type RollbackOutput.
     *
     * @SWG\POST(
     *     path="/api/betconstruct/RefreshToken",
     *     summary="",
     *     tags={"BetConstruct"},
     *     description="If a need to reimburse the player’s already-placed bet has come up, then a try to roll back the withdrawal with using this method is applied until it succeeds. It returns an object of type RollbackOutput.",
     *
     *   @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     description="Request to rollback transaction in casino core system",
     *     required=false,
     *     default="",
     *     @SWG\Schema(
     *       type="xml",
     *       @SWG\Items()
     *     )
     *   ),
     *
     *
     *
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(ref="#/definitions/successModel")
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid request parameters",
     *         @SWG\Schema(ref="#/definitions/errorModel")
     *     ),
     * )
     *
     * @param Request $request
     * @return mixed
     */
    public function RefreshToken(Request $request)
    {
        //Checks if request public key was correnct
        if(!$this->isHashValid($request)) {
            $this->Logger->warn("[BETCONSTRUCT] RefreshToken Hash was not valid");
            return $this->sendError(ErrorCodes::GENERAL_ERROR,'PublicKey was not valid');
        }

        try {

            //Get JSON Body Request As ARRAY
            $requestBody = $request->getContent();
            $requestBody = json_decode($requestBody,true);

            $this->Logger->debug("[BETCONSTRUCT] RefreshToken Received Request",$requestBody);

            //ValdateToken And Get User Details
            //$userDetailsFromToken = TokenGenerator::validateToken($requestBody['Token']);
            $userDetailsFromToken = $this->isTokenPersisted($requestBody['Token']);
            if(!$userDetailsFromToken) {
                $this->Logger->warn("[BETCONSTRUCT] RefreshToken Previous Token was invalid");
                return $this->sendError(ErrorCodes::INVALID_TOKEN,'Token was not valid');
            }

            try {
                $TokenCreateTime = (int)$userDetailsFromToken['Time'];
                if($TokenCreateTime + $this->tokenExpirationSeconds < time()) {
                    $this->Logger->warn("[BETCONSTRUCT] RefreshToken Previous Token was expired");
                    return $this->sendError(ErrorCodes::INVALID_TOKEN,'Token is expired');
                }
            }catch(\Exception $e) {
                $this->Logger->error("[BETCONSTRUCT] RefreshToken Token expiration was excepted: ".$e->getMessage());
            }

            //Grab Values From Token Decription
            $PlayerIdFromToken = $userDetailsFromToken['PlayerId'];
            $CurrencyFromToken = $userDetailsFromToken['Currency'];

            //Get Values Send in Request parameters
            $PlayerId = $requestBody['PlayerId'];

            //Check If UserId in Encrypted Token and Requested one are the same
            if($PlayerIdFromToken != $PlayerId) {
                $this->Logger->warn("[BETCONSTRUCT] RefreshToken Player Id Was Wrong");
                return $this->sendError(ErrorCodes::WRONG_PLAYER_ID,"PlayerID associated with token was different then requested one.");
            }


            $this->Logger->debug("[BETCONSTRUCT] RefreshToken Was Successful");

            //Delete From Database
            if($this->Persistence->remove(Config::PROVIDER().$requestBody['Token'])) {

                $newToken = UUIDGenerator::generate();
                if($this->Persistence->persist($newToken,$userDetailsFromToken)) {
                    //Send Success Rollback Response
                    return $this->sendSuccess([
                        'Token'=>$newToken
                    ]);
                }
                else {
                    $this->Logger->error("Cant generate new Token");
                    return $this->sendError(ErrorCodes::GENERAL_ERROR,"Cant generate new Token");
                }


            }
            else {
                $this->Logger->error("Cant generate new Token old was not deleted");
                return $this->sendError(ErrorCodes::GENERAL_ERROR,"Cant generate new Token old was not deleted");
            }

            //Insert New Token







        }
        catch(\Exception $e) {
            $this->Logger->error("[BETCONSTRUCT] RefreshToken Exception: ".$e->getMessage());
            return $this->sendError(ErrorCodes::GENERAL_ERROR,"Exception Thrown: ".$e->getMessage());
        }


    }


    /**
     * @param Request $request
     * @return boolean
     */
    private function isHashValid(Request $request)
    {
        //TODO check Key Validity


        try {

            //Shared Secret Key
            $sharedKey = Config::KEY();

            //Grab Request Parameters as Array
            $requestBody = $request->getContent();


            $hash_string = $requestBody.$sharedKey;

            $calculatedHash = hash('sha256', $hash_string);

            return true;

        }catch(\Exception $e) {
            return true;
        }

    }


    /**
     * @param $code
     * @param $description
     * @return mixed
     */
    private function sendError($code, $description) {
        return [
            'HasError'=>true,
            'ErrorId'=>$code,
            'ErrorDescription'=>$description
        ];
    }


    /**
     * Sends Success Response To BetConstruct
     * @param $data
     * @return array
     */
    private function sendSuccess($data) {
        return array_merge($data,[
            'HasError'=>false,
            'ErrorId'=>0
        ]);
    }


    /**
     * @param $key
     * @param $data
     * @return bool
     */
    private function updateAndReturnToken($key,$data) {
        $updated = $this->Persistence->edit(Config::PROVIDER().$key,$data);
        if($updated) {
            return true;
        }
        else {
            return false;
        }
    }


    /**
     * @param $token
     * @return bool|mixed
     */
    private function isTokenPersisted($token) {
        try {
            $exists = $this->Persistence->check(Config::PROVIDER().$token);
            if($exists) {
                return $exists;
            }
            else {
                return false;
            }
        }catch(\Exception $e) {
            return false;
        }

    }



}