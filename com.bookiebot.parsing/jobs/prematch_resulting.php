<?php

session_start();
session_set_cookie_params(3600,"/","",true,true);

define("APP", true);
define("PARSING", true);

ini_set("display_errors",1);

//ROOT
define("ROOT_DIR",substr(dirname(__FILE__),0,-4));

define("SYSTEM_DIR",ROOT_DIR."system/");
define("HELPERS_DIR",ROOT_DIR."helpers/");



define("API_DIR",ROOT_DIR);


//API Exposed Services DIR
define("SERVICE_DIR",API_DIR."/services/");



require_once SYSTEM_DIR."config.php";
require_once SYSTEM_DIR."/Service.php";
require_once SYSTEM_DIR."/Api.class.php";
require_once HELPERS_DIR."/MysqliDb.php";



$internal = true;
$_REQUEST['service'] = "parsing._resulting";
if(!isset($_REQUEST['method'])) {
    $_REQUEST['method'] = "result";
}


$db = new MysqliDb ($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);
$api = new API;
$api->process();



