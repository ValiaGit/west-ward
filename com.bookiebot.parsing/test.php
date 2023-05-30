<?php
//
//
//
//// The data to send to the API
//$postData = array(
//    'user_id'=>1,
//    'product_id'=>2,
//    'amount'=>755,
//    'transaction_id'=>22,
//    'hash'=>hash('sha256','1275522iXvniskarta saaxalwlo sufraze')
//);
//
//// Setup cURL
//$ch = curl_init('http://affiliates.betplanet.win/api/add_log');
//curl_setopt_array($ch, array(
//    CURLOPT_POST => TRUE,
//    CURLOPT_RETURNTRANSFER => TRUE,
//    CURLOPT_HTTPHEADER => array(
//        'Content-Type: application/json'
//    ),
//    CURLOPT_POSTFIELDS => json_encode($postData)
//));
//
//// Send the request
//$response = curl_exec($ch);
//// Check for errors
//if($response === FALSE){
//    die(curl_error($ch));
//}
//
//
//$response = json_decode($response,true);
//if($response['code'] == 10) {
//    $profits = $response['profits'];
//    if(count($profits)) {
//
//        foreach($profits as $profit) {
//            $user_id = $profit['user_id'];
//            $amount = $profit['amount'];
//            echo $user_id;
//        }
//    }
//}
