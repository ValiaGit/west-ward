<?php


if(!defined('APP')) {
    die();
}

class Pay extends Controller {


    function __construct() {

    }

    /**
     *
     */
    public function success() {
        echo "success";
    }

    /**
     *
     */
    public function error() {
        echo "error";
    }

    /**
     *
     */
    public function cancel() {
        echo "cancel";
    }


    /**
     *
     */
    public function callback() {
        echo "callback";
    }


}



?>