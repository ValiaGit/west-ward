<?php

if (!defined("APP")) {
    // die("No Access!");
}



/**
 * DEBUG
 */
function pre($var) {
    echo "<pre style='background:black;color:white'>";
    print_r($var);
    echo "</pre>";
}


date_default_timezone_set("Asia/Tbilisi");

if($env == "prod") {
    require_once "configs/config.php";
} else {
    require_once "configs/local_config.php";

}


require_once "smarty/Smarty.class.php";




define('SKIN_DIR',ROOT_DIR."/app/templates/$config[default_skin]/");
define('HREF',$config['base_href']);



/**
 * CONTROLL LANGUAGE
 */
$lang = 'en';
$langN = 1;


$possible_lang = false;
if(isset($_GET['lang'])) {
    $possible_lang = $_GET['lang'];
}

else if(isset($_COOKIE['lang'])) {
    $possible_lang = $_COOKIE['lang'];
}


if($possible_lang) {
    if(array_key_exists($possible_lang, $config['langs'])) {
        $ConfigLangVal = $config['langs'][$possible_lang];
        $lang = $ConfigLangVal['lang'];
        $langN = $ConfigLangVal['langN'];
    }
}

if(!isset($_COOKIE['lang']) || $_COOKIE['lang']!=$lang) {
    setcookie("lang", $lang);
    setcookie("langN", $langN);
}





define("LANG",$lang);
define("LANGN",$langN);


require_once LANG_DIR.LANG.".php";



/**
 * Loads Some Basic Classes
 */
function loadHelper($classname) {
    if(file_exists(ENGINE_DIR."helpers/$classname.helper.php")) {
        require_once ENGINE_DIR."helpers/$classname.helper.php";
    }
}


/**
 * Loads Some System Classes
 */
function loadSystemClass($classname) {
    if(file_exists(SYSTEM_DIR."$classname.class.php")) {
        require_once SYSTEM_DIR."$classname.class.php";
    }
}







//Load Helper Classes
loadHelper("Mysqli");
loadSystemClass("Fn");
IFn::CleanRequests();

loadSystemClass("Action");
loadSystemClass("Model");
loadSystemClass("Module");
loadSystemClass("Controller");



loadSystemClass("Template");
$tpl = new Template();
$tpl->assign('absolute_url',"http" . (isset($_SERVER['HTTPS']) ? 's' : '') . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}");
$tpl->assign('base_href',HREF);
$tpl->assign('cur_lang',$lang);
$tpl->assign('lang_arr',$langPackage);
$tpl->assign('config',$config);
$tpl->assign('cache_version',time());
$tpl->assign('api_url',$config['api_url']);

$exploded = explode(".", $config['domain']);

$tpl->assign('domain', $exploded[0]);

$ip = null;
if(isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
    $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
}
$tpl->assign('ip', $ip);


