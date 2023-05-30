<?php
$page_body_class = "page-cashier";
include "includes/header.php";
?>


    <div class="wrapper">

    <div class="navbar navbar-blue navbar-fixed-top top-navbar" role="navigation">
        <div class="container">
            <div class="row relative">
                <div class="col-md-12">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse"
                                data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span>
                            <span class="icon-bar"></span> <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="http://bookiebot.com/en">Bookiebot</a>
                    </div>
                    <!-- navbar-header -->
                    <div class="navbar-collapse collapse">
                        <ul class="nav navbar-nav navbar-icons">
                            <li>
                                <a href="http://bookiebot.com/en">
                                    <span class="glyphicon glyphicon-th"></span>
                                    <span class="text">BETTING</span>
                                </a>
                            </li>
                            <li>
                                <a href="http://bookiebot.com/en/social">
                                    <span class="glyphicon glyphicon-user"></span>
                                    <span class="text">PEOPLE</span>
                                </a>
                            </li>
                        </ul>

                        <div class="search-form pull-left">
                            <input type="text" class="search-input" id="peopleGroupSearch"
                                   onkeyup="Search.init(event);return false;" value=""
                                   placeholder="Search People or Groups">
                            <button class="search-btn glyphicon glyphicon-search"></button>

                            <div class="search-results" tabindex="0" onblur="Search.blur(event); return false;">

                                <div class="search-results-inner">
                                    <div class="search-items">

                                    </div>
                                    <!-- search items -->

                                    <!--<div class="search-more">
                                        <div class="search-item">
                                            <div class="item-details">
                                                <div class="item-description">Search more results for "Test"...</div>
                                                <a class="full-link" href="#full-search"></a>
                                            </div>
                                        </div>
                                    </div>
                                     search-more -->

                                </div>
                                <!-- search-results-inner -->

                            </div>
                            <!-- search-results -->

                        </div>
                        <!-- search-form -->

                        <ul class="nav navbar-top navbar-nav navbar-pages">
                            <li>
                                <a href="http://bookiebot.com/en/page/show/about_us">About Us</a></li>
                            <li>
                                <a href="http://bookiebot.com/en/page/show/what_is_betstock">How Make Bets</a></li>
                            <li>
                                <a href="http://bookiebot.com/en/blog">FAQ</a></li>
                        </ul>

                        <form class="navbar-form form-login navbar-right hidden" method="post" id="loginForm"
                              novalidate="novalidate" autocomplete="off" onsubmit="Session.login(this);return false;">
                            <div class="form-group">
                                <input type="text" name="username" placeholder="Username or Email" autocomplete="off"
                                       class="form-control input-small input-sm">
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" placeholder="Password" autocomplete="off"
                                       class="form-control input-small input-sm">
                            </div>
                            <button type="submit" class="btn btn-sm btn-blue">Login</button>
                            <a class="icon-fb" href="http://bookiebot.com/en/fb/login"></a>
                            <a class="icon-google" href="#" id="signInButton"></a>
                        </form>

                        <div class="loggedIn">
                            <div class="navbar-right">

                                <ul class="nav navbar-nav navbar-profile">

                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                            <img id="profile_pic"
                                                 src="http://bookiebot.com/uploads/social/profile/82/94b0080ed55a6ba6d1732be225a97bbda3b5a1e4.jpg"
                                                 alt=""> My Account
                                            <b class="caret"></b>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li class="text-right active">
                                                <a href="http://bookiebot.com/en/user/balance_management">Balance
                                                    Management</a></li>
                                            <li class="text-right">
                                                <a href="http://bookiebot.com/en/user/settings">Account Settings</a>
                                            </li>
                                            <li class="text-right">
                                                <a href="http://bookiebot.com/en/user/betting_history">Betting
                                                    History</a></li>
                                            <li class="text-right">
                                                <a href="http://bookiebot.com/en/user/rewards">Player Protection</a>
                                            </li>
                                            <li class="text-right">
                                                <a href="http://bookiebot.com/en/user/access_log">Access Log</a></li>
                                        </ul>
                                    </li>

                                </ul>
                                <button class="btn btn-blue btn-sm btn-logout" onclick="Session.logout()">Logout
                                </button>
                            </div>
                        </div>

                        <ul class="nav navbar-nav navbar-right hidden">
                            <li>
                                <a>
                                    <select name="" class="input-normal" title="">
                                        <option value="">ENG</option>
                                        <option value="">DEU</option>
                                        <option value="">GEO</option>
                                        <option value="">RUS</option>
                                    </select>
                                </a>
                            </li>
                        </ul>

                        <ul class="language-switcher">
                            <li>
                                <a href="#"><i class="icon-en"></i></a>
                                <ul class="children">
                                    <li>
                                        <a href="#" onclick="Util.changeLang('ru'); return false;"><i
                                                class="icon-ru"></i></a>
                                    </li>
                                    <li>
                                        <a href="#" onclick="Util.changeLang('en'); return false;"><i
                                                class="icon-en"></i></a>
                                    </li>
                                    <li>
                                        <a href="#" onclick="Util.changeLang('ka'); return false;"><i
                                                class="icon-ka"></i></a>
                                    </li>
                                    <li>
                                        <a href="#" onclick="Util.changeLang('de'); return false;"><i
                                                class="icon-de"></i></a>
                                    </li>
                                    <li>
                                        <a href="#" onclick="Util.changeLang('ja'); return false;"><i
                                                class="icon-ja"></i></a>
                                    </li>
                                </ul>
                            </li>
                        </ul>

                    </div>
                    <!--/.nav-collapse -->
                </div>
            </div>
            <!-- row -->
        </div>
        <!-- container -->
    </div>
    <!-- navbar -->

    <script src="http://bookiebot.com/app/templates/default/view/_media/js/Betstock/Social/Search.js"></script>


    <div class="navbar navbar-default navbar-sub-header">
        <div class="container">


            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <div class="current-time">
                        <strong>11:23:15</strong> Jan.07,2015
                    </div>
                    <!-- current time -->
                </div>
                <!-- cold -->
                <div class="col-md-6 col-sm-6 col-xs-6 text-right hidden" id="forgot_register" style="display: none;">
                    <a href="#" onclick="ForgotPass.openDialog();return false;"> Forgot your password?</a>
                    <a class="blue" href="#" onclick="Registration.openDialog();return false;">Register Now!</a>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6 text-right" id="userData" style="display: block;"><span
                        class="profile-label">Welcome, </span> <a class="profile-label bold cap blue"
                                                                  href="http://bookiebot.com/en/user/settings">peter </a>&nbsp;&nbsp;UserId:82&nbsp;&nbsp;<span
                        class="profile-label">Balance:</span><span class="profile-label bold"> 49156.59$</span></div>
                <!-- col -->
            </div>
            <!-- row -->


        </div>
        <!-- container -->
    </div>
    <!-- navbar -->

    <div class="container">

        <div class="row">

            <div class="col-md-12">


                <ul class="nav nav-tabs profile-tabs">
                    <li class="active">
                        <a href="http://bookiebot.com/en/user/balance_management">
                            <i class="glyphicon glyphicon-"></i> Balance Management
                        </a>
                    </li>
                    <li>
                        <a href="http://bookiebot.com/en/user/settings">
                            <i class="glyphicon glyphicon-"></i> Account Settings
                        </a>
                    </li>
                    <li>
                        <a href="http://bookiebot.com/en/user/betting_history">
                            <i class="glyphicon glyphicon-"></i> Betting History
                        </a>
                    </li>
                    <li>
                        <a href="http://bookiebot.com/en/user/rewards">
                            <i class="glyphicon glyphicon-"></i> Player Protection
                        </a>
                    </li>
                    <li>
                        <a href="http://bookiebot.com/en/user/access_log">
                            <i class="glyphicon glyphicon-"></i> Access Log
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-tabs children-tabs">

                    <li class="active">
                        <a href="http://bookiebot.com/en/user/deposit">
                            Deposit
                        </a>
                    </li>


                    <li>
                        <a href="http://bookiebot.com/en/user/withdraw">
                            Withdraw
                        </a>
                    </li>

                    <li>
                        <a href="http://bookiebot.com/en/user/transfer_history">
                            Transfer History
                        </a>
                    </li>
                </ul>


                <div class="panel panel-default panel-profile no-space">
                    <div class="container-fluid no-space">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-custom table-custom-border">
                                    <tbody>


                                    <tr>
                                        <td class="white text-center">
                                            <img
                                                src="http://bookiebot.com//app/templates/default/view/_media/images/balance_logos/1.png"
                                                alt="">
                                        </td>
                                        <td>
                                            <span class="small-grey"><span class="small-grey">Min Amount</span></span>
                                            <span class="large">10 USD</span>
                                        </td>
                                        <td>
                                            <span class="small-grey">Max Amount</span>
                                            <span class="large">10 USD</span>
                                        </td>
                                        <td>
                                            <span class="small-grey">Commission</span>
                                            <span class="large">%</span>
                                        </td>
                                        <td class="text-center">
                                            <a class="icon-info-large" href="#"
                                               onclick="Util.Popup.open({title:'Visa/Mastercard',content:'Here Will Be Instructiona! nd Rules'})"></a>
                                        </td>
                                        <td>
                                            <form onsubmit="Deposit.initTransaction(this);return false;">
                                                <input type="hidden" name="provider_name" value="emerchantpay">
                                                <input type="hidden" name="provider_id" value="1">
                                                <input type="text" name="amount"
                                                       class="form-control input-deposit input-default">
                                                <button class="btn btn-sm btn-dark-blue btn-space">Deposit</button>
                                            </form>
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                            <!-- col -->
                        </div>
                        <!-- row -->
                    </div>
                    <!-- container -->
                </div>
                <!-- panel -->


            </div>
            <!-- col -->

        </div>
        <!-- row -->

    </div>
    <!-- container -->

    <!-- Cashier Classes -->
    <script type="text/javascript"
            src="http://bookiebot.com/app/templates/default/view/_media/js/Betstock/Cashier/Deposit.js"></script>

    <div class="push"></div>
    </div>

<?php
include "includes/footer.php";
?>