<?php
if(!defined('APP')) {
    die();
}

abstract class Provider {
    function __construct() {
        global $db;
        global $langPackage;
        $this->db = $db;
        $this->lang = $langPackage;
    }
}