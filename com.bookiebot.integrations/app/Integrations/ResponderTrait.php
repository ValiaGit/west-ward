<?php

namespace App\Integrations;

use App\Integrations\Constants\GISErrorCodes;


trait ResponderTrait {


    /**
     * @param $responseData
     * @param string $responseMessage
     * @param bool $successCode - From External System, Sometimes Operation is success, buthi this success has sub operations
     *                            For Example some times both 10 and 157 codes are success but need different handling
     * @param bool $httpCode
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function respondSuccess($responseData,$responseMessage = "Action was Successful",$successCode = false, $httpCode = false) {


        $responseData = [
            "code"=>GISErrorCodes::SUCCESS,
            "message"=>$responseMessage,
            "data"=>$responseData
        ];

        if($successCode) {
            $responseData['external_success_code'] = $successCode;
        }


        if($httpCode) {
            return response()->json($responseData,$httpCode);
        }

        return $responseData;
    }


    /**
     * @param $errorCode
     * @param $errorMessage
     * @param bool $externalErrorCode
     * @param bool $httpCode
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function respondError($errorCode, $errorMessage, $externalErrorCode = false, $httpCode = false) {

        $responseData = [
            "code"=>-1,
            "error_code"=>$errorCode,
            "error_message"=>$errorMessage
        ];

        if($externalErrorCode) {
            $responseData['external_error_code'] = $externalErrorCode;
        }

        // If We Have HTTP Code present should respond with http status code
        if($httpCode) {
            return response()->json($responseData,$httpCode);
        }


        return $responseData;
    }


}


