<?php


ini_set("soap.wsdl_cache_enabled", 1);
ini_set("display_errors",1);


$client = new SoapClient("https://api.betplanet.win/CoreServicesForIntegrations/Soap/integration?wsdl",array('trace'=>1));




//$auth_params = GetParams(
//    array(
//        "token"=>"05709588-d6ad-43a9-81cc-a2d3a4ffced4"
//    )
//);
//
//
//print_r($auth_params);
//
//$ret = $client->authenticateUserByToken($auth_params);


//
//$balance_params = GetParams(
//    array(
//        "userID"=>1,
//        "currencyID"=>2,
//        "isSingle"=>true
//    )
//);
//
//
//$ret = $client->getBalance($balance_params);


//$auth_params = GetParams(
//    array(
//        "userID"=>1
//    )
//);
//$ret = $client->getUserInfo($auth_params);





//$ret = json_decode(json_encode($ret),true);
//echo "<pre>";
//print_r($ret);













//echo "Response:\n" . $client->__getLastResponse() . "\n";







function GetParams($params) {
    $return_params = array(
        "providerID"=>"8f672252-7516-41dd-807c-f1532ae6aa1e"
    );

    $string_to_hash = "8f672252-7516-41dd-807c-f1532ae6aa1e";
    foreach($params as $paramKey=>$paramVal) {

        if($paramVal && $paramVal!=null && $paramVal!="null") {
            if($paramVal === true) {
                $paramVal = "true";
            }
            if($paramVal === false) {
                $paramVal = "false";
            }

            $string_to_hash .= (string)$paramVal;

        }



        $return_params[$paramKey] = $paramVal;
    }

    $string_to_hash .= "8b41ceeb-715b-4fd8-aff3-215d06709375";

//    echo $string_to_hash;
//    echo "<br/>";

    $return_params['hash'] = md5($string_to_hash);
    return $return_params;
}
