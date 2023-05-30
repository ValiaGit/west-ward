<?php

if (!defined('APP')) {
    die();
}


class Cards extends Service
{

    private $service_url;
    private $username;
    private $password;
    private $site_reference;

    private $add_card_xml_template = <<<HEREDOC
<?xml version="1.0" encoding="utf-8"?>
        <requestblock version="3.67">
            <alias>{username}</alias>
            <request type="STORE">
                <merchant>
                    <orderreference>{order_reference}</orderreference>
                </merchant>
                <operation>
                    <sitereference>{site_reference}</sitereference>
                    <accounttypedescription>CARDSTORE</accounttypedescription>
                </operation>
                <billing>
                    <town>{town}</town>
                    <street>{address}</street>
                    <county>{country}</county>
                    <country>{country_iso_2}</country>
                    <postcode>{post_code}</postcode>
                    <email>{email}</email>
                    <telephone type="M">{phone}</telephone>
                    <payment type="{card_type}">
                        <pan>{card_number}</pan>
                        <expirydate>{exp_month}/{exp_year}</expirydate>
                    </payment>
                    <name>
                        <first>{first_name}</first>
                        <last>{last_name}</last>
                    </name>
                </billing>
            </request>
        </requestblock>
HEREDOC;

    function __construct()
    {

        parent::__construct();
        global $config;

        $this->username = $config['s_trading_user'];
        $this->password = $config['s_trading_password'];
        $this->site_reference = $config['s_trading_account'];
        $this->service_url = $config['s_trading_url'];
    }


    /**
     * Add New Card To Users Account
     * @param $card_type - 1 Credit/DebitCard, 2 - Personal Account
     * @param $card_number
     * @param $expiry_month
     * @param $expiry_year
     * @return array|mixed
     */
    public function addCard($provider_id, $card_type,$card_number,$expiry_month,$expiry_year)
    {
        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];


            if(!$card_number || $card_number == "") {
                return array("code"=>40,"msg"=>"Please specify Card Number");
            }


            $user_data = $this->loadService("user/settings")->getUserInfo();
            if($user_data['code'] == 10) {
                $user_data = $user_data['data'];
            }

            $rand_order_reference = sha1(strrev(time()));

