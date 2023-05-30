<?php

session_start();


//Define Constant
define("APP",true);


ini_set("display_errors",1);


//Define Directory Where Services Will be Saved
define("SERVICE_DIR","services/");


date_default_timezone_set("Europe/Malta");

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");


$dev = "local";
if($dev=="local") {
    require_once "system/local_config.php";
} else {
    require_once "system/config.php";
}


require_once "helpers/MysqliDb.php";
require_once "system/Service.php";
require_once "system/Api.class.php";


require_once "vendor/autoload.php";



if(isset($_SESSION['expiry_time'])) {
    if($_SESSION['expiry_time']<time()) {
//        echo json_encode(array("logout"=>true));
//        die();
    } else {
        $_SESSION['expiry_time'] = time()+(60*5);
    }
}


$db = new MysqliDb ($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);
if($dev == 'local') {
    $db->rawQuery("SET sql_mode = ''");
}
$api = new API;
$api->process();
$closed = $db->_mysqli->close();


//





