<?php


namespace App\Integrations\Casino\Singular;


class ErrorCodes
{
    const STATUS_SUCCESS = 10;

    const WRONG_REQUEST = 99;

    const STATUS_ITEM_EXISTS = 200;
    const STATUS_ITEM_DOES_NOT_EXISTS = 400;
    const STATUS_UNABLE_TO_CHECK_ITEM = 500;

    const FIELD_LIMIT_REACHED = 100;
    const FIELD_MIN_MAX_NOT_MATCHED = 101;
    const FIELD_FORMAT_NOT_MATCHED = 102;
    const FIELD_IS_EMPTY = 103;
    const PATTERN_IS_NOT_MATCHED = 104;
    const COUNTRY_NOT_SUPPORTED = 105;
    const AGE_LIMIT_NOT_MATCHED = 106;
    const ID_DOCUMENT_IS_MISSING = 107;
    const MAX_POSSIBLE_REG_PER_IP_REACHED = 108;
    const UNABLE_TO_SAVE_ID_DOC = 109;
    const UNABLE_TO_ASSIGN_ACCOUNT_TO_USER = 110;

    const GENERIC_FAILED_ERROR = 111;
    const MISSING_PARAMETERS = 112;
    const ACCOUNT_WITH_GIVEN_USERNAME_OR_PASSWORD_NOT_FOUND = 113;
    const OTP_REQUEST_LIMIT_REACHED = 114;
    const UNABLE_TO_SEND_OTP_TEL_IS_MISSING = 115;
    const UNABLE_TO_SEND_SMS_CODE_OTP_IS_ENABLED = 116;
    const FAILED_TO_SEND_OTP = 117;
    const OTP_IS_SENT = 118;
    const OTP_NOT_FOUND = 119;
    const OTP_IS_NOT_ENABLED = 120;
    const UNABLE_TO_GENERATE_OTP = 121;
    const OTP_IS_REQUIRED = 122;
    const LAST_ACCESS_FROM_DIFFERENT_IP = 123;

    const IP_IS_BLOCKED = 124;
    const ACCOUNT_NOT_FOUND = 125;
    const SESSION_NOT_FOUND = 126;

    const OLD_AND_NEW_VALUES_MATCH_ERROR = 127;
    const CONTACT_DETAILS_NOT_ASSIGNED = 128;
    const CONTACT_DETAIL_NOT_MATCHED = 129;
    const UNABLE_TO_ENABLE_OTP_TEL_IS_MISSING = 130;

    const ACCOUNT_IS_BLOCKED = 131;
    const OTP_IS_OFF = 132;
    const USER_HAS_GIVEN_ID_DOC = 133;
    const OTP_IS_ENABLED = 134;
    const USERS_DOCUMENT_NOT_FOUND = 135;
    const DOCUMENT_PHOTO_ALREADY_EXISTS = 136;

    const PROVIDER_NOT_FOUND = 137;
    const ACCESS_DENIED = 138;
    const WRONG_HASH = 139;
    const ACCESS_GRANTED = 140;
    const USER_IS_SELF_EXCLUDED = 141;
    const WRONG_DATES = 142;
    const CAN_NOT_BE_NEGATIVE = 143;
    const MUST_BE_MORE_THAN_ZERO = 144;
    const CURRENCY_NOT_FOUND = 145;
    const USERS_ACCOUNTS_NOT_FOUND = 146;
    const TOKEN_NOT_FOUND = 147;
    const TOKEN_IS_EXPIRED = 148;
    const INCORRECT_USER_STATUSID = 149;
    const ACCESS_DENIED_FOR_GIVEN_PROVIDER = 150;
    const DUPLICATED_PROVIDERS_TRANSACTIONID = 151;
    const TRANSACTION_LIMIT_WAS_REACHED = 152;
    const TRANSACTION_AMOUNT_AND_LIMIT_DONT_MATCH = 153;
    const INSUFFICIENT_FUNDS = 154;
    const INCORRECT_TRANSACTION_ID_FORMAT = 155;



    const TRANSACTION_NOT_FOUND = 156;
    const TRANSACTION_STATUS_SUCCESS = 157;
    const TRANSACTION_STATUS_ROLLBACK = 158;
    const TRANSACTION_STATUS_APPROVED = 181;
    const TRANSACTION_STATUS_PENDING = 182;
    const TRANSACTION_STATUS_REJECTED = 183;
    const TRANSACTION_STATUS_FROZEN = 184;
    const TRANSACTION_STATUS_CANCELED = 185;


    const ACCOUNT_IS_SUSPENDED = 159;
    const UNABLE_TO_GET_BALANCE = 170;
    const UNABLE_TO_EXCHANGE = 171;

    const TRANSACTION_ROLLBACK_TIME_EXPIRED = 172;
    const UNABLE_TO_ROLLBACK_TRANSACTION = 173;

    const PAYMENT_ACCOUNT_NOT_FOUND = 174;
    const PAYMENT_ACCOUNT_IS_NOT_VERIFIED = 175;

    const EXCHANGE_RATE_NOT_FOUND = 176;

    const CARD_VERIFICATION_TRANSACTION_DOES_NOT_REQUIRE_APPROVAL = 177;

    const UNIDENTIFIED_TRANSACTION_STATUS = 178;

    const UNABLE_TO_CHANGE_TRANSACTION_STATUS_FROM_CURRENT_STATUS = 179;
    const UNABLE_TO_CHANGE_TRANSACTION_STATUS = 180;

    const PROVIDER_IS_DISABLED = 186;

}