            $xml_to_send = $this->add_card_xml_template;
            $xml_to_send = str_replace("{order_reference}",$rand_order_reference,$xml_to_send);
            $xml_to_send = str_replace("{site_reference}",$this->site_reference,$xml_to_send);
            $xml_to_send = str_replace("{username}",$this->username,$xml_to_send);
            $xml_to_send = str_replace("{town}",$user_data['city'],$xml_to_send);
            $xml_to_send = str_replace("{address}",$user_data['address'],$xml_to_send);
            $xml_to_send = str_replace("{country}",$user_data['country_name'],$xml_to_send);
            $xml_to_send = str_replace("{country_iso_2}",$user_data['country_iso'],$xml_to_send);
            $xml_to_send = str_replace("{post_code}",$user_data['address_zip_code'],$xml_to_send);
            $xml_to_send = str_replace("{email}",$user_data['email'],$xml_to_send);
            $xml_to_send = str_replace("{phone}",$user_data['phone'],$xml_to_send);
            $xml_to_send = str_replace("{card_type}",$card_type,$xml_to_send);
            $xml_to_send = str_replace("{card_number}",$card_number,$xml_to_send);
            $xml_to_send = str_replace("{exp_month}",$expiry_month,$xml_to_send);
            $xml_to_send = str_replace("{exp_year}",$expiry_year,$xml_to_send);
            $xml_to_send = str_replace("{first_name}",$user_data['first_name'],$xml_to_send);
            $xml_to_send = str_replace("{last_name}",$user_data['last_name'],$xml_to_send);

//            var_export($user_data);
            $response = $this->_callSecureTradingService($xml_to_send);
            //var_export($response);
            //print_r($response);
            $return = $this->_xml2array(simplexml_load_string($response),array());
            $return['card_type'] = $card_type;
            $return['provider_id'] = $provider_id;
            $return['payee'] = $user_data['first_name']." ".$user_data['last_name'];
            return $this->_handleSecureTradingCardAddResponse($user_id,$return);

        }

        //If User Is Out
        else {
            return array("code"=>40);
        }
    }


    /**
     * @param $card_id
     * @return array
     */
    public function deleteCard($account_id) {
        $account_id = (int)$account_id;
        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            $db = $this->db;
            $db->where("core_users_id",$user_id);
            $db->where("id",$account_id);
            $delete = $db->update("money_accounts",array("IsDeleted"=>1));
            if($delete!==false) {
                return array("code"=>10);
            } else {
                echo $db->getLastError();
                return array("code"=>30);
            }

        } else {
            return array("code"=>20);
        }
    }


    /**
     * @return array
     */
    public function getMyCardAccounts($all = false,$provider_id = false) {

        $user_data = $this->checkUserAccess();

        if ($user_data) {
            $user_id = $user_data['id'];
            $cls = " AND accounts.account_type = 1 ";
            if($all) {
                $cls = "";
            }

            $db = $this->db;

            if($provider_id) {
                $cls .= " AND money_providers_id=$provider_id " ;
            }
            ini_set('display_errors',1);
            $qs = "
                                    SELECT
                                      accounts.id as account_id,
                                      accounts.AddDate,
                                      accounts.Type,
                                      accounts.Pan,
                                      accounts.money_providers_id,



                                      accounts.account_type,
                                      accounts.BankName,
                                      accounts.BankAccount,
                                      accounts.Payee,
                                      accounts.BankCode,
                                      accounts.SwiftCode,
                                      accounts.ConfirmationStatus,


                                      left_money.amount as active_amount
                                    FROM
                                      money_accounts accounts
                                    
                                      
                                      LEFT JOIN
                                      money_user_deposits_left_in_system left_money
                                      ON
                                      left_money.money_accounts_id = accounts.id
                                      
                                      
                                      
                                    WHERE
                                    accounts.core_users_id = $user_id
                                    AND
                                    accounts.IsDeleted = 0
                                    $cls
                                    ORDER BY id DESC
                                ";

//            echo $qs;
            $data = $db->rawQuery($qs);

            if(count($data)) {
                return array("code"=>10,"data"=>$data);
            } else {
                return array("code"=>60);
            }

        } else {
            return array("code"=>20);
        }
    }


    /**
     * This method Saves Card In Database
     * @param $response_array
     * @return mixed
     */
    private function _handleSecureTradingCardAddResponse($user_id, $response_array) {


        //Response node
        $response = $response_array['response'];
        if($response['error']['code']!=0) {
            return array("code"=>20,"msg"=>$response['error']['message']);
        }


        $merchant = $response['merchant'];


        /**
         * Actual Card Details
         */
        $billing = $response['billing'];
        $payment = $billing['payment'];

        $request_reference = $response_array['requestreference'];
        $order_reference = $merchant['orderreference'];
        $transaction_reference = $response['transactionreference'];
        $issuer_country = $payment['issuercountry'];
        $pan = $payment['pan'];
        $active = $payment['active'];
        $timestamp = $response['timestamp'];
        $card_type = $response_array['card_type'];
        $provider_id = $response_array['provider_id'];
        $payee = $response_array['payee'];

        $db = $this->db;

        $insert_array = array(
            "AccountReference"=>$transaction_reference,
            "OrderReference"=>$order_reference,
            "RequestReference"=>$request_reference,
            "IssuerCountry"=>$issuer_country,
            "Pan"=>$pan,
            "Active"=>$active,
            "Payee"=>$payee,
            "core_users_id"=>$user_id,
            "money_providers_id"=>$provider_id,
            "account_type"=>1,
            "Type"=>$card_type //Card
        );

//        print_r($insert_array);
        $insert_id = $db->insert("money_accounts",$insert_array);
        if($insert_id) {
            return array("code"=>10);
        } else {
            ECHO $db->getLastError();
            return array("code"=>30);
        }
    }



    /**
     * @param $xml_data
     * @return string
     */
    private function _callSecureTradingService($xml_data) {


        $username = $this->username;
        $password = $this->password;
        $access_token = base64_encode($username.":".$password);

        try {
            $crl = curl_init($this->service_url);

            $header = array();
            $header[] = 'Content-type: text/xml;charset=utf-8';
            $header[] = 'Accept: text/xml';
            $header[] = 'Accept-Encoding: gzip';
            $header[] = 'Content-Length: '.strlen($xml_data);
            $header[] = 'Authorization: Basic '.$access_token;

            curl_setopt($crl, CURLOPT_HTTPHEADER,$header);
            curl_setopt($crl, CURLOPT_POST,true);
            curl_setopt($crl, CURLOPT_POSTFIELDS,  $xml_data);
            curl_setopt($crl, CURLOPT_HEADER, false);
            curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
//            curl_setopt($crl, CURLOPT_FOLLOWLOCATION, true);

            if(!function_exists("gzdecode")) {
                function gzdecode($data)
                {
                    return gzinflate(substr($data,10,-8));
                }
            }


            $rest = curl_exec($crl);
            curl_close($crl);
            $response = gzdecode($rest);

        }catch(Exception $e) {
            $response = array("code"=>-1102);
        }
        return $response;

    }



    /**
     * Just Converts XML TO Array
     * @param $xmlObject
     * @param array $out
     * @return array
     */
    private function _xml2array( $xmlObject, $out = array () )
    {
        foreach ( (array) $xmlObject as $index => $node )
            $out[$index] = ( is_object ( $node ) ) ? $this->_xml2array ( $node ) : $node;

        return $out;
    }


}