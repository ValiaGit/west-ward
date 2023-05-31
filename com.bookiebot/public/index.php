<?php

ini_set("display_errors", 1);

//session_destroy();
define("APP", true);

//ROOT
define("ROOT_DIR", substr(dirname(__FILE__), 0, -6));

define("PUBLIC_DIR", dirname(__FILE__));

//ENGINE
define("ENGINE_DIR", ROOT_DIR . "engine/");

//SYSTEM CLASSES DIR
define("SYSTEM_DIR", ENGINE_DIR . "system/");

//LANGUAGES DIR
define("LANG_DIR", ENGINE_DIR . "language/");

//CONTROLLERS DIR
define("CONTROLLER_DIR", ROOT_DIR . "app/controllers/");

//MODELS DIR
define("MODEL_DIR", ROOT_DIR . "app/model/");

//MODULES DIR
define("MODULES_DIR", ROOT_DIR . "modules/");

define("UPLOADS_DIR", ROOT_DIR . "uploads/");

//Define Time Constant
define("TIME", time());

$env = "local";

//INITIALIZE
require_once ENGINE_DIR . "startup.php";

//print_r($_SERVER);

//Check If Page Is Serverd Via SSL
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
    if ($_SERVER['HTTP_X_FORWARDED_PROTO'] == "http") {
        header("Location:https://" . $_SERVER['HTTP_HOST']);
        exit();
    }
}


$needs_authentication = false;
$db = new Mysqlidb($config['dbhost'], $config['dbuser'], $config['dbpass'], $config['dbname']);

Action::handle($_GET);