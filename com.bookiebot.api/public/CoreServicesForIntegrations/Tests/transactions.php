<?php

ini_set("soap.wsdl_cache_enabled", 0);
ini_set("display_errors",1);

$client = new SoapClient("http://api.betplanet.win/CoreServicesForIntegrations/Soap/transactions/?wsdl");



echo "<pre>";

$with_params = GetParams(array(
    "userID"=>1,
    "currencyID"=>1,
    "amount"=>5,
//    "shouldWaitForApproval"=>false,
    //"providerUserID"=>44,
    "providerOppCode"=>"XXXXX-YYYYY-ZZZZgg",
    "requesterIP"=>"127.0.0.1"
    //"additionalData"=>"kargiramea",
    //"statusNote"=>null
));
$ret = $client->withdrawMoney($with_params);
print_r($ret);
$ret = $client->checkTransactionStatus(array(
    "isCoreTransactionID"=>true
));



//$rollback_params = GetParams(array(
//    "transactionID"=>'73366191-91b9-4dc6-848b-177c204f2434',
//    "isCoreTransactionID"=>false
//));
//print_r($rollback_params);
//$ret = $client->rollbackTransaction($rollback_params);
//print_r($ret);





//$dep_params = GetParams(array(
//    "userID"=>3,
//    "currencyID"=>2,
//    "amount"=>33,
//    "isCardVerification"=>true,
////    "shouldWaitForApproval"=>false,
//    //"providerUserID"=>44,
//    "providerOppCode"=>55,
//    "requesterIP"=>"127.0.0.1"
//    //"additionalData"=>"kargiramea",
//    //"statusNote"=>null
//));
//$ret = $client->depositMoney($dep_params);
//$ret = json_decode(json_encode($ret),true);
//print_r($ret);


/**
 * Check Transaction Status
 */
//$check_status = GetParams(array(
//    "transactionID"=>71449,
//    "isCoreTransactionID"=>false
//));
//$ret = $client->checkTransactionStatus($check_status);
//$ret = json_decode(json_encode($ret),true);
//print_r($ret);






//$check_status = GetParams(array(
//    "transactionID"=>71449,
//    "isCoreTransactionID"=>false
//));
//$ret = $client->rollbackTransaction($check_status);
//$ret = json_decode(json_encode($ret),true);
//print_r($ret);



function GetParams($params) {


    $return_params = array(
        "providerID"=>"8f672252-7516-41dd-807c-f1532ae6aa1e"
    );


    //String To Make Hash
    $string_to_hash = $return_params['providerID'];

    $kk = "";

    foreach($params as $paramKey=>$paramVal) {

        if ($paramKey == "isVerified" || $paramKey == "isSingle" || $paramKey == "isActive" || $paramKey == "isInvite" || $paramKey == "transactionIsCash" || $paramKey == "isCardVerification" || $paramKey == "isCoreTransactionID" || $paramKey == "useProviderID" || $paramKey == "shouldWaitForApproval")
            $string_to_hash .= (int)$params[$paramKey] == 1 ? "true" : "false";
        else
            $string_to_hash .= $params[$paramKey];

        $return_params[$paramKey] = $paramVal;
    }
    $string_to_hash .= "8b41ceeb-715b-4fd8-aff3-215d06709375";


    $return_params['hash'] = md5($string_to_hash);


//    echo "Sent: ".$kk;
//    echo "<br/>";
//    print_r($return_params);



    return $return_params;
}

