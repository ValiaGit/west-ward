<!DOCTYPE html>
<html>
<head>
    <title>Bookiebot.Com</title>
    <meta charset="utf8"/>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="{{$THEME}}/css/application.css"/>
    <link rel="stylesheet" href="{{$THEME}}/css/libs/datepicker.css"/>

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <script>
        var sault = '{{$sault}}';
        var cur_lang = '{{$cur_lang}}';
        var base_href = '{{$base_href}}';
        var needs_authentication = '{{$Data.needs_authentication}}';
        var request_uri = '{{$Data.request_uri}}';
    </script>


    <!-- Place this asynchronous JavaScript just before your </body> tag -->
    <script src="{{$base_href}}/lang_{{$cur_lang}}.js"></script>

    <script src="{{$THEME}}/js/libs/jquery.js"></script>
    <script src="{{$THEME}}/js/libs/jquery-ui.min.js"></script>
    <script src="{{$THEME}}/js/libs/jquery.validate.min.js"></script>
    <script src="{{$THEME}}/js/libs/additional-methods.min.js"></script>
    <script src="{{$THEME}}/js/libs/jquery.cookie.js"></script>
    <script src="{{$THEME}}/js/libs/bootstrap.min.js"></script>
    <script src="{{$THEME}}/js/libs/idangerous.swiper.min.js"></script>
    <script src="{{$THEME}}/js/libs/jquery.sticky.min.js"></script>

    <script src="{{$THEME}}/js/libs/bootbox.min.js"></script>
    <script src="{{$THEME}}/js/libs/select2.min.js"></script>
    <script src="{{$THEME}}/js/libs/collapsible.min.js"></script>
    <script src="{{$THEME}}/js/libs/datepicker.js"></script>
    <script src="{{$THEME}}/js/libs/moment.js"></script>
    <script src="{{$THEME}}/js/classes/API.js"></script>
    <!-- Some Utility Functions -->
    <script src="{{$THEME}}/js/Betstock/Util.js"></script>

</head>
<body class="page-social-not">

<div class="wrapper">

    <div class="navbar navbar-blue navbar-fixed-top top-navbar" role="navigation">
        <div class="container">
            <div class="row relative">
                <div class="col-md-12">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span>
                            <span class="icon-bar"></span> <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="{{$base_href}}/{{$cur_lang}}">Bookiebot</a>
                    </div>
                    <!-- navbar-header -->

                    <!--/.nav-collapse -->
                </div>
            </div>
            <!-- row -->
        </div>
        <!-- container -->
    </div>
    <!-- navbar -->
    <script src="{{$THEME}}/js/Betstock/Social/Search.js"></script>





    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <div class="social-not-message text-center">

                    <h3>© Westward Entertainment</h3>
                    <h2>Website is under construction!</h2>
                </div>
                <!-- social-not-message -->
            </div>
            <!-- col -->
        </div>
        <!-- row -->

    </div>
    <!-- container -->
    <div class="push"></div>
</div>
<!-- wrapper -->

<div class="footer">
    <div class="footer-nav">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <ul class="nav nav-pills">

                    </ul>
                </div>
                <!-- col -->
                <div class="col-md-6 text-right">
                    <div class="contact-phone">

                    </div>
                    <!-- contact phone -->
                    <div class="copyright">
                        © Westward Entertainment LLC. All rights reserved.
                    </div>
                    <!-- copyright -->
                </div>
                <!-- col -->
            </div>
            <!-- row -->
        </div>
        <!-- container -->
    </div>
    <!-- footer-nav -->
    <div class="footer-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12 clearfix">

                </div>
                <!-- col-md-12 -->
            </div>
            <!-- row -->
        </div>
        <!-- container -->

    </div>
    <!-- footer-content -->
</div>
<!-- footer -->






<!-- Betting Spoecific Classes-->

<!--
<script src="{{$THEME}}/js/Betstock/Betting/Betslip.js"></script>
<script src="{{$THEME}}/js/Betstock/Betting/Matches.js"></script>
<script src="{{$THEME}}/js/Betstock/Betting/Betting.js"></script>
<script src="{{$THEME}}/js/Betstock/Betting/TopMatches.js"></script>
<script src="{{$THEME}}/js/Betstock/Betting/Odds.js"></script>


<script src="{{$THEME}}/js/Betstock/Betting/History.js"></script>-->
<script src="{{$THEME}}/js/Betstock/Betting/UpcomingsWidget.js"></script>






<!-- Social Spoecific Classes -->
<script src="{{$THEME}}/js/Betstock/Social/Posts.js?v=3"></script>
<script src="{{$THEME}}/js/Betstock/Social/Friends.js"></script>
<script src="{{$THEME}}/js/Betstock/Social/Community.js"></script>
<script src="{{$THEME}}/js/Betstock/Social/Messaging.js"></script>


<!-- User Specific Classes -->
<script src="{{$THEME}}/js/Betstock/User/Registration.js"></script>
<script src="{{$THEME}}/js/Betstock/User/Session.js?id=2"></script>
<script src="{{$THEME}}/js/Betstock/User/ForgotPass.js"></script>





<script src="{{$THEME}}/js/load.js"></script>


</body>
</html>



