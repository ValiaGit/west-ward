<?php

/*
 8 - 10 => Apco,
 11-15  => Webmoney,
 12-16  => ecoPayz,
 13-17  => Netteler,
 14-18  => Qiwi,
 19-20  => Skrill

*/


require("../SystemIncludes.php");

/* Merchant Account Settings */
$profileID =        $config['apco_profile'];
$secretWord =       $config['apco_secret'];
$merchantCode =     $config['apco_mCode'];
$merchantPassword = $config['apco_mPass'];

//URL of the APCO tool to be used in the listener to compare responses and validate if the result is correct
$wsdl = "https://www.apsp.biz:9085/merchantTools.asmx?WSDL";

ini_set("display_errors",1);


//global $payment_logger;
//$payment_logger->info("Received Request On Apco Listener");
//$payment_logger->info($_REQUEST);


$path = __DIR__ . '/logs/listen.txt';
$req_dump = print_r($_REQUEST, TRUE);

$file = @fopen($path, 'a+');
@fwrite($file, $req_dump);
@fwrite($file, "\n -------------------- \n");



/**
 * Compare the XmlResponse from FastPay with the Transaction Information to make sure that it matches
 * @param type $xmlResponse the response given from the FastPay in DomDocument Format
 * @throws Exception
 */

function validateResponseWithTool($xmlFastPayResponse) {
    //global $payment_logger;

    try {

        //Retrieve the values from the XML response of FASTPAY
        $node = $xmlFastPayResponse->getElementsByTagName('ORef');
        $fastPayOref = "";
        foreach ($node as $node) {
            $fastPayOref = $node->textContent;
        }
        $node = $xmlFastPayResponse->getElementsByTagName('Value');
        $fastPayAmount = "";
        foreach ($node as $node) {
            $fastPayAmount_evil = $node->textContent;
            $fastPayAmount = number_format((float) $node->textContent, 2);
        }
        $node = $xmlFastPayResponse->getElementsByTagName('pspid');
        $fastPayPspID = "";
        foreach ($node as $node) {
            $fastPayPspID = $node->textContent;
        }

        $node = $xmlFastPayResponse->getElementsByTagName('CardNum');
        $accountCard = "";
        foreach ($node as $node) {
            $accountCard = $node->textContent;
        }

        $node = $xmlFastPayResponse->getElementsByTagName('CardType');
        $accountCardType = "";
        foreach ($node as $node) {
            $accountCardType = $node->textContent;
        }

        $node = $xmlFastPayResponse->getElementsByTagName('CardHName');
        $accountCardName = "";
        foreach ($node as $node) {
            $accountCardName = $node->textContent;
        }

        $node = $xmlFastPayResponse->getElementsByTagName('PaymentID');
        $PaymentID = "";
        foreach ($node as $node) {
            $PaymentID = $node->textContent;
        }

        //echo "   $PaymentID   ";

		//var_export($fastPayOref);
		//var_export($fastPayAmount);
		//var_export($cardNum);
		//die('died');



        //CONNECT WITH THE TOOL AND RETRIEVE THE LAST TRANSACTION
        $client = new SoapClient($GLOBALS['wsdl'], array("trace" => 0, "exception" => 0));
        $soapResult = $client->getTransactionsByORef(array(
            "MCHCode" => $GLOBALS['merchantCode'], "MCHPass" => $GLOBALS['merchantPassword'], "Oref" => $fastPayOref));

        $xmlToolResponse = new DOMDocument();
        $xmlToolResponse->loadXML($soapResult->getTransactionsByORefResult->any);

        $node = $xmlToolResponse->getElementsByTagName('OrderRef');
        $toolOref = "";
        foreach ($node as $node) {
            $toolOref = $node->textContent;
        }
        $node = $xmlToolResponse->getElementsByTagName('PSPID');
        $toolPspID = "";
        foreach ($node as $node) {
            $toolPspID = $node->textContent;
        }
        $node = $xmlToolResponse->getElementsByTagName('Amount');
        $toolAmount = "";
        foreach ($node as $node) {
            $toolAmount = number_format((float) $node->textContent, 2);
        }

        $node = $xmlToolResponse->getElementsByTagName('CardHname');
        $toolCardHolder = "";
        foreach ($node as $node) {
            $toolCardHolder = $node->textContent;
        }

        $node = $xmlToolResponse->getElementsByTagName('CardNum');
        $toolCardNum = "";
        foreach ($node as $node) {
            $toolCardNum = $node->textContent;
        }
        $toolCardNum = str_replace("***", ",", $toolCardNum);


        //COMPARE THE RESULTS OF BOTH XMLs TO MAKE SURE THAT THEY MATCH
        if ($fastPayPspID != $toolPspID) {
            //therow new Exception("The PSP ID does not match to the original transaction");
            echo "PSPID ($fastPayPspID)!=($toolPspID)";
        } elseif ($fastPayOref != $toolOref) {
            //throw new Exception("The Order Reference does not match to the original transaction");
            echo "Oref !=";
        }elseif ($fastPayAmount != $toolAmount) {
            //throw new Exception("The Amount does not match to the original transaction");
            echo "Amount != \n";
            echo $fastPayAmount." != ".$toolAmount;

        } else {
			// Transaction data is correct
            //echo "Iiimena sworia";

            global $db;

            $db->where("transaction_unique_id",$fastPayOref);
            $transaction = $db->getOne('money_transactions','status,amount,core_users_id,cut_amount,id,money_providers_id,money_accounts_id');

            if (!$transaction) {
                die();
            }

            switch( $transaction['money_providers_id'] ) {
                case 8:
                    $money_providers_id = 10;
                    break;
                case 11:
                    $money_providers_id = 15;
                    break;
                case 12:
                    $money_providers_id = 16;
                    break;
                case 13:
                    $money_providers_id = 17;
                    $accountCard = $PaymentID;
                    break;
                case 14:
                    $money_providers_id = 18;
                    break;
                case 19:
                    $money_providers_id = 20;
                    $accountCard = $PaymentID;
                    break;
                default:
                    $money_providers_id = $transaction['money_providers_id'];
            }


            // convert text float to is_integer
            $fastPayAmount_evil = (float)$fastPayAmount_evil;
            $fastPayAmount_evil = round ( $fastPayAmount_evil*100 );
            $fastPayAmount_evil = (int)$fastPayAmount_evil;

            // Make Deposit
            if( $transaction['cut_amount'] == $fastPayAmount_evil && !isset($_GET['way']) && ( $transaction['status'] == 0 || $transaction['status'] == 6  )  ) {

                //$payment_logger->info("WAS DEPOSIT");

                $db->startTransaction();

                $db->where("id",$transaction['core_users_id']);
                $update_balance = $db->update('core_users',array('balance'=>$db->inc( $transaction['amount'] )));

                //$payment_logger->info([
                    //'msg'=>'incremented User Balance',
                    //'transaction'=>$transaction,
                //]);

                //*
                // check money account
                //
                $db->where("core_users_id",$transaction['core_users_id']);
                $db->where("money_providers_id",$money_providers_id);


                if(!$accountCard || $accountCard == "") {
                    $accountCard = $fastPayPspID;
                }

                $db->where("Pan",$accountCard);

                $money_account = $db->getOne('money_accounts','*');

                if ( !count($money_account) ){
                    // account is not set
                    // create new account
                    $money_account_data = Array (
                        'core_users_id' => $transaction['core_users_id'],
                        'money_providers_id' => $money_providers_id,
                        'AccountReference' => $fastPayPspID,
                        'OrderReference' => $fastPayOref,
                        'Pan' => $accountCard,
                        'Active' => 1,
                        'AddDate' => date("Y-m-d h:i:s"),
                        'Type' => $accountCardType,
                        'IsDeleted' => 0,
                        'account_type' => 1,
                        'Payee' => $accountCardName,
                        'ConfirmationStatus' => 0
                    );
                    $money_account_id = $db->insert ('money_accounts', $money_account_data);

                    echo "1 =>".$db->getLastError();

                    if ( $money_account_id ) {
                        $money_left_data = Array (
                            'core_users_id' => $transaction['core_users_id'],
                            'money_accounts_id' => $money_account_id,
                            'amount' => $transaction['amount']
                        );
                        $money_left_id = $db->insert ('money_user_deposits_left_in_system', $money_left_data);
                        echo "2 =>".$db->getLastError();
                    } else {
                        $money_account_id = false;
                    }
                } else {
                    // account is already created
                    $db->where("core_users_id",$transaction['core_users_id']);
                    $db->where("money_accounts_id",$money_account['id']);
                    $update_left = $db->update('money_user_deposits_left_in_system',array('amount'=>$db->inc( $transaction['amount'] )));
                    echo "3 =>".$db->getLastError();
                    $money_account_id = $money_account['id'];
                }

                $update_transaction = false;
                if ( $money_account_id ) {
                    $db->where("id",$transaction['id']);
                    $db->where("status",0);
                    $update_transaction = $db->update("money_transactions",array(
                        "status"=>1,
                        "bank_transaction_id"=>$fastPayPspID,
                        "bank_status"=>'OK',
                        "money_accounts_id" => $money_account_id
                    ));
                    echo "4 =>".$db->getLastError();
                }


                if ($update_transaction && $update_balance ) {
                    $db->commit();
                    echo "1";
                }
                else {
                    $db->rollback();
                    echo "2";
                }


            }


            // Make Withdraw
            elseif( $transaction['cut_amount'] == $fastPayAmount_evil && isset($_GET['way']) && $_GET['way'] == "out" &&  ( $transaction['status'] == 0 || $transaction['status'] == 6  ) ){


                //$payment_logger->info("WAS WITHDRAW");

                $db->startTransaction();




                $db->where("id",$transaction['core_users_id']);
                $update_balance = $db->update('core_users',array('balance'=>$db->dec( $transaction['amount'] )));


                //*
                // check money account
                //
                $db->where("core_users_id",$transaction['core_users_id']);
                $db->where("money_providers_id",$money_providers_id);
                $db->where("Pan",$toolCardNum);

                $money_account = $db->getOne('money_accounts','*');

                if( $money_providers_id == 17 || $money_providers_id == 20 ){

                    $db->where("core_users_id",$transaction['core_users_id']);
                    $db->where("money_accounts_id",$transaction['money_accounts_id']);
                    $update_left = $db->update('money_user_deposits_left_in_system',array('amount'=>$db->dec( $transaction['amount'] )));
                    $money_account_id = $transaction['money_accounts_id'];

                }elseif ( !count($money_account) ){
                    // account is not set
                    // create new account
                    $money_account_id = false;
                }
                else {
                    // account is already created
                    $db->where("core_users_id",$transaction['core_users_id']);
                    $db->where("money_accounts_id",$money_account['id']);
                    $update_left = $db->update('money_user_deposits_left_in_system',array('amount'=>$db->dec( $transaction['amount'] )));
                    echo "3 =>".$db->getLastError();
                    $money_account_id = $money_account['id'];


                    //$payment_logger->info([
                        //'msg'=>'decreased User Balance',
                        //'transaction'=>$transaction,
                    //]);

                }

                $update_transaction = false;
                if ( $money_account_id ) {
                    $db->where("id",$transaction['id']);
                    $db->where("status",0);
                    $update_transaction = $db->update("money_transactions",array(
                        "status"=>1,
                        "bank_transaction_id"=>$fastPayPspID,
                        "bank_status"=>'OK',
                        "money_accounts_id" => $money_account_id
                    ));
                    echo "4 =>".$db->getLastError();
                }

                var_export($money_account_id);
                var_export($update_transaction);
                var_export($update_balance);

                if ($update_transaction && $update_balance ) {
                    $db->commit();
                    echo " -commited- ";
                }
                else {
                    $db->rollback();
                    echo " -rollback- ";
                }

            }


            // no Deposit, no Withdraw
            else {
                //$payment_logger->info("Unknown Operation Type");

                echo $transaction['cut_amount'] ." != ". $fastPayAmount_evil;
            }





		}
    } catch (Exception $ex) {
        //$payment_logger->error("Exception: ".$ex->getMessage());
        throw $ex;
    }
} // validateResponseWithTool()


