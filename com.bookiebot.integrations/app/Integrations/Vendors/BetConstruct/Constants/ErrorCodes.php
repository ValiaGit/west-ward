<?php


namespace App\Integrations\BetConstruct\Constants;


class ErrorCodes {

    const WRONG_PLAYER_ID = 8;
    const NOT_ENOUGH_BALANCE = 21;
    const PLAYER_IS_BLOCKED = 29;
    const INVALID_TOKEN = 102;
    const TRANSACTION_NOT_FOUND = 107;
    const WRONG_TRANSACTION_AMOUNT = 109;
    const TRANSACTION_ALREADY_COMPLETE = 110;
    const DEPOSIT_TRANSACTION_ALREADY_RECEIVED = 111;
    const INVALID_BONUS_DEFINITION = 125;
    const GENERAL_ERROR = 130;

    /**
        Important
        1. The Platform must return error with ErrorId = 110 when the transaction
           with the same RGSTransactionId already processed except RollBack.
        2. The Platform must return error with ErrorId = 111 when the deposit
           transaction with the same RGSTransactionId already processed.
     */


}