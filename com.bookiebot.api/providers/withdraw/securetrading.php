<?php


if (!defined("APP")) {
    die("No Access");
}


require_once SYSTEM_DIR."/main/Provider.php";


class securetrading extends Provider
{


    private $service_url;
    private $username;
    private $password;
    private $site_reference;

    private $commission = 2;

    private $withdraw_request_xml = <<<XML
<requestblock version="3.67">
 <alias>{username}</alias>
     <request type="REFUND">
       <merchant>
            <orderreference>{order_id}</orderreference>
        </merchant>
    <billing>
        <amount currencycode="EUR">{amount}</amount>
    </billing>
     <operation>
         <sitereference>{reference}</sitereference>
         <accounttypedescription>CFT</accounttypedescription>
         <parenttransactionreference>{AccountReference}</parenttransactionreference>
     </operation>
     </request>
</requestblock>
XML;


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
     * Start Transaction
     */
    public function init($order_code, $amount, $user_data, $account_id)
    {


        $account_id = (int)$account_id;
        if (!$account_id) {
            return array("code" => -11, "msg" => "Please chose credit card!");
        }



        //Get Account Reference To Make Transaction
        $user_id = $user_data['userId'];
        $account_reference = $this->getAccountReference($user_id, $account_id);
        if ($account_reference['code'] == 10) {

            $xml_to_send = $this->withdraw_request_xml;

            //Check Card In ST System
            $xml_to_send = str_replace("{order_id}",$order_code,$xml_to_send);
            $xml_to_send = str_replace("{username}",$this->username,$xml_to_send);
            $xml_to_send = str_replace("{reference}",$this->site_reference,$xml_to_send);
            $xml_to_send = str_replace("{AccountReference}",$account_reference['data'],$xml_to_send);




            $base_amount = floor($amount*(100 - ($this->commission))/100);

            $xml_to_send = str_replace("{amount}",($base_amount),$xml_to_send);


            //Call Withdrawal Service

            $response = $this->_callSecureTradingService($xml_to_send);

            $return = $this->_xml2array(simplexml_load_string($response), array());


            $return['user_id'] = $user_id;
            $return['order_code'] = $order_code;
            $return['account_id'] = $account_id;

            return $this->_handleTransactionResponse($return);

        }
        else {
            return array("code" => 50);
        }

    }

    /**
     * @param $TransactionData
     * @return array
     */
    private function _handleTransactionResponse($TransactionData)
    {

        $return = array();
        if(!isset($TransactionData['response'])) {
            $return['code'] = 20;
            $return['status'] = 3;
            return $return;
        }

        //Response
        $TransactionResponse = $TransactionData['response'];


//        print_r($TransactionResponse);

        if($TransactionResponse['error']['code']!="0") {
            $return['code'] = 20;
            $return['status'] = 3;
            $return['error_message'] = $TransactionResponse['error']['message'];
            $return['error_code'] = $TransactionResponse['error']['code'];
            return $return;
        }

        //Order Code And Transaction Reference
        $account_id = $TransactionData['account_id'];
        $order_code = $TransactionData['order_code'];
        $user_id = $TransactionData['user_id'];


        $transaction_reference = $TransactionResponse['transactionreference'];
        $timestamp = $TransactionResponse['timestamp'];


        $settlement = @$TransactionResponse['settlement'];
        $settle_status = isset($settlement['settlestatus'])?$settlement['settlestatus']:-1;


        $billing = $TransactionResponse['billing'];
        $amount = (int)$billing['amount'];


//        print_r($TransactionResponse);

        $error = $TransactionResponse['error'];
        $error_code = $error['code'];


        /**
         * If Transaction Was Successfull
         */

            $db = $this->db;
            $db->where("core_users_id", $user_id);
            $db->where("transaction_unique_id", $order_code);
            $transaction = $db->get("money_transactions", null, "id,amount");
            if (count($transaction)) {
                $transaction = $transaction[0];


                //If Provided Amount Was Different Than Saved
                if ((int)$amount != floor($transaction['amount']*(100- ($this->commission))/100)) {
                    $return['code'] = 50;
                    $return['msg'] = "Request Was Wrong!";
                } //If Provided And Saved Amount Are Same
                else {
                    if($settle_status == 0) {

                        $return['code'] = 10;
                        $return['bank_transaction_id'] = $transaction_reference;
                        $return['bank_transaction_date'] = $timestamp;


                        $return['amount'] = $transaction['amount'];
                        $cut_amount = $transaction['amount']*(100 - ($this->commission))/100;
                        $return['cut_amount'] = $cut_amount;

                        $return['commission'] = $transaction['amount'] - $cut_amount;

                        $return['status'] = 1;
                        $return['bank_status'] = $settle_status;
                        $return['error_code'] = 0;

                    } else {
                        $return['code'] = 20;
                    }
                }
            } else {
                $return['code'] = 109;
            }


            return $return;



    }

    /**
     * @param $user_id
     * @param $account_id
     * @return array
     */
    private function getAccountReference($user_id, $account_id)
    {
        $db = $this->db;
        $account_id = (int)$account_id;
        $user_id = (int)$user_id;
        if (!$account_id || !$user_id) {
            return array("code" => 20);
        }

        $db->where("core_users_id", $user_id);
        $db->where("id", $account_id);

        $data = $db->getOne("money_accounts", "AccountReference");
        if (count($data)) {
            return array("code" => 10, "data" => $data['AccountReference']);
        } else {
            return array("code" => 60);
        }

    }

    /**
     * @param $xml_data
     * @return string
     */
    private function _callSecureTradingService($xml_data)
    {
        $username = $this->username;
        $password = $this->password;
        $access_token = base64_encode($username . ":" . $password);




        try {
            $crl = curl_init($this->service_url);

            $header = array();
            $header[] = 'Content-type: text/xml;charset=utf-8';
            $header[] = 'Accept: text/xml';
            $header[] = 'Accept-Encoding: gzip';
            $header[] = 'Content-Length: ' . strlen($xml_data);
            $header[] = 'Authorization: Basic ' . $access_token;

            curl_setopt($crl, CURLOPT_HTTPHEADER, $header);
            curl_setopt($crl, CURLOPT_POST, true);
            curl_setopt($crl, CURLOPT_POSTFIELDS, $xml_data);
            curl_setopt($crl, CURLOPT_HEADER, false);
            curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
//            curl_setopt($crl, CURLOPT_FOLLOWLOCATION, true);

            if (!function_exists("gzdecode")) {
                function gzdecode($data)
                {
                    return gzinflate(substr($data, 10, -8));
                }
            }

            $rest = curl_exec($crl);
            curl_close($crl);
            $response = gzdecode($rest);
        } catch (Exception $e) {
            $response = array("code" => -1102);
        }
        return $response;

    }


    /**
     * Just Converts XML TO Array
     * @param $xmlObject
     * @param array $out
     * @return array
     */
    private function _xml2array($xmlObject, $out = array())
    {
        foreach ((array)$xmlObject as $index => $node)
            $out[$index] = (is_object($node)) ? $this->_xml2array($node) : $node;

        return $out;
    }


}