/**
 * @param $xmlFastPayResponse: Response XML from apco
 * @param $status: 0 - Initialisation
 *                 1 - Confirmation
 *                 2 - Rejection
 *                 3 - Filed Transaction
 *                 4 - Needs Revision
 *                 5 - Waiting Wire
 *                 6 - Pending
 */
function updateBadTransaction($xmlFastPayResponse,$status){

    global $db,$payment_logger;

    //Retrieve the values from the XML response of FASTPAY
    $node = $xmlFastPayResponse->getElementsByTagName('ORef');
    $Oref = "";
    foreach ($node as $node) {
        $Oref = $node->textContent;
    }

    $node = $xmlFastPayResponse->getElementsByTagName('pspid');
    $PspID = "";
    foreach ($node as $node) {
        $PspID = $node->textContent;
    }

    $node = $xmlFastPayResponse->getElementsByTagName('ExtendedErr');
    $Error = "";
    foreach ($node as $node) {
        $Error = $node->textContent;
    }

    $node = $xmlFastPayResponse->getElementsByTagName('ExtendedErr');
    $Error = "";
    foreach ($node as $node) {
        $Error = $node->textContent;
    }

    $node = $xmlFastPayResponse->getElementsByTagName('Result');
    $Result = "";
    foreach ($node as $node) {
        $Result = $node->textContent;
    }

    $db->where("transaction_unique_id",$Oref);
    $db->where("status",0);
    $update_transaction = $db->update("money_transactions",array(
        "status"=>$status,
        "bank_transaction_id"=>$PspID,
        "bank_status"=> "$Result $Error"
    ));

    //$payment_logger->info(array(
        //"transaction_unique_id"=>$Oref
    //));


} //updateBadTransaction()








