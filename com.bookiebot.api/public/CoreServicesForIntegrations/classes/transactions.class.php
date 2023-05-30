<?php


if (!defined("APP")) {
    header('HTTP/1.0 404 Not Found');
    die("<h1>Not Found</h1>");
}

require_once("_base.class.php");


class CoreTransactionsExposed extends Base
{


    /**
     * userID: UserId,
     * currencyID: CurrencyId,
     * amount: Amount,
     * shouldWaitForApproval:false,
     * isCardVerification:false,
     * //providerUserID:null,
     * providerOppCode:LocalTransactionId,
     * //additionalData: null,
     * requesterIP: IP
     */
    public function withdrawMoney($parameters)
    {

        $provider_id = $this->checkHash($parameters);
        if (!$provider_id) {
            return $this->getErrorResponse(CoreErrorCodes::WRONG_HASH);
        }



        try {
            global $db;

            $userId = $parameters->userID;
            $providerID = $parameters->providerID;
            $currencyID = $parameters->currencyID;
            $amount = $parameters->amount;
            $providerUserID = $parameters->providerUserID;
            $providerOppCode = $parameters->providerOppCode;
            $additionalData = $parameters->additionalData;
            $requesterIP = $parameters->requesterIP;


            //If Some Mandatory Params Are Missing
            if (!$userId || !$currencyID || !$amount || !$providerOppCode) {
                return $this->getErrorResponse(CoreErrorCodes::MISSING_PARAMETERS);
            }


            //If Provider Transaction Code Already Exists
            if ($this->checkProviderTransactionExists($provider_id, $providerOppCode)) {
                return $this->getErrorResponse(CoreErrorCodes::DUPLICATED_PROVIDERS_TRANSACTIONID);
            }


            //Check Has Enough Balance
            $db->where('id', $userId);
            $balanceResponse = $db->getOne('core_users', 'balance');
            if (!$balanceResponse || $balanceResponse['balance'] < $amount) {
                return $this->getErrorResponse(CoreErrorCodes::INSUFFICIENT_FUNDS);
            }


            //Start Transactions
            $db->startTransaction();


            //Insert New Transaction
            $transaction_insert_data = array(
                "transaction_unique_id" => uuid_v4(),
                "core_providers_id" => $provider_id,
                "core_providers_guid" => $providerID,
                "core_users_id" => $userId,
                "core_currencies_id" => $currencyID,
                "amount" => $amount,
                "type" => 1,//Decrease Main Balance - Core To Game
                "status" => 1,
                "provider_transactions_id" => $providerOppCode,
                "provider_user_id" => $providerUserID,
                "ip" => ip2long($requesterIP),
                "additional_data" => $additionalData
            );
            $insert_transaction = $db->insert("core_providers_transactions", $transaction_insert_data);


            //Update User Balance
            $db->where("id", $userId);
            $update_user_balance = $db->update("core_users", array(
                "balance" => $db->dec($amount)
            ));


            if ($insert_transaction && $update_user_balance) {
                $db->commit();
                return array(
                    "result" => array(
                        "responseCode" => 10,
                        "percent" => 0,
                        "transactionID" => $transaction_insert_data['transaction_unique_id']."|".$insert_transaction
                    )
                );
            }
            else {
                $db->rollback();
                return array(
                    "result" => array(
                        "responseCode" => CoreErrorCodes::GENERIC_FAILED_ERROR,
                        "percent" => 0,
                        "transactionID" => null
                    )
                );
            }
        } catch (Exception $e) {
            return array(
                "result" => array(
                    "responseCode" => CoreErrorCodes::GENERIC_FAILED_ERROR,
                    "percent" => 0,
                    "transactionID" => null
                )
            );
        }


    }


