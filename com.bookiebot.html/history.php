<?php
$page_body_class = "page-history";
include "includes/header.php";
?>

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
                                        <li class="text-right">
                                            <a href="http://bookiebot.com/en/user/balance_management">Balance
                                                Management</a></li>
                                        <li class="text-right">
                                            <a href="http://bookiebot.com/en/user/settings">Account Settings</a></li>
                                        <li class="text-right active">
                                            <a href="http://bookiebot.com/en/user/betting_history">Betting History</a>
                                        </li>
                                        <li class="text-right">
                                            <a href="http://bookiebot.com/en/user/rewards">Player Protection</a></li>
                                        <li class="text-right">
                                            <a href="http://bookiebot.com/en/user/access_log">Access Log</a></li>
                                    </ul>
                                </li>

                            </ul>
                            <button class="btn btn-blue btn-sm btn-logout" onclick="Session.logout()">Logout</button>
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
                    <strong>11:34:51</strong> Jan.07,2015
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
                <li>
                    <a href="http://bookiebot.com/en/user/balance_management">
                        <i class="glyphicon glyphicon-"></i> Balance Management
                    </a>
                </li>
                <li>
                    <a href="http://bookiebot.com/en/user/settings">
                        <i class="glyphicon glyphicon-"></i> Account Settings
                    </a>
                </li>
                <li class="active">
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

            <div class="panel panel-default panel-profile">

                <div class="container-fluid">
                    <div class="row">

                        <div class="col-md-12">
                            <h2 class="panel-title">Betting History</h2>
                            <hr>
                            <!--<h4 class="hidden" id="no_history_bets">You Dont Have Placed Any Bets Yet!</h4>
-->

                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-6 col-md-offset-3">
                                        <form action="" class="form-inline">

                                            <div class="container-fluid no-space">

                                                <div class="row">
                                                    <div class="form-group col-md-3">
                                                        <input type="text" class="form-control input-default full-width"
                                                               id="dpd1">
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <input type="text" class="form-control input-default full-width"
                                                               id="dpd2">
                                                    </div>
                                                    <div class="form-group col-md-4">

                                                        <select class="custom-select full-width select2-offscreen"
                                                                name="betStatusIds" tabindex="-1" title="">
                                                            <option value="0">Unmatched</option>
                                                            <option value="1">Fully Matched</option>
                                                            <option value="2">Partly Matched</option>
                                                            <option value="3">Won</option>
                                                            <option value="4">Lose</option>
                                                            <option value="5">Canceled Received Money Back</option>
                                                            <option value="6">Partly Canceled</option>
                                                            <option value="7">Partly Canceled Lost</option>
                                                            <option value="9">Partly Canceled Won</option>
                                                            <option value="10">Not Matched Returned Money</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-2">
                                                        <input type="submit" class="btn btn-28 btn-space btn-dark-blue"
                                                               id="SubmitHistorySearch" value="Search">
                                                    </div>
                                                </div>
                                                <!-- row -->

                                            </div>
                                        </form>
                                        <!-- container -->


                                    </div>
                                    <!-- col -->
                                </div>
                                <!-- row -->
                            </div>
                            <!-- container -->

                        </div>
                        <!-- col -->
                    </div>
                    <!-- row -->
                </div>
                <!-- container -->

                <table class="table table-custom" id="bets_history_table">
                    <thead>
                    <tr>
                        <th>Markets</th>
                        <th>Selection</th>
                        <th>Bet Id</th>
                        <th>Bet Placed</th>
                        <th>Odds Req.</th>
                        <th>Stake ($)</th>
                        <th>Unmatched ($)</th>
                        <th>Status</th>
                        <th>Profit/Loss ($)</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Wollongong Hawks - Melbourne Tigers</td>
                        <td>Wollongong Hawks</td>
                        <td>803</td>
                        <td>2014-12-20</td>
                        <td>2.06</td>
                        <td>2.00</td>
                        <td>0.00</td>
                        <td>Fully Matched</td>
                        <td>11.33</td>
                    </tr>
                    <tr>
                        <td>Rochdale FC - Notts County</td>
                        <td>Rochdale FC</td>
                        <td>808</td>
                        <td>2015-01-05</td>
                        <td>2.40</td>
                        <td>10.00</td>
                        <td>5.00</td>
                        <td>Partly Matched</td>
                        <td>11.33</td>
                    </tr>
                    </tbody>
                </table>

            </div>
            <!-- panel -->
        </div>
        <!-- col -->

    </div>
    <!-- row -->

</div>
<!-- container -->


<script src="http://bookiebot.com/app/templates/default/view/_media/js/Betstock/Betting/Betting.js"></script>
<div class="push"></div>
</div>


<?php
include "includes/footer.php";
?>