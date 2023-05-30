<?php


define("APP",true);

ini_set("soap.wsdl_cache_enabled", 0);
ini_set("display_errors",0);


require_once "../../../start.php";
require_once("../../classes/integration.class.php");


if(!in_array(IP,$config['core_soap_shitelist'])) {
    //die("Your IP is restricted to access service");
}



class InternalSoapServer extends SoapServer
{
    public function handle($soap_request = NULL)
    {
        global $log;
        parent::handle();
        $xml = ob_get_contents();
        ob_end_clean();
        echo $xml;
        try {
            //$log->info($xml);
        }catch(Exception $e) {
            echo $e->getMessage();
        }

    }
}


$server = new SoapServer("./wsdl/CasinoCoreWebService.xml");
$server->setClass('CoreIntegrationExposed');
$server->handle();



