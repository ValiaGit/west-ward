<?php

///usr/local/bin/php -f /home/waywardl/domains/wayward.la/public_html/bets/API/betradar.php >/dev/null 2>&1
session_start();
session_set_cookie_params(3600,"/","",true,true);
date_default_timezone_set('Europe/Malta');

define("APP",true);

ini_set("display_errors",1);


define("ROOT_DIR",substr(dirname(__FILE__),0,-4));


//API Exposed Services DIR
define("SERVICE_DIR",ROOT_DIR."/services/");


//Base API Classes
require_once ROOT_DIR."system/startup.php";
require_once ROOT_DIR."vendor/autoload.php";





$db = new MysqliDb($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);


//Check Time And Adjust Balances
$getAllUsers = $db->get('core_users',null,'id,balance');


if(date('H') == "00") {
    if(date('i') < 5) {
        foreach($getAllUsers as $user) {
            $id = $user['id'];
            $balance = $user['balance'];
            $datestring = date('d/m/Y');

            $db->where('core_users_id',$id);
            $db->where('datestring',$datestring);
            $exists = $db->getOne('core_daily_balance_snapshots','1');
            if(!$exists) {

                $insert_data = array(
                    'core_users_id'=>$id,
                    'balance'=>$balance,
                    'datestring'=>$datestring
                );

                $inserted = $db->insert('core_daily_balance_snapshots',$insert_data);
                if($inserted) {
                    var_export($inserted);
                    echo "<hr />";
                }

            }



        }

    }
}

//$_GET['data'] = "tree";
//require('adjarabet.php');
//
//
//$_GET['data'] = "match";
//require('adjarabet.php');



$api = new API;
$api->process();


$ch = curl_init("http://shako.info");
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_exec($ch);
curl_close($ch);



