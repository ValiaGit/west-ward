<?php

if(!defined("APP")) {
    header('HTTP/1.0 404 Not Found');
    die("<h1>Not Found</h1>");
}


//ROOT
define("ROOT_DIR",substr(dirname(__FILE__),0,-6));


define("UPLOADS_DIR", dirname(__FILE__)."/uploads/");

define("SYSTEM_DIR", ROOT_DIR."/system/");

define("API_DIR",ROOT_DIR);


if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
    $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
}

if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_X_FORWARDED_FOR"];
}

define("IP",$_SERVER['REMOTE_ADDR']);


//print_r($_SERVER);
//if(@$_SERVER['REQUEST_SCHEME'] == 'http' && !isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
//    header("location:https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
//    echo "<meta http-equiv='refresh' content='0; url=https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]'>";
//    exit;
//}
//
//
//
//if(isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
//    if($_SERVER['HTTP_X_FORWARDED_PROTO'] != 'https') {
//        header("Location: https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
//        echo "<meta http-equiv='refresh' content='0; url=https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]'>";
//        exit;
//    }
//}


//print_r($_SERVER);


//API Exposed Services DIR
define("SERVICE_DIR",API_DIR."/services/");

//LANGUAGES DIR
define("LANG_DIR", SYSTEM_DIR."/language/");


$env = "local";


//Require Composer Dependencies
require_once ROOT_DIR."/vendor/autoload.php";


require_once(SYSTEM_DIR."start.php");



/**
 * Connect DB And Listen Requests
 */
$db = new Mysqlidb($config['dbhost'],$config['dbuser'],$config['dbpass'],$config['dbname'],3306);

if($env == 'local') {
    $db->rawQuery("SET sql_mode = ''");
}