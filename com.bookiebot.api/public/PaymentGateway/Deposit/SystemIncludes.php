<?php


//Display Errors
ini_set("display_errors",1);

session_set_cookie_params(3600,"/",null,false,false);
session_start();

define("APP",true);


define("SERVER",3);


//Root
define("ROOT_DIR",substr(dirname(__FILE__),0,-30));


define("SYSTEM_DIR", ROOT_DIR."/system/");


define("IP",$_SERVER['REMOTE_ADDR']);

define("LANG_DIR", SYSTEM_DIR."/language/");

$env = "prod";

require_once ROOT_DIR."/vendor/autoload.php";
require_once(SYSTEM_DIR . "start.php");

$db = new Mysqlidb($config['dbhost'],$config['dbuser'],$config['dbpass'],$config['dbname'],3306);
