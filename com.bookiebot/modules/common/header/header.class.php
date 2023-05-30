<?php
if (!defined("APP")) {
    die("No Access!");
}





class header extends Module {


    public function init() {
        global $config;
        global $needs_authentication;

        //Data Sent to module template
        $data = array();

        $data['sault'] = sha1(strrev(session_id()).$config['api_sault']);
        $data['needs_authentication'] = $needs_authentication;
        $uri = $_SERVER['REQUEST_URI'];
        $data['request_uri'] = $uri;


        return $this->output($data,"",true);
    }

}