/**
 * Collects the response from FastPay and converts to DomDocument(XML)
 * @return \DOMDocument Returns an XML DomDocument object with the response of FastPay
 * @throws Exception
 */
function getParamsAndConvertToDomDocument() {
    try {
        //GET THE XML RESULT FROM THE FASTPAY
        if (isset($_POST['params'])) {
            //ONLY WHEN THIS INTEGRATION PAGE IS LIVE WILL BE RETRIEVED BY POST (localhost will not get XML via post)
            $resultXML = $_POST['params'];
        } elseif (isset($_GET['params'])) {
            //WHEN WORKING ON LOCAL HOST YOU WILL NOT GET THE RESULT FROM POST THEREFORE USE THE GET (QueryString)
            $resultXML = $_GET['params'];
        } else {
            throw new Exception("Could not retrieve the result XML from both the POST and the GET!!!!");
        }


        //CONVERT THE XML GIVEN FROM FastPay TO DomDocument XmlObject
        $domXML = new DOMDocument();
        $domXML->loadXML($resultXML);

        return ['dom'=>$domXML,'plain'=>$resultXML];
    } catch (Exception $ex) {
        throw $ex;
    }
}

/**
 * Gets the XML response from FastPay, replace the hash value of the Transaction tag with the secretword
 * and re-hash the xml to compare with the given hash value in the Transaction tag.
 * @param type $fastPayXml The FastPay Xml response (DomDocument)
 * @param type $secretWord The Merchant's secret word, to be updated in the hash tag with it
 * @param type $resultValue A string to be filled up with the result of the transaction if the XML hash matching is correct
 * @return type True/False. Where TRUE means that the validation is successful
 * @throws Exception
 */
