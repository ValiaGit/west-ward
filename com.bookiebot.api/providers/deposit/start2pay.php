<?php


if(!defined("APP")) {
    die("No Access");
}


require_once SYSTEM_DIR."/main/Provider.php";

class start2pay extends Provider {


    private $commission = 2;
    private $provider_id;

    private $url = 'https://pay.start2pay.com';
    private $login = 'PRSTaenah4eiNiel';
    private $password = 'ahgooJ8pahfi';
    private $salt = 'choh7uPeiWuf5wiGh6Dou6SaiC0ahjoh';
    private $callback_sign = 'aegh3gigh6th';
    private $callback_login = 'CMPCMPOt3Ach6at';
    private $callback_password = 'xeengeiR4gaj';


    public function __construct()
    {
        global $config;

    }


    public function init($order_code,$amount,$user_data,$account_id,$security_code,$provider_id) {
        global $config, $db;

        $this->provider_id = $provider_id;


        $language = isset($_COOKIE['lang']) ? $_COOKIE['lang'] : "en";


        $email = $user_data['email'];
        $first_name = $user_data['first_name'];
        $last_name = $user_data['last_name'];

        $address = $user_data['address'];
        $country_name = $user_data['country_name'];
        $phone = $user_data['phone'];
        $currency_name = $user_data['currency_name'];
        $username = $user_data['username'];
        $city = $user_data['city'];

        $redirect_url = $config['base_href']."DummyResponses/apco/successful.php";
        $status_url = $config['apco_listener_url'];



        // check Min & Max amounts & currency Start

        $db->where('id',$this->provider_id);
        $provider_data = $db->getOne("money_providers","*");
        @$min_amount = json_decode($provider_data['min_amount'])->{$currency_name};
        @$max_amount = json_decode($provider_data['max_amount'])->{$currency_name};

        if ( !isset($min_amount) || !isset($max_amount) || !is_int($min_amount) || !is_int($max_amount) ) {
            return array("code" => 20,"msg"=>"Your currency ($currency_name) is not supported");
        } elseif ( $amount < $min_amount*100 ) {
            return array("code" => 801,"msg"=>"Minimum amount for this method is $min_amount $currency_name");
        } elseif ( $amount > $max_amount*100 ) {
            return array("code" => 801,"msg"=>"Maximum amount for this method is $max_amount $currency_name");
        }
        // check Min & Max amounts & currency End





        $xml_generation_params = array(
            "currency"=>$user_data['currency_code'],
            "language"=>$language,
            "orderReference"=>$order_code,
            "email"=>$email,
            "phone"=>$phone,
            "address"=>$address,
            "hasClientAccount"=>true,
            "udf1"=>"$first_name $last_name",
            "udf2"=>"$country_name $city",
            "udf3"=>"$username $currency_name",
            "redirectionURL"=>$redirect_url,
            "status_url"=>$status_url,
            "actionType"=>"1",
            "user_data"=>$user_data
        );


        $return = array();
        $return['code'] = 10;
        $return['has_fields'] = 1;
        $return['amount'] = $amount;

        $cut_amount = ceil($amount * ( 100 + ($this->commission) ) / 100);


        $return['cut_amount'] = $cut_amount;
        $return['commission'] = $cut_amount - $amount;
        $xml_generation_params['amount'] = $return['cut_amount'];


//        print_r($xml_generation_params);

        $encodedXml = urlencode(trim($this->generateXML($xml_generation_params)));



        $return['data'] = array(
            "params"=>$encodedXml,
            "action"=>$this->url
        );

        return $return;
    }


    /**
     *
     */
    private function generateXML($params) {


        $amount = $params['amount'];
        $currency = $params['currency'];
        $language = $params['language'];
        $orderReference = $params['orderReference'];
        $email = $params['email'];
        $address = $params['address'];
        $phone = $params['phone'];
        $fullname = $params['udf1'];
        $udf2 = $params['udf2'];
        $udf3 = $params['udf3'];
        $redirectionURL = $params['redirectionURL'];
        $status_url = $params['status_url'];
        $actionType = $params['actionType'];
        $user_data = $params['user_data'];

        switch ($this->provider_id) {
            case 11:
                $payment_method = "<ForcePayment>WEBMONEY</ForcePayment>";
                break;
            case 12:
                $payment_method = "<ForcePayment>ECOW</ForcePayment>";
                break;
            case 13:
                $payment_method = "<ForcePayment>NT</ForcePayment>";
                break;
            case 14:
                $payment_method = "<ForcePayment>QIWI</ForcePayment>";
                break;
            case 19:
                $payment_method = "<ForcePayment>SKRILL</ForcePayment>";
                break;
            default:
                $payment_method = "<HideCards />";

        }


        // build the XML for the transaction
        $transactionXmlString = "<Transaction hash=\"" . $this->secret . "\">";

            $transactionXmlString .= $payment_method;
            $transactionXmlString .= "<TESTCARD />";
            $transactionXmlString .= "<TEST />";
            $transactionXmlString .= "<ProfileID>" . $this->profile_id . "</ProfileID>";
            $transactionXmlString .= "<Value>" . ($amount/100) . "</Value>";
            $transactionXmlString .= "<Curr>" . $currency . "</Curr>";
            $transactionXmlString .= "<Lang>" . $language . "</Lang>";
            $transactionXmlString .= "<ORef>" . $orderReference . "</ORef>";
            $transactionXmlString .= "<UDF1>" . $fullname . "</UDF1>";
            $transactionXmlString .= "<UDF2>" . $udf2 . "</UDF2>";
            $transactionXmlString .= "<UDF3>" . $udf3 . "</UDF3>";

            $transactionXmlString .= "<ClientAcc>" . $user_data['userId'] . "</ClientAcc>";
            $transactionXmlString .= "<RegName>" . $fullname . "</RegName>";
            $transactionXmlString .= "<MobileNo>" . $phone . "</MobileNo>";
            $transactionXmlString .= "<Country>" . $user_data['country_iso3'] . "</Country>";


            $transactionXmlString .= "<RedirectionURL>" . $redirectionURL . "</RedirectionURL>";
            $transactionXmlString .= "<status_url>" . $status_url . "</status_url>";
            $transactionXmlString .= "<ActionType>" . $actionType . "</ActionType>";
            $transactionXmlString .= "<Email>" . $email . "</Email>";
            $transactionXmlString .= "<Address>" . $address . "</Address>";
            $transactionXmlString .= "<ListAllCards>ALL</ListAllCards>";
            $transactionXmlString .= "<noRetry>true</noRetry>";
            $transactionXmlString .= "<NewCard1Try>true</NewCard1Try>";
            $transactionXmlString .= "<CA>true</CA>";


        $transactionXmlString .= "</Transaction>";


//        echo $transactionXmlString;
        $asMD5 = md5($transactionXmlString);
        $final = str_replace($this->secret ,$asMD5,$transactionXmlString);

//var_export($final);
//die();

        return $final;





    }




}
