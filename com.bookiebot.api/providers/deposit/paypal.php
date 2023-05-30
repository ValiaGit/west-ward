<?php


if(!defined("APP")) {
    die("No Access");
}


class paypal {


    private $sitereference = "test_westward59230";
    private $currencyiso3a = "USD";
    private $version = 1;



    /**
     * Start Transaction
     */
    public function init($order_code,$amount,$user_data) {

        //Amount Divided On Hundred
        $amount/=100;




        return array(
            "code"=>10,
            "has_fields"=>1,
            "data"=>array(
                "action"=>"https://payments.securetrading.net/process/payments/choice",
                "sitereference"=>$this->sitereference,
                "currencyiso3a"=>$this->currencyiso3a,
                "currencyiso3a"=>$this->currencyiso3a,
                "customerfirstname"=>$user_data['first_name'],
                "customerlastname"=>$user_data['last_name'],
                "customerpremise"=>$user_data['userId'],
                "customercountry"=>$user_data['cId'],
                "customeremail"=>$user_data['email'],
                "customerip"=>IP,
                "customerstreet"=>$user_data['address'],
                "customertelephone"=>$user_data['phone'],
                "version"=>$this->version,
                "mainamount"=>$amount,
                "orderreference"=>$order_code,
                "childcss"=>"childcss",
                "customeraccountnumbertype"=>"ACCOUNT",
                "customeraccountnumber"=>$user_data['userId']
            )
        );

    }


}