<?php

session_start();
session_set_cookie_params(3600,"/","",true,true);
date_default_timezone_set('Europe/Malta');

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

require_once ROOT_DIR."services/parsing/_adjarabetTree.service.php";
require_once ROOT_DIR."services/parsing/_adjarabetMatch.service.php";


$db = new MysqliDb ($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);

if ( @$_GET['data'] == 'tree' ) {
    $parser = new _AdjarabetTree;
} elseif ( @$_GET['data'] == 'match' ) {
    $parser = new _adjarabetMatch;
} else {
    die('Sir, Point data source, please.');
}
$parser->process();