    /**
     * @param $parameters
     * @return array
     */
    public function checkTransactionStatus($parameters)
    {
        try {

            $transactionId = $parameters->transactionID;
            $isCoreTransactionID = $parameters->isCoreTransactionID;

            //If Missing TransactionId
            if (!$transactionId) {
                return $this->getErrorResponse(113);
            }

            $parameter = "transaction_unique_id";
            if ($isCoreTransactionID) {
                $parameter = "provider_transactions_id";
            }


            global $db;

            //Get Transaction
            $db->where($parameter, $transactionId);
            $db->orWhere($parameter, $transactionId);

            $transaction_details = $db->getOne("core_providers_transactions", "id,transaction_unique_id,status,type");

            //Transaction was not found
            if (!count($transaction_details)) return $this->getErrorResponse(CoreErrorCodes::TRANSACTION_NOT_FOUND);


            $transactionStatusCode = CoreErrorCodes::STATUS_SUCCESS;

            if ($transaction_details['type'] == 3 && $transaction_details['status'] == 1) {
                //Transaction Is RolledBack
                $transactionStatusCode = 11;
            }


            $description = "";
            if ($transaction_details['type'] == 1) {
                $description = "withdraw";
            } else if ($transaction_details['type'] == 2) {
                $description = "deposit";
            } else if ($transaction_details['type'] == 3) {
                $description = "rollback";
            }


            return array(
                "result" => array(
                    "responseCode" => 10,
                    "returnValue" => $transaction_details['transaction_unique_id'],
                    "description" => $description
                )
            );


        } catch (Exception $e) {
            return $this->getErrorResponse(CoreErrorCodes::GENERIC_FAILED_ERROR);
        }
    }


    /**
     * @param $parameters
     * @return array
     */
    public function depositMoney($parameters)
    {

        $check_hash = $this->checkHash($parameters);
        if (!$check_hash) {
            return $this->getErrorResponse(CoreErrorCodes::WRONG_HASH);
        }


        try {

            global $db;


            $userId = $parameters->userID;
            $providerID = $parameters->providerID;
            $currencyID = $parameters->currencyID;
            $amount = $parameters->amount;
            $providerUserID = $parameters->providerUserID;
            $providerOppCode = $parameters->providerOppCode;
            $additionalData = $parameters->additionalData;
            $requesterIP = $parameters->requesterIP;


            //If Some Mandatory Params Are Missing
            if (!$userId || !$currencyID || !$amount || !$providerOppCode) {
                return $this->getErrorResponse(CoreErrorCodes::WRONG_REQUEST);
            }


            //If Provider Transaction Code Already Exists
            if ($this->checkProviderTransactionExists($check_hash, $providerOppCode)) {
                return $this->getErrorResponse(CoreErrorCodes::DUPLICATED_PROVIDERS_TRANSACTIONID);
            }


            //Start Transactions
            $db->startTransaction();


            //Insert New Transaction
            $transaction_insert_data = array(
                "transaction_unique_id" => uuid_v4(),
                "core_providers_id" => $check_hash,
                "core_providers_guid" => $providerID,
                "core_users_id" => $userId,
                "core_currencies_id" => $currencyID,
                "amount" => $amount,
                "type" => 2,//Increase Main Balance - Game To Core
                "status" => 1,
                "provider_transactions_id" => $providerOppCode,
                "provider_user_id" => $providerUserID,
                "ip" => ip2long($requesterIP),
                "additional_data" => $additionalData
            );
            $insert_transaction = $db->insert("core_providers_transactions", $transaction_insert_data);


            //Update User Balance
            $db->where("id", $userId);
            $update_user_balance = $db->update("core_users", array(
                "balance" => $db->inc($amount)
            ));


            if ($insert_transaction && $update_user_balance) {

                $db->commit();

                return array(
                    "result" => array(
                        "responseCode" => 10,
                        "returnValue" => $transaction_insert_data['transaction_unique_id']."|".$insert_transaction
                    )
                );


            } else {
                $db->rollback();
                return $this->getErrorResponse(CoreErrorCodes::GENERIC_FAILED_ERROR, null);
            }


        } catch (Exception $e) {
            return $this->getErrorResponse(CoreErrorCodes::GENERIC_FAILED_ERROR);
        }

    }


