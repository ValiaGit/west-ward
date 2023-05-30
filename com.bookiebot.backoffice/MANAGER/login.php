<?php
    if(isset($_POST['submit'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $interval_minutes = 5;


        $dev = "local";
        if($dev=="local") {
            require_once "../API/system/local_config.php";
        } else {
            require_once "../API/system/config.php";
        }
        require_once "../API/helpers/MysqliDb.php";
        $db = new MysqliDb ($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);

        $db->where('username',$username);
        $db->where('password',md5($password));
        $getOne = $db->getOne('backoffice_users',"id,username");
        if($getOne !== false) {
            if($getOne) {
                $_SESSION['expiry_time'] = time()+(60*$interval_minutes);
                $_SESSION['admin'] = true;
                $_SESSION['admin_data'] = $getOne;
                echo "<script>window.location.href = 'index.php';</script>";
            }

        }

    }
?>

<head>
    <link href="_media/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="_media/css/londinium-theme.css" rel="stylesheet" type="text/css">
    <link href="_media/css/styles.css" rel="stylesheet" type="text/css">
    <link href="_media/css/additional.css" rel="stylesheet" type="text/css">
    <link href="_media/css/icons.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="_media/css/kendo/kendo.common-bootstrap.min.css" />
    <link rel="stylesheet" href="_media/css/kendo/kendo.bootstrap.min.css" />
</head>
<body class="full-width page-condensed">

<!-- Navbar -->
<div class="navbar navbar-inverse" role="navigation">
    <div class="navbar-header">
        <a class="navbar-brand" href="./index.php"><img src="http://bookiebot.com/app/templates/default/view/_media/images/logo.png?1431481784" alt="Bookiebot"></a>
    </div>
</div>
<!-- /navbar -->


<!-- Login wrapper -->
<div class="login-wrapper">
    <form action="" role="form" method="post">
        <div class="popup-header">
            <span class="text-semibold">User Login</span>
        </div>
        <div class="well">
            <div class="form-group has-feedback">
                <label>Username</label>
                <input type="text" name="username" class="form-control" placeholder="Username">
                <i class="icon-users form-control-feedback"></i>
            </div>

            <div class="form-group has-feedback">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Password">
                <i class="icon-lock form-control-feedback"></i>
            </div>

            <div class="row form-actions">

                <div class="col-xs-12">
                    <button type="submit" name="submit" class="btn btn-warning pull-right"><i class="icon-menu2"></i> Sign in</button>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- /login wrapper -->




</body>
</html>