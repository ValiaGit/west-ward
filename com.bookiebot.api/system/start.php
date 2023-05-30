<?php

if(!defined('APP')) {
    die();
}


function pre($var) {
    echo "<pre>";
    print_r($var);
    echo "</pre>";
}

//Require Global Config And Database Helper
if($env == "prod") {
    require_once SYSTEM_DIR . "/configs/config.php";
} else {
    require_once SYSTEM_DIR . "/configs/local_config.php";
}


date_default_timezone_set($config['time_zone']);



require_once SYSTEM_DIR . "/helpers/Mysqli.helper.php";
require_once SYSTEM_DIR . "/helpers/Fn.helper.php";
//require_once SYSTEM_DIR . "/helpers/S3.helper.php";
require_once SYSTEM_DIR. "/main/Dispatcher.class.php";
require_once SYSTEM_DIR. "/main/Service.php";
//require_once SYSTEM_DIR. "/main/Provider.php";



$lang = 'en';
$langID = 1;
if(isset($_REQUEST['lang'])) {
    if(array_key_exists($_REQUEST['lang'], $config['langs'])) {
        $ConfigLangVal = $config['langs'][$_REQUEST['lang']];
        $lang = $ConfigLangVal['lang'];
        $langID = $ConfigLangVal['langN'];
    }
}
define("LANG",$lang);
define("LANGN",$langID);


require_once LANG_DIR.LANG.".php";


/**
 * Configure Logging
 */
$configurator = new LoggerConfiguratorDefault();
Logger::configure($configurator->parse(ROOT_DIR.'/log_config.xml'));
$log = Logger::getLogger("API");
$payment_logger = Logger::getLogger("PAYMENTS");
$games_logger = Logger::getLogger("GAME_INTEGRATIONS");