function reCheckMd5ValidationOnFastPayXML($fastPayXml, $secretWord, &$resultValue, $plain) {
    try {


        //GET THE HASH VALUE, STORE TO BE USED FOR COMPARE AT A LATER STAGE AND REPLACE IT WITH THE SECRET WORD
        $sentHashValue = "";
        $node = $fastPayXml->getElementsByTagName('Transaction');
        foreach ($node as $node) {
            $sentHashValue = $node->getAttribute("hash");
            $node->setAttribute("hash", $secretWord);
            $fastPayXml->saveXML();
        }

        //RETRIEVE THE RESULT OF THE TRANSACTION TO KNOW WHETHER THE TRANSACTION WAS SUCCESSFUL OR NOT
        $node = $fastPayXml->getElementsByTagName('Result');
        foreach ($node as $node) {
            $resultValue = $node->textContent;
        }

        //CONVERT $domXML BACK TO A STRING TO REMOVE ANY EXTRA TAGS AND SPACES THAT MIGHT EFFECT THE HASH
        $finalXML = $fastPayXml->saveXML();


		$final = str_replace($sentHashValue,$secretWord,$plain);




        //validate Hash values
        return (strcmp(md5($final), $sentHashValue) == 0);
    } catch (Exception $ex) {
		echo $ex->getMessage();
        throw $ex;
    }
}

try {
    /* Print OK so the APCO system knows that the message is recieved */
    echo "OK";

    //RETRIEVE THE FASTPAY RESPONSE DomDocument
    $fastPayXml = getParamsAndConvertToDomDocument();

    $resultValue = "";

    if (reCheckMd5ValidationOnFastPayXML($fastPayXml['dom'], $secretWord, $resultValue,$fastPayXml['plain'])) {
        //MDF successfully matched

        //$payment_logger->info("resultValue = $resultValue");

        switch (strtoupper($resultValue)) {
            case "OK":
                validateResponseWithTool($fastPayXml['dom']);
                /* echo '<br/><strong>OK</strong>: The transaction was successful.'; */
                break;

            case "NOTOK":
                updateBadTransaction($fastPayXml['dom'],3);
                /* echo '<br/><strong>NOTOK</strong>: The transaction was not successful.'; */
                break;

            case "DECLINED":
                updateBadTransaction($fastPayXml['dom'],3);
                /* echo '<br/><strong>DECLINED</strong>: The transaction was declined.'; */
                break;

            case "PENDING":
                updateBadTransaction($fastPayXml['dom'],6);
                /* echo '<br/><strong>PENDING</strong>: The transaction is still pending.'; */
                break;

            case "CANCEL":
                updateBadTransaction($fastPayXml['dom'],2);
                /* echo '<br/><strong>CANCEL</strong>: The transaction is cancelled.'; */
                break;

            default:
                /* echo '<br/><strong>OTHER RESULT</strong>: ' . strtoupper($resultValue); */
                break;
        }
    } else {
        //$payment_logger->error("Hash Key was not validated!");
        //ERROR: invalid hash
        echo "<br /><strong>No match!!</strong>";
    }
}
catch (Exception $ex) {
    //$payment_logger->info("Received Request On Paco Listener");
    echo "<br/><strong>Message: </strong>" . $ex->getMessage();
    echo "<br/><strong>Trace: </strong>" . $ex->getTraceAsString();
}
?>
