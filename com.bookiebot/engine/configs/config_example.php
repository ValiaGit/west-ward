<?php


if (!defined("APP")) {
    die("Dont have Access");
}



$config = array(

//    'dbhost'=>'localhost',
//    'dbname'=>'website',
//    'dbuser'=>'root',
//    'dbpass'=>'v)81f9Rrl1]n',

    'dbhost'=>'127.0.0.1',
    'dbname'=>'website',
    'dbuser'=>'root',
    'dbpass'=>'Shako1992',


    //Api Url Where Call Will Be Sent
    'api_url'=>"http://api.com.bookiebot:8080/",
    'base_href' => "http://com.bookiebot:8080",
    'domain' => $_SERVER['HTTP_HOST'],



    /**
     * FaceBook Application Credentials
     */
    'app_id' => "832883240063300",
    'app_secret' => "cfd76c41abf359b5ab01848786bade4a",


    /**
     * Saults
     */
    'login_sault' => '#@$ESAF&SAD',
    'password_sault' => 'ASD#:?$@<K%@#',
    'api_sault' => "SAFDJW#AE$*(&#",
    'usersession_sault' => "asfdsa$%#WZ$",


    /**
     * SYSTEM
     */
    'default_skin' => 'default',
    'default_contrtoller' => 'index',
    "default_lang" => "geo",
    "default_langN" => "0",

    "common_modules" => "header,footer,topmenu,bettingmenu,socialmenu,accountmenu,sidebarmenu,accountsubmenu",


    'langs' => array(
        "ka" => array('lang' => 'ka', 'langN' => 0),
        "en" => array('lang' => 'en', 'langN' => 1),
        "ru" => array('lang' => 'ru', 'langN' => 2),
        "ja" => array('lang' => 'ja', 'langN' => 3),
        "de" => array('lang' => 'de', 'langN' => 4)
    )



);

if (isset($_SERVER['HTTP_HOST'])) {
    $config['base_href'] = "http://com.bookiebot:8080";
}


?>