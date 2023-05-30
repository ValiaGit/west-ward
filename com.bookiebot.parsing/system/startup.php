<?php
if(!defined("APP")) {
    die("");
}
//Base API Classes
require_once ROOT_DIR."system/config.php";
require_once ROOT_DIR."system/Service.php";
require_once ROOT_DIR."system/Api.class.php";

$internal = true;
$_REQUEST['service'] = "parsing._betradar";
if(!isset($_REQUEST['method'])) {
    $_REQUEST['method'] = "request";
}