<?php

if(!defined("APP")) {
    die();
}

session_start();
session_set_cookie_params(100);


if(isset($_SESSION['expiry_time'])) {
    if($_SESSION['expiry_time']<time()) {
//        session_destroy();
//        require("login.php");
//        die();
    } else {
        $_SESSION['expiry_time'] = time()+(60*5);
    }
}


include '_res/functions.php';



if(@$env == "local") {
    require_once("./conf/local_conf.php");
}

else {
    require_once("./conf/conf.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bookiebot CMS</title>

    <link href="_media/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="_media/css/londinium-theme.css" rel="stylesheet" type="text/css">
    <link href="_media/css/styles.css" rel="stylesheet" type="text/css">
    <link href="_media/css/additional.css" rel="stylesheet" type="text/css">
    <link href="_media/css/icons.css" rel="stylesheet" type="text/css">


    <!--<link rel="stylesheet" href="_media/css/kendo/kendo.common.min.css" />-->
    <link rel="stylesheet" href="_media/css/kendo/kendo.common-bootstrap.min.css" />
    <link rel="stylesheet" href="_media/css/kendo/kendo.bootstrap.min.css" />
    <!---->
    <!--<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">-->

    <script type="text/javascript" src="_media/js/jquery.min.js"></script>
    <script type="text/javascript" src="_media/js/jquery-ui.min.js"></script>




    <script type="text/javascript" src="_media/js/plugins/forms/select2.min.js"></script>



    <script type="text/javascript" src="_media/js/kendo/kendo.all.min.js"></script>


    <script type="text/javascript" src="_media/js/plugins/interface/moment.js"></script>
    <script type="text/javascript" src="_media/js/plugins/interface/jgrowl.min.js"></script>
    <script type="text/javascript" src="_media/js/plugins/interface/timepicker.min.js"></script>
    <script type="text/javascript" src="_media/js/plugins/interface/collapsible.min.js"></script>

    <script type="text/javascript" src="_media/js/bootstrap.min.js"></script>
<!--    <script type="text/javascript" src="_media/js/application.js"></script>-->

    <script type="text/javascript">
        var api_href = '<?php echo $api_url ?>';
        var sault = "<?php echo md5("ASDJLSAD*&$%^".strrev(session_id())); ?>"
    </script>


</head>