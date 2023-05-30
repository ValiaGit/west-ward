<?php


if(!defined("APP")) {
    die("No Access");
}


require_once SYSTEM_DIR."/main/Provider.php";

class securetradingpages extends Provider {



    private $service_url;
    private $username;
    private $password;
    private $site_reference;


    private $commission = 2;


    function __construct()
    {
        parent::__construct();

        global $config;
        $this->username = $config['s_trading_user'];
        $this->password = $config['s_trading_password'];
        $this->site_reference = $config['s_trading_account'];
        $this->service_url = $config['s_trading_url'];

    }





    public function init($order_code,$amount,$user_data,$account_id,$security_code,$provider_id) {
        global $config;

        $return = array();
        $return['code'] = 10;
        $return['has_fields'] = 1;
        $return['amount'] = $amount;

        $cut_amount = $amount * ( 100+ ($this->commission) ) /100;
        $return['cut_amount'] = $cut_amount;
        $return['commission'] = $cut_amount - $amount;

        $return['data'] = array(
            "sitereference"=>$this->site_reference,
            "stprofile"=>"default",
            "currencyiso3a"=>"EUR",
            "mainamount"=>$cut_amount/100,
            "version"=>2,
            "orderreference"=>$order_code,
            "stdefaultprofile"=>"st_cardonly",
            "ruleidentifier"=>'STR-10',
            "allurlnotification"=>$config['s_trading_payment_page_notification_url']
        );



        $return['data']['sitesecurity'] = $this->calcHash($return['data']);



        $return ['data']['action'] = $config['s_trading_payment_page_url'];

        return $return;
    }



    private function calcHash($params) {
        global $config;

        $final = "";
        foreach($params as $param) {
            $final.=$param;
        }

        $final.=$config['s_trading_notification_password'];

        return "g".hash('sha256', $final);


    }



}
