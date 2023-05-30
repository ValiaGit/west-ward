<?php


if(!defined("APP")) {
    die("No Access");
}


require_once SYSTEM_DIR."/main/Provider.php";

class apco extends Provider {




    private $profile_id;
    private $secret;
    private $commission = 2;
    private $url;
    private $provider_id;


    public function __construct()
    {
        global $config;

        $this->profile_id = $config['apco_profile'];
        $this->secret = $config['apco_secret'];
        $this->url = $config['apco_url'];

    }


    public function init($order_code,$cut_amount,$user_data,$account_id,$security_code = false,$provider_id) {
        global $config,$db;

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
        $status_url = $config['apco_listener_url']."?way=out";



        // check Min & Max amounts & currency Start
        $db->where('id',$this->provider_id);
        $provider_data = $db->getOne("money_providers","*");

        @$min_amount = json_decode($provider_data['min_amount'])->{$currency_name};
        @$max_amount = json_decode($provider_data['max_amount'])->{$currency_name};

        if ( !isset($min_amount) || !isset($max_amount) || !is_int($min_amount) || !is_int($max_amount) ) {
            return array("code" => 20,"msg"=>"Your currency ($currency_name) is not supported");
        } elseif ( $cut_amount < $min_amount*100 ) {
            return array("code" => 801,"msg"=>"Minimum withdraw amount for this method is $min_amount $currency_name");
        } elseif ( $cut_amount > $max_amount*100 ) {
            return array("code" => 801,"msg"=>"Maximum withdraw amount for this method is $max_amount $currency_name");
        }
        // check Min & Max amounts & currency End



        $db->where('id',$account_id);
        $PspId = $db->getOne("money_accounts","AccountReference");

        if(!$PspId) {
            return ['code'=>30,'msg'=>'Account PSP not found'];
        }

        $PspId = $PspId['AccountReference'];

        $xml_generation_params = array(
            "currency"=>$user_data['currency_code'],
            "language"=>$language,
            "orderReference"=>$order_code,
            "email"=>$email,
            "pspid"=>$PspId,
            "phone"=>$phone,
            "address"=>$address,
            "hasClientAccount"=>true,
            "udf1"=>"",
            "udf2"=>"",
            "udf3"=>"",
            "redirectionURL"=>$redirect_url,
            "status_url"=>$status_url,
            "actionType"=>"13",
            "user_data"=>$user_data
        );


        $return = array();
        //$return['has_fields'] = 0;
        //$return['cut_amount'] = $cut_amount;

        $amount = floor($cut_amount*( 1 - ($this->commission)/100 ));


        //$return['amount'] = $amount;
        //$return['commission'] = $cut_amount - $amount;


        $db->where("transaction_unique_id", $order_code);
        $update_transaction = $db->update("money_transactions", array(
            "cut_amount" => $amount,
            "commission" => $cut_amount - $amount,
        ));

        if ( !$update_transaction ){
            $return['code'] = 20;
            $return['status'] = 0;
            $return['msg'] = $db->getLastError();

            return $return;
        }


        $xml_generation_params['amount'] = $amount;



        // check transaction status in database
        $db->where('transaction_unique_id',$order_code);
        $transaction = $db->getOne("money_transactions","status");

        if ( isset( $transaction['status'] ) && $transaction['status'] == 0 ) {
            $return['code'] = 10;
            $return['status'] = 1;
            $return['msg'] = 'Successfull Transaction';



            $encodedXml = urlencode(trim($this->generateXML($xml_generation_params)));
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$this->url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "params=$encodedXml");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $server_output = curl_exec ($ch);
            global $log;
            $log->info($server_output,$transaction);
            curl_close ($ch);

            //Update Transaction As completely Withdrawn
            $db->where("transaction_unique_id", $order_code);
            $update_transaction = $db->update("money_transactions", array(
                "status" => 1
            ));


        } elseif( isset( $transaction['status'] ) && $transaction['status'] == 1 ) {
            $return['code'] = 20;
            $return['status'] = $transaction['status'];
            $return['msg'] = 'Transaction Already Processed';
        } else {
            $return['code'] = 20;
            $return['status'] = 0;
            $return['msg'] = 'Unknow Status';
        }


        return $return;
    } // function init()


    /**
     *
     */
    private function generateXML($params) {
        global $config;


        $amount = $params['amount'];
        $pspid = $params['pspid'];
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
            case 15:
                $payment_method = "<ForcePayment>WEBMONEY</ForcePayment>";
                break;
            case 16:
                $payment_method = "<ForcePayment>ECOW</ForcePayment>";
                break;
            case 17:
                $payment_method = "<ForcePayment>NT</ForcePayment>";
                $redirectionURL = $config['base_href']."DummyResponses/apco/success-".$orderReference.".php";
                break;
            case 18:
                $payment_method = "<ForcePayment>QIWI</ForcePayment>";
                break;
            case 20:
                $payment_method = "<ForcePayment>SKRILL</ForcePayment>";
                break;
            default:
                $payment_method = "";

        }



        // build the XML for the transaction
        $transactionXmlString = "<Transaction hash=\"" . $this->secret . "\">";

            $transactionXmlString .= $payment_method;
//            $transactionXmlString .= "<TESTCARD />";
//            $transactionXmlString .= "<TEST />";

            $transactionXmlString .= "<ProfileID>" . $this->profile_id . "</ProfileID>";
            $transactionXmlString .= "<Value>" . ($amount/100) . "</Value>";
            $transactionXmlString .= "<Curr>" . $currency . "</Curr>";
            $transactionXmlString .= "<Lang>" . $language . "</Lang>";
            $transactionXmlString .= "<ORef>" . $orderReference . "</ORef>";
            $transactionXmlString .= "<UDF1>" . $fullname . "</UDF1>";
            $transactionXmlString .= "<UDF2>" . $udf2 . "</UDF2>";
            $transactionXmlString .= "<UDF3>" . $udf3 . "</UDF3>";

            $transactionXmlString .= "<PspID>" . $pspid . "</PspID>";
//            $transactionXmlString .= "<ForcePayment>VISA</ForcePayment>";


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


        return $final;





    }




}
