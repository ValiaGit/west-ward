<?php

if(!defined('APP')) {
    die();
}

class _Smssender extends Service {

    public function send($phone,$MessageText) {
        global $config;

        $phone = ltrim ($phone, '+');
        //Send SMS
        $curl = curl_init("http://api.clickatell.com/http/sendmsg?user=$config[sms_user]&password=$config[sms_pass]&api_id=$config[sms_api]&to=$phone&text=$MessageText");
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        return $response;
    }
}