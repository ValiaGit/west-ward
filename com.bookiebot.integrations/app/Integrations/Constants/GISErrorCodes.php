<?php

namespace App\Integrations\Constants;

class GISErrorCodes
{

    const SUCCESS = 200;
    const TRANSACTION_ALREADY_EXISTS = 208;


    const WRONG_REQUEST = 400;
    const FORBIDDEN = 403;
    const NOT_FOUND = 404;
    const TRANSACTION_NOT_FOUND = 408;
    const MISSING_MANDATORY_PARAMETERS = 422;
    const NOT_SUFFICIENT_FUNDS = 423;


    const TRANSACTION_STATUS_SUCCESS = 157;
    const TRANSACTION_STATUS_ROLLBACK = 158;
    const TRANSACTION_STATUS_APPROVED = 181;
    const TRANSACTION_STATUS_PENDING = 182;
    const TRANSACTION_STATUS_REJECTED = 183;
    const TRANSACTION_STATUS_FROZEN = 184;
    const TRANSACTION_STATUS_CANCELED = 185;



    const GENERAL_ERROR = 500;
    const CANT_ROLLBACK_TRANSACTION = 501;
    const OPERATION_FAILED = 502;
    const CANT_DETERMINE_USER_BALANCE = 503;



}

