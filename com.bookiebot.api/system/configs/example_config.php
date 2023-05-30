<?php


if (!defined("APP")) {
    die("Dont have Access");
}

if (isset($_SERVER['HTTP_HOST'])) {
    $host = "http://" . $_SERVER['HTTP_HOST'];
} else {
    $host = "http://api.com.bookiebot:8080";
}

$config = array(

    'dbhost' => "127.0.0.1",
    'dbname' => 'bookiebo_stock',
    'dbuser' => 'root',
    'dbpass' => 'Shako1992',
    'dbsocket' => NULL,

    's3_key' => 'AKIAIYDIT4VZRET5OFAQ',
    's3_secret' => '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',
    's3_bucket' => 'bookiebot.images',
    's3_region' => 'eu-central-1',


    'time_zone' => 'America/New_York',


    'sms_user' => 'westward_sms',
    'sms_pass' => 'WEsTW@rder3344',
    'sms_api' => '3605986',



    'app_id' => "832883240063300",
    'app_secret' => "cfd76c41abf359b5ab01848786bade4a",


    /**
     * Used To Create Hash For Api Calls Based On PHP Session
     */
    'api_sault' => "SAFDJW#AE$*(&#",

    /**
     * Used To Create CSRF Token
     */
    'csrf_sault' => "asd#L:J&@#?$@#4",


    /**
     * Used To Create Hash For Logged In User On User Specific Requests
     */
    'auth_sault' => '#@$ESAF&#@$^^#@%$SAD',


    /**
     * Used For Creating And retrieving Passwords
     */
    'password_sault' => 'ASD#:?$@<K%@#',


    's_trading_url'=>'https://webservices.securetrading.net:443/xml/',
    's_trading_account'=>'test_westwardent68138',
    's_trading_user'=>'payments@bookiebot.com',
    's_trading_password'=>'Shako1992',

    's_trading_payment_page_notification_url'=>'https://api.bookiebot.com/PaymentGateway/Deposit/SecureTrading/index.php',
    's_trading_payment_page_url'=>'https://payments.securetrading.net/process/payments/choice',

    's_trading_notification_password'=>'@#$OLJ@H#&$@#',




    'apco_url'=>'https://www.apsp.biz/pay/fp5A/Checkout.aspx',
    'apco_profile'=>'617A482714A64D4DAC476260153EEF01',
    'apco_secret'=>'2509bd14dd',

    'apco_mCode'=>'8992',
    'apco_mPass'=>'go1i4iva',


    'apco_listener_url'=>'http://api.bookiebot.com/PaymentGateway/Deposit/ApcoPayments/listener.php',



    /**
     *
     */
    'security_questions_sault' => ':SAKDDAUSDA)*)SD&!)@',


    /**
     * SYSTEM
     */
    'base_href' => 'http://api.com.bookiebot:8080/',
    'client_url'=>'http://com.bookiebot:8080',
    'cookie_domain'=>'com.bookiebot',
    "default_lang" => "geo",
    "default_langN" => "0",



    'langs' => array(
        "ka" => array('lang' => 'ka', 'langN' => 0),
        "en" => array('lang' => 'en', 'langN' => 1),
        "ru" => array('lang' => 'ru', 'langN' => 2),
        "ja" => array('lang' => 'ja', 'langN' => 3),
        "de" => array('lang' => 'de', 'langN' => 4)
    ),

    'affiliates_url'=>'http://localhost:1337',
    'affiliates_request_key'=>'iXvniskarta saaxalwlo sufraze',
    'affiliates_hash_id_sault'=>'salt saaxalwlo sufraze!',


    "core_soap_shitelist"=>array(
        '5.10.35.45',
        '46.165.206.129',
        '176.74.97.106'
    )



);


?>