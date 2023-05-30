<?php


define("APP",true);
$env = "local";



require("head.php");
if (!isset($_SESSION['admin'])) {
    require("login.php");
    die();
}




if (isset($_GET['logout'])) {
    session_destroy();
    require("login.php");
    die();
}
?>

<body class="sidebar-narrow">

<!-- Navbar -->
<div class="navbar navbar-inverse" role="navigation">
    <div class="navbar-header">
        <a class="navbar-brand" href="index.php">
            <img src="<?php echo $base_url; ?>/CMS/_media/images/logo.png" />
<!--                 alt="Londinium">-->
        </a>

    </div>

    <ul class="nav navbar-nav navbar-right collapse" id="navbar-icons">
        <li class="user">
            <a class="dropdown-toggle" href="/CMS/index.php?logout=true">
                <i class="icon-exit"></i> <span>Logout</span>
            </a>
        </li>
    </ul>

</div>
<!-- /navbar -->


<!-- Page container -->
<div class="page-container">

    <!-- Sidebar -->
    <div class="sidebar collapse">
        <div class="sidebar-content">

            <!-- Main navigation -->
            <ul class="navigation" id="PageNavigation">
                <li><a data-controller="dashboard" data-page="dashboard" href="#"><span>Dashoboard</span> <i class="icon-bars"></i></a></li>
                <li><a data-controller="bets" data-page="maindata" href="#"><span>Main Data Management</span> <i class="icon-user"></i></a></li>
                <li><a data-controller="sport" data-page="categories" href="#"><span>Data Manipulation</span> <i class="icon-tree3"></i></a></li>
                <li><a data-controller="matches.initEdit" data-page="matches" href="#"><span>Matches</span> <i class="icon-crown"></i></a></li>
<!--                <li><a data-controller="outright.initEdit" data-page="outright" href="#"><span>Outright</span> <i class="icon-crown"></i></a></li>-->
            </ul>

            <!-- /main navigation -->
        </div>
    </div>
    <!-- /sidebar -->


    <!-- Page content -->
    <div class="page-content" id="PageContent">

        <?php

        $page = 'dashboard';
        include 'pages/' . $page . '.html';

        ?>
    </div>
    <!-- /page content -->


</div>
<!-- /page container -->



<div id="modal_message" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Message</h4>
            </div>

            <div class="modal-body with-padding">
                <p class="message_content"></p>
            </div>

            <div class="modal-footer modal_buttons">
                <button class="btn btn-warning" data-dismiss="modal"><i class="icon-cancel-circle"></i> Close</button>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="_media/js/libs/md5.js"></script>
<script type="text/javascript" src="_media/js/libs/jszip.min.js"></script>
<script type="text/javascript" src="_media/js/libs/moment.js"></script>
<script type="text/javascript" src="_media/js/libs/ux.js"></script>



<script type="text/javascript" src="_media/compiled/bundle.min.js?v=<?php echo rand(); ?>"></script>

<?php readd('_media/App');
echo $_SESSION['expiry_time']-time();
?>


</body>
</html>