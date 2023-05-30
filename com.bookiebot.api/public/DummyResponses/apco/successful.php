<?php
ini_set("display_errors",1);

require("../../PaymentGateway/Deposit/SystemIncludes.php");

$secretWord =       $config['apco_secret'];


if( isset($_GET['local']) && $_GET['local'] == 'fsV2' && isset($_GET['transaction']) && $_GET['transaction'] != ''  ) {

    $transaction_unique_id = $_GET['transaction'];

    $db->where("transaction_unique_id",$transaction_unique_id);
    $db->where("money_providers_id",17);
    $transaction = $db->getOne('money_transactions','status');

    if ( $transaction ) {
        $status = $transaction['status'];
    } else {
        $status = 2;
    }

} elseif ( !isset($_GET['params']) || ( isset($_GET['params']) && $_GET['params'] == '' ) ) {
    $status = 0;
} else {
    $params = getParamsAndConvertToDomDocument();
}


if ( isset( $params ) && reCheckMd5ValidationOnFastPayXML($params['dom'], $secretWord, $params['plain']) ) {

    $oref = $params['oref'];

    $db->where("transaction_unique_id",$oref);
    $transaction = $db->getOne('money_transactions','status');

    $status = $transaction['status'];
} elseif( isset( $params ) ) {
    $status = 2;
}

$results_array = array(
    0 => '<br/><strong>UNKNOW</strong>: The transaction result is unknow. please, contact us.',
    1 => '<br/><strong>OK</strong>: The transaction was successful.',
    2 => '<br/><strong>CANCEL</strong>: The transaction is cancelled.',
    3 => '<br/><strong>DECLINED</strong>: The transaction was declined.',
    6 => '<br/><strong>PENDING</strong>: The transaction is still pending.'
);

function reCheckMd5ValidationOnFastPayXML($fastPayXml, $secretWord, $plain) {
    try {


        //GET THE HASH VALUE, STORE TO BE USED FOR COMPARE AT A LATER STAGE AND REPLACE IT WITH THE SECRET WORD
        $sentHashValue = "";
        $node = $fastPayXml->getElementsByTagName('Transaction');
        foreach ($node as $node) {
            $sentHashValue = $node->getAttribute("hash");
            $node->setAttribute("hash", $secretWord);
            $fastPayXml->saveXML();
        }

		$final = str_replace($sentHashValue,$secretWord,$plain);

        //validate Hash values
        return (strcmp(md5($final), $sentHashValue) == 0);
    } catch (Exception $ex) {
		echo $ex->getMessage();
        throw $ex;
    }
}


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


        $Oref = '';
        $node = $domXML->getElementsByTagName('ORef');
        foreach ($node as $node) {
            $Oref = $node->textContent;
        }


        return ['dom'=>$domXML,'plain'=>$resultXML,'oref'=>$Oref];
    } catch (Exception $ex) {
        throw $ex;
    }
}












?>


<html>
<head>
    <title>FastPay Transaction Response</title>
</head>
<body>
    <?php echo $results_array[$status]; ?>
</body>
</html>