    /**
     * @return array
     */
    public function rollbackTransaction($parameters)
    {

        $provider_id = $this->checkHash($parameters);

        if (!$provider_id) {
            return $this->getErrorResponse(CoreErrorCodes::WRONG_HASH);
        }

        try {

            $transactionId = $parameters->transactionID;
            $isCoreTransactionID = $parameters->isCoreTransactionID;

            //If Missing TransactionId
            if (!$transactionId) {
                return array("result" => CoreErrorCodes::MISSING_PARAMETERS);
            }

            global $db;

            $parameter = "transaction_unique_id";
            if (!$isCoreTransactionID) {
                $parameter = "provider_transactions_id";
            }


            $db->where($parameter, $transactionId);
            $db->orWhere('id',$transactionId);
            $db->where('core_providers_id', $provider_id);
            $db->where("status", 1);




            $transaction_details = $db->getOne("core_providers_transactions", "id,amount,core_users_id,type,core_currencies_id");

            //If Transaction Was Not Found
            if (!count($transaction_details)) {
                return array("result" => CoreErrorCodes::TRANSACTION_NOT_FOUND);
            }


            /**
             * Transaction Type
             *  1 = Core To Game - Should Deposit Back On Users Balance
             *  2 = Game To Core - Should Subtract From Main Balance
             */
            $transaction_type = $transaction_details['type'];

            $user_id = $transaction_details['core_users_id'];


            $db->startTransaction();


            //1 = Core To Game - Should Deposit Back On Users Balance
            if ($transaction_type == 1) {//Was Withdraw Transaction

                $type = 4;
                $update_balance_data = array(
                    'balance' => $db->inc($transaction_details['amount'])
                );
            }


            //2 = Game To Core - Should Subtract From Main Balance
            else if ($transaction_type == 2) {//Was Deposit Transaction

                $type = 3;

                //Check Has Enough Balance, If not Send Error Code And Terminate Execution
                $db->where('id',$user_id);
                $balanceResponse = $db->getOne('core_users','balance');
                if(!$balanceResponse || !count($balanceResponse)) {
                    //TODO Log Properly
                    return array("result" => CoreErrorCodes::GENERIC_FAILED_ERROR);
                }


                if($balanceResponse['balance']<$transaction_details['amount']) {
                    return array("result" => CoreErrorCodes::INSUFFICIENT_FUNDS);
                }


                $update_balance_data = array(
                    'balance' => $db->dec($transaction_details['amount'])
                );
            }


            //Respond That Transaction Was Already Processed
            else if ($transaction_type == 3 || $transaction_type == 4) {
                return array("result" => CoreErrorCodes::TRANSACTION_STATUS_ROLLBACK);
            }

            else {
                return array("result" => CoreErrorCodes::GENERIC_FAILED_ERROR);
            }


            //Increase User Balance
            $db->where("id", $user_id);
            $update_user_balance = $db->update("core_users", $update_balance_data);

            //Update Transaction Status
            $db->where('id', $transaction_details['id']);
            $update_transaction_status = $db->update("core_providers_transactions", array(
                "type" => $type
            ));


            if ($update_user_balance && $update_transaction_status) {
                $db->commit();
                return array("result" => CoreErrorCodes::STATUS_SUCCESS);
            } //Some Of Transaction Components Failed
            else {
                $db->rollback();
                return array("result" => CoreErrorCodes::GENERIC_FAILED_ERROR);
            }


        } catch (Exception $e) {
            //TODO Log ransaction Rollback Error
            return array("result" => CoreErrorCodes::GENERIC_FAILED_ERROR);
        }


    }


    /**
     *
     */
    private function checkProviderTransactionExists($provider_id, $transaction_id)
    {
        global $db;

        $db->where("core_providers_id", $provider_id);
        $db->where("provider_transactions_id", $transaction_id);

        $exists = $db->getOne("core_providers_transactions", "id");

        if (count($exists)) {
            return true;
        }

        return false;

    }


}









//depositMoney
/**
 * userID: UserId,
 * currencyID: CurrencyId,
 * amount: Amount,
 * shouldWaitForApproval:false,
 * isCardVerification:false,
 * //providerUserID:null,
 * providerOppCode:LocalTransactionId,
 * //additionalData: null,
 * requesterIP: IP
 */


//withdrawMoney
/**
 * userID: UserId,
 * currencyID: CurrencyId,
 * amount: Amount,
 * shouldWaitForApproval:false,
 * //providerUserID: null,
 * providerOppCode: LocalTransactionId,
 * //additionalData: null,
 * requesterIP: IP
 * //statusNote: null
 */


//checkTransactionStatus
/**
 * transactionID:LocalTransactionId,
 * isCoreTransactionID:false
 */


//rollbackTransaction
/**
 * transactionID:LocalTransactionId,
 * isCoreTransactionID:false
 */


//exchange
/**
 * sourceCurrencyID: sourceCurrency,
 * destinationCurrencyID: destinationCurrency,
 * amount: amount,
 * isReverse:false
 */