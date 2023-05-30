<?php

$env = "prod";



//Display Errors
if($env == 'local') {
    ini_set("display_errors",1);
} else {
    ini_set("display_errors",0);
}



define("APP",true);

define("APP_ID",3);

//ROOT
define("ROOT_DIR",substr(dirname(__FILE__),0,-6));


define("UPLOADS_DIR", dirname(__FILE__)."/uploads/");

define("ENGINE_DIR", ROOT_DIR."/engine/");

define("API_DIR",ROOT_DIR);

define("IP",$_SERVER['REMOTE_ADDR']);

//API Exposed Services DIR
define("SERVICE_DIR",API_DIR."/services/");

//LANGUAGES DIR
define("LANG_DIR", ENGINE_DIR."/language/");




require_once(ENGINE_DIR."start.php");


//Require Composer Dependencies
require_once ROOT_DIR."/vendor/autoload.php";
//header("Content-type: text/html");
//$data = array();
//for($i=0;$i<15000;$i++) {
//    $data['name'.$i] = sha1(rand(10,2300));
//}
//
//echo json_encode($data);
//die();
//
if(!isset($_GET['code'])) {
    die("Wrong Request!");
}
//


/**
 * Connect DB And Listen Requests
 */
$db = new Mysqlidb($config['dbhost'],$config['dbuser'],$config['dbpass'],$config['dbname']);

require(SERVICE_DIR."/user/session.service.php");
$code = $_GET['code'];


$sessionservice = new Session();
$response = $sessionservice->confirmEmail($code);



$closed = $db->_mysqli->close();








