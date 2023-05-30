<?php

require("../SystemIncludes.php");

//Commission Percent
$commission = 2;



$handler = fopen('/var/www/app/public/PaymentGateway/Deposit/SecureTrading/NewRequests.log', 'a+');

$req_dump = print_r($_REQUEST, TRUE);

fwrite($handler, "\n========================================Requesd Request Start \n");
fwrite($handler, date("d/m/Y h:i:s")."\n");
fwrite($handler, $req_dump);


/**
 *
 */
if(isset($_REQUEST['responsesitesecurity'])) {


    /**
     * Handle Hash
     */


    $excluded = array("notificationreference","responsesitesecurity");
    $string_for_hash = "";
    foreach($_REQUEST as $index=>$value) {
        if(!in_array($index,$excluded)) {
            $string_for_hash.=$value;
        }
    }
    $string_for_hash.=$config['s_trading_notification_password'];
    $hash = hash('sha256', $string_for_hash);


    /**
     * Send Appropriate Codes
     */
    if($hash == $_REQUEST['responsesitesecurity']) {
        fwrite($handler, "Hash Correct\n");

        fwrite($handler, "Initilised Database Connection\n");

        $errorcode = $_REQUEST['errorcode'];
        $baseamount = $_REQUEST['baseamount'];
        $customeremail = $_REQUEST['customeremail'];

        $customerip = ip2long($_REQUEST['customerip']);


        $customerpremise = $_REQUEST['customerpremise'];
        $customertelephone = $_REQUEST['customertelephone'];
        $transactionreference = $_REQUEST['transactionreference'];
        $transactionstartedtimestamp = $_REQUEST['transactionstartedtimestamp'];
        $status = $_REQUEST['status'];

        fwrite($handler, "Order Reference Not Escapedd Value:".$_REQUEST['orderreference']."\n");

        $orderreference = $_REQUEST['orderreference'];

        if(!$orderreference) {
            fwrite($handler, "Order Reference Not Found: Value:$orderreference\n");
            header("HTTP/1.0 403 Permission Denied");
            echo "HTTP/1.0 403 Permission Denied";
            die();
        }

        $settlestatus = (int)$_REQUEST['settlestatus'];

        //If Transaction Was Successfull
        if($errorcode == 0) {

            fwrite($handler, "Was Success from secure\n");



            try {

                $db->where("transaction_unique_id",$_REQUEST['orderreference']);
                $transaction = $db->getOne("money_transactions","id,ip,amount,core_users_id,cut_amount");



                if(!count($transaction)) {
                    fwrite($handler, "Transaction Reference Not Found\n");
                    header("HTTP/1.0 403 Permission Denied");
                    echo "HTTP/1.0 403 Permission Denied";
                    die();
                }


                fwrite($handler, "Transaction Details: ".json_encode($transaction)." \n");


                $calculated_amount = ceil($transaction["amount"]*($commission+100)/100);

                if($calculated_amount != $baseamount) {

                    fwrite($handler, "No Base Amount Match: Calculated=$calculated_amount,Base=$baseamount \n");
                    header("HTTP/1.0 403 Permission Denied");
                    echo "HTTP/1.0 403 Permission Denied";
                    die();
                }

                else {
                    //If Transaction Was Settled Successfully
                    if($settlestatus == 0) {

                        fwrite($handler, "Settled as succwssfull\n");
                        fwrite($handler, "$customerip -- $transaction[ip]\n");


                        //If Provided Ip Is Associated With Saved IP
                        if($customerip == $transaction['ip']) {
                            fwrite($handler, "Ip is good  sent Ok To Secure Trading\n");

                            header("HTTP/1.0 200 OK");
                            echo "HTTP/1.0 200 OK";


                            try {
                                $db->where("id",$transaction['id']);
                                $update_transaction = $db->update("money_transactions",array(
                                    "status"=>1,
                                    "bank_transaction_id"=>@$transactionreference,
                                    "bank_transaction_date"=>@$transactionstartedtimestamp,
                                    "bank_status"=>$settlestatus
                                ));
                                fwrite($handler, "Trsansaction Status Was Updated Succesfully");
                            }catch(Exception $e) {
                                fwrite($handler, $e->getMessage());
                            }

                            die();

                        }

                        else {

                            fwrite($handler, "Ip Error Was Fired, $customerip - $transaction[ip]\n");
                            $db->where("transaction_unique_id",$orderreference);
                            $transaction = $db->update("money_transactions",array("status"=>-23));
                            header("HTTP/1.0 403 Permission Denied");
                            echo "HTTP/1.0 403 Permission Denied";
                            die();
                        }



                    }

                    else {

                        fwrite($handler, "Settle Status: $settlestatus\n");
                        $db->where("transaction_unique_id",$orderreference);
                        $transaction = $db->update("money_transactions",array("status"=>$settlestatus));//TODO wRONG sTATUS aSSIGNMENT
                        header("HTTP/1.0 403 Permission Denied");
                        echo "HTTP/1.0 403 Permission Denied";
                        die();
                    }


                }
            }catch(Exception $e) {
                header("HTTP/1.0 403 Permission Denied");
                echo "HTTP/1.0 403 Permission Denied";
                fwrite($handler, $e->getMessage()."Exception\n");
                die();
            }







        }
        //If Transaction Failed
        else {
            fwrite($handler, "Secure trading got error\n");
            $db->where("transaction_unique_id",$orderreference);
            $transaction = $db->update("money_transactions",array("status"=>$settlestatus));
            header("HTTP/1.0 403 Permission Denied");
            echo "HTTP/1.0 403 Permission Denied";
            die();
        }



    }

    else {
        fwrite($handler, "HTTP/1.0 403 Permission Denied - Wrong Hash");
        header("HTTP/1.0 403 Permission Denied");
        echo "HTTP/1.0 403 Permission Denied";
        die();
    }


    fwrite($handler, "EndOf");
    fclose($handler);
}

else {
    header("HTTP/1.0 403 Permission Denied");
    echo "HTTP/1.0 403 Permission Denied";
}

//fwrite($handler, "Last");
