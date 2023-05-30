<?php


if(!defined("APP")) {
    die("No Access!");
}



class Email extends Controller {


    public function init() {


        if(!isset($_GET['stringParam'])) {
            Action::redirect("");
        }
        $code = $_GET['stringParam'];
        $token = $_COOKIE['token'];

        $service_response = $this->callServiceMethod("user.session","confirmEmail",array(
            "code"=>$code,
            "token"=>$token
        ));



        print_r($service_response);
        echo $code;
        return "";

        $session_service = $this->loadApiService("user.session");
        $confirmed = $session_service->confirmEmail($code);

        //If Confirmation Was Successful
        if($confirmed['code'] == 10) {
            Action::redirect("#email_confirmation_success");
        } else {
            Action::redirect("#wrong_email_confirmation_code");
        }
//        echo $this->render("confirmations/email.tpl",$data);
    }


}

