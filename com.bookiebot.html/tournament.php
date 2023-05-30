<?php
$page_body_class = "page-home";
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
                                        <li class="text-right">
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
                    <strong>15:15:52</strong> Jan.07,2015
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


<div class="container main-container">
    <div class="row">

        <div class="col-md-3 left-sidebar">
            <div class="sidebar-content">


                <div class="list-group list-custom list-blue">
                    <h2>Favorites</h2>

                    <div id="FavCategories">
                        <ul class="navigation level-1">
                            <li data-id="3554" class="popular sports list-group-item collapsed"><a title="Bundesliga"
                                                                                                   href="#">Bundesliga</a>
                            </li>
                            <li data-id="3285" class="popular sports list-group-item collapsed"><a title="Premiership"
                                                                                                   href="#">Premiership</a>
                            </li>
                        </ul>
                    </div>
                </div>


                <div class="list-group list-custom list-dark">
                    <h2>Sports</h2>

                    <div id="categoriesTree">
                        <ul class="navigation level-1">
                            <li data-id="340" class="sports list-group-item expanded"><a title="Basketball" href="#"
                                                                                         class="expand expanded"><i
                                        class="sport-basketball"></i>Basketball</a>
                                <ul class="level-2" style="display: block;">
                                    <li data-id="1311" class="groups list-group-item expanded"><a title="Mexico"
                                                                                                  href="#"
                                                                                                  class="expand expanded"><i
                                                class="flag flag-me"></i> Mexico</a>
                                        <ul class="level-3" style="display: block;">
                                            <li data-id="4826" class="tournaments list-group-item"><a title="LNBP"
                                                                                                      href="#"> LNBP</a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li data-id="352" class="sports list-group-item collapsed"><a title="Ice Hockey" href="#"
                                                                                          class="expand collapsed"><i
                                        class="sport-ice-hockey"></i>Ice Hockey</a>
                                <ul class="level-2" style="display: none;">
                                    <li data-id="1236" class="groups list-group-item collapsed"><a title="Austria"
                                                                                                   href="#"
                                                                                                   class="expand collapsed"><i
                                                class="flag flag-au"></i> Austria</a>
                                        <ul class="level-3" style="display: none;">
                                            <li data-id="4165" class="tournaments list-group-item"><a title="EHL"
                                                                                                      href="#"> EHL</a>
                                            </li>
                                            <li data-id="5211" class="tournaments list-group-item"><a title="Erste Bank"
                                                                                                      href="#"> Erste
                                                    Bank</a></li>
                                        </ul>
                                    </li>
                                    <li data-id="1278" class="groups list-group-item collapsed"><a title="Canada"
                                                                                                   href="#"
                                                                                                   class="expand collapsed"><i
                                                class="flag flag-ca"></i> Canada</a>
                                        <ul class="level-3" style="display: none;">
                                            <li data-id="4612" class="tournaments list-group-item"><a title="OHL"
                                                                                                      href="#"> OHL</a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li data-id="339" class="sports list-group-item collapsed"><a title="Rugby" href="#"
                                                                                          class="expand collapsed"><i
                                        class="sport-rugby"></i>Rugby</a>
                                <ul class="level-2" style="display: none;">
                                    <li data-id="1075" class="groups list-group-item collapsed"><a title="Rugby Union"
                                                                                                   href="#"
                                                                                                   class="expand collapsed"><i
                                                class="flag flag-false"></i> Rugby Union</a>
                                        <ul class="level-3" style="display: none;">
                                            <li data-id="5261" class="tournaments list-group-item"><a
                                                    title="European Rugby Champions Cup - Pool 1" href="#"> European
                                                    Rugby Champions Cup - Pool 1</a></li>
                                            <li data-id="3275" class="tournaments list-group-item"><a
                                                    title="France - Top 14" href="#"> France - Top 14</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li data-id="336" class="sports list-group-item collapsed"><a title="Soccer" href="#"
                                                                                          class="expand collapsed"><i
                                        class="sport-soccer"></i>Soccer</a>
                                <ul class="level-2" style="display: none;">
                                    <li data-id="1103" class="groups list-group-item collapsed"><a title="Belgium"
                                                                                                   href="#"
                                                                                                   class="expand collapsed"><i
                                                class="flag flag-be"></i> Belgium</a>
                                        <ul class="level-3" style="display: none;">
                                            <li data-id="3439" class="tournaments list-group-item"><a
                                                    title="Tweede Klasse" href="#"> Tweede Klasse</a></li>
                                            <li data-id="5138" class="tournaments list-group-item"><a
                                                    title="Tweede Klasse - Winner" href="#"> Tweede Klasse - Winner</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li data-id="1147" class="groups list-group-item collapsed"><a title="England"
                                                                                                   href="#"
                                                                                                   class="expand collapsed"><i
                                                class="flag flag-en"></i> England</a>
                                        <ul class="level-3" style="display: none;">
                                            <li data-id="3280" class="tournaments list-group-item"><a
                                                    title="Championship" href="#"> Championship</a></li>
                                            <li data-id="5062" class="tournaments list-group-item"><a
                                                    title="Conference Premier - Winner" href="#"> Conference Premier -
                                                    Winner</a></li>
                                            <li data-id="3281" class="tournaments list-group-item"><a title="League One"
                                                                                                      href="#"> League
                                                    One</a></li>
                                            <li data-id="3283" class="tournaments list-group-item"><a title="League Two"
                                                                                                      href="#"> League
                                                    Two</a></li>
                                            <li data-id="5067" class="tournaments list-group-item"><a
                                                    title="Premier League - Relegation" href="#"> Premier League -
                                                    Relegation</a></li>
                                            <li data-id="5059" class="tournaments list-group-item"><a
                                                    title="Premier League - Top London Club" href="#"> Premier League -
                                                    Top London Club</a></li>
                                            <li data-id="5054" class="tournaments list-group-item"><a
                                                    title="Premier League - Winner" href="#"> Premier League -
                                                    Winner</a></li>
                                        </ul>
                                    </li>
                                    <li data-id="1149" class="groups list-group-item collapsed"><a title="France"
                                                                                                   href="#"
                                                                                                   class="expand collapsed"><i
                                                class="flag flag-fr"></i> France</a>
                                        <ul class="level-3" style="display: none;">
                                            <li data-id="5089" class="tournaments list-group-item"><a title="Ligue 2"
                                                                                                      href="#"> Ligue
                                                    2</a></li>
                                            <li data-id="3552" class="tournaments list-group-item"><a title="National"
                                                                                                      href="#">
                                                    National</a></li>
                                        </ul>
                                    </li>
                                    <li data-id="1102" class="groups list-group-item collapsed"><a title="Germany"
                                                                                                   href="#"
                                                                                                   class="expand collapsed"><i
                                                class="flag flag-de"></i> Germany</a>
                                        <ul class="level-3" style="display: none;">
                                            <li data-id="3294" class="tournaments list-group-item"><a
                                                    title="2nd Bundesliga" href="#"> 2nd Bundesliga</a></li>
                                            <li data-id="3055" class="tournaments list-group-item"><a title="3rd Liga"
                                                                                                      href="#"> 3rd
                                                    Liga</a></li>
                                            <li data-id="3554" class="tournaments list-group-item"><a title="Bundesliga"
                                                                                                      href="#">
                                                    Bundesliga</a></li>
                                            <li data-id="5125" class="tournaments list-group-item"><a
                                                    title="Bundesliga - Bottom 3" href="#"> Bundesliga - Bottom 3</a>
                                            </li>
                                            <li data-id="5124" class="tournaments list-group-item"><a
                                                    title="Bundesliga - Top goalscorer" href="#"> Bundesliga - Top
                                                    goalscorer</a></li>
                                            <li data-id="5123" class="tournaments list-group-item"><a
                                                    title="DFB Pokal - Winner" href="#"> DFB Pokal - Winner</a></li>
                                        </ul>
                                    </li>
                                    <li data-id="1150" class="groups list-group-item collapsed"><a title="Italy"
                                                                                                   href="#"
                                                                                                   class="expand collapsed"><i
                                                class="flag flag-it"></i> Italy</a>
                                        <ul class="level-3" style="display: none;">
                                            <li data-id="5127" class="tournaments list-group-item"><a
                                                    title="Serie A - Relegation" href="#"> Serie A - Relegation</a></li>
                                            <li data-id="4419" class="tournaments list-group-item"><a title="Serie B"
                                                                                                      href="#"> Serie
                                                    B</a></li>
                                        </ul>
                                    </li>
                                    <li data-id="1152" class="groups list-group-item collapsed"><a title="Netherlands"
                                                                                                   href="#"
                                                                                                   class="expand collapsed"><i
                                                class="flag flag-nl"></i> Netherlands</a>
                                        <ul class="level-3" style="display: none;">
                                            <li data-id="3295" class="tournaments list-group-item"><a
                                                    title="Eerste Divisie" href="#"> Eerste Divisie</a></li>
                                            <li data-id="5143" class="tournaments list-group-item"><a
                                                    title="Eredivisie - Winner" href="#"> Eredivisie - Winner</a></li>
                                        </ul>
                                    </li>
                                    <li data-id="1098" class="groups list-group-item collapsed"><a title="Scotland"
                                                                                                   href="#"
                                                                                                   class="expand collapsed"><i
                                                class="flag flag-sc"></i> Scotland</a>
                                        <ul class="level-3" style="display: none;">
                                            <li data-id="3285" class="tournaments list-group-item"><a
                                                    title="Premiership" href="#"> Premiership</a></li>
                                            <li data-id="5109" class="tournaments list-group-item"><a
                                                    title="Scottish League Cup" href="#"> Scottish League Cup</a></li>
                                        </ul>
                                    </li>
                                    <li data-id="1151" class="groups list-group-item collapsed"><a title="Spain"
                                                                                                   href="#"
                                                                                                   class="expand collapsed"><i
                                                class="flag flag-es"></i> Spain</a>
                                        <ul class="level-3" style="display: none;">
                                            <li data-id="3753" class="tournaments list-group-item"><a
                                                    title="Primera Division" href="#"> Primera Division</a></li>
                                            <li data-id="5134" class="tournaments list-group-item"><a
                                                    title="Primera Division - w/o Real Madrid &amp; FC Barcelona"
                                                    href="#"> Primera Division - w/o Real Madrid &amp; FC Barcelona</a>
                                            </li>
                                            <li data-id="3793" class="tournaments list-group-item"><a
                                                    title="Segunda B Group I" href="#"> Segunda B Group I</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li data-id="355" class="sports list-group-item collapsed"><a title="Winter Sports" href="#"
                                                                                          class="expand collapsed"><i
                                        class="sport-winter-sports"></i>Winter Sports</a>
                                <ul class="level-2" style="display: none;">
                                    <li data-id="1174" class="groups list-group-item collapsed"><a title="Alpine Men"
                                                                                                   href="#"
                                                                                                   class="expand collapsed"><i
                                                class="flag flag-false"></i> Alpine Men</a>
                                        <ul class="level-3" style="display: none;">
                                            <li data-id="6101" class="tournaments list-group-item"><a
                                                    title="Downhill - H2H" href="#"> Downhill - H2H</a></li>
                                            <li data-id="5316" class="tournaments list-group-item"><a
                                                    title="Giant Slalom Alta Badia - Winner" href="#"> Giant Slalom Alta
                                                    Badia - Winner</a></li>
                                            <li data-id="5319" class="tournaments list-group-item"><a
                                                    title="Slalom Madonna di Campiglio - Top 3" href="#"> Slalom Madonna
                                                    di Campiglio - Top 3</a></li>
                                            <li data-id="5273" class="tournaments list-group-item"><a
                                                    title="Super G Val Gardena / Groeden - Winner" href="#"> Super G Val
                                                    Gardena / Groeden - Winner</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>


            </div>
            <!-- sidebar-content -->
        </div>


        <div id="MiddleContainer" class="col-md-6 home-middle">
            <div id="odds-panel">
                <div class="panel panel-grid grid-top" id="TournamentGrid4826">
                    <div class="panel-heading soccer"><h2 class="grid-title">LNBP</h2></div>
                    <div class="panel-content leagues">
                        <table class="table table-responsive">
                            <thead>
                            <tr>
                                <th class="half">Pair</th>
                                <th class="text-center" colspan="2">1</th>
                                <th class="text-center" colspan="2">2</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr id="MatchRow254369" data-match="254369" title="2014-12-18T18:00:00+04:00"
                                hash="[object Object],[object Object]">
                                <td class="match_name"><a class="match-link" href="#">Panteras de Aguascalientes -
                                        Correcaminos Uat Victoria</a><span class="date">Thursday 18:00</span></td>
                                <td class="odd">
                                    <button class="oddBtn btn btn-odd-green br_tooltip" data-type="back"
                                            data-id="17678450" data-value="1.3" title="" id="BackOdd17678450"
                                            data-original-title="The best quota offered by Betradar is: 1.3">&nbsp;<br>&nbsp;
                                    </button>
                                </td>
                                <td class="odd">
                                    <button class="oddBtn btn btn-odd-blue br_tooltip" data-type="lay"
                                            data-id="17678450" data-value="1.3" title="" id="LayOdd17678450"
                                            data-original-title="The best quota offered by Betradar is: 1.3">&nbsp;<br>&nbsp;
                                    </button>
                                </td>
                                <td class="odd">
                                    <button class="oddBtn btn btn-odd-green br_tooltip" data-type="back"
                                            data-id="17678451" data-value="2.77" title="" id="BackOdd17678451"
                                            data-original-title="The best quota offered by Betradar is: 2.77">&nbsp;<br>&nbsp;
                                    </button>
                                </td>
                                <td class="odd">
                                    <button class="oddBtn btn btn-odd-blue br_tooltip" data-type="lay"
                                            data-id="17678451" data-value="2.77" title="" id="LayOdd17678451"
                                            data-original-title="The best quota offered by Betradar is: 2.77">&nbsp;<br>&nbsp;
                                    </button>
                                </td>
                            </tr>
                            <tr id="MatchRow254370" data-match="254370" title="2014-12-19T04:00:00+04:00"
                                hash="[object Object],[object Object]">
                                <td class="match_name"><a class="match-link" href="#">Gigantes Edomex - Abejas de
                                        Guanajuato</a><span class="date">Friday 04:00</span></td>
                                <td class="odd">
                                    <button class="oddBtn btn btn-odd-green br_tooltip" data-type="back"
                                            data-id="17678456" data-value="1.96" title="" id="BackOdd17678456"
                                            data-original-title="The best quota offered by Betradar is: 1.96">&nbsp;<br>&nbsp;
                                    </button>
                                </td>
                                <td class="odd">
                                    <button class="oddBtn btn btn-odd-blue br_tooltip" data-type="lay"
                                            data-id="17678456" data-value="1.96" title="" id="LayOdd17678456"
                                            data-original-title="The best quota offered by Betradar is: 1.96">&nbsp;<br>&nbsp;
                                    </button>
                                </td>
                                <td class="odd">
                                    <button class="oddBtn btn btn-odd-green br_tooltip" data-type="back"
                                            data-id="17678457" data-value="1.61" title="" id="BackOdd17678457"
                                            data-original-title="The best quota offered by Betradar is: 1.61">&nbsp;<br>&nbsp;
                                    </button>
                                </td>
                                <td class="odd">
                                    <button class="oddBtn btn btn-odd-blue br_tooltip" data-type="lay"
                                            data-id="17678457" data-value="1.61" title="" id="LayOdd17678457"
                                            data-original-title="The best quota offered by Betradar is: 1.61">&nbsp;<br>&nbsp;
                                    </button>
                                </td>
                            </tr>
                            <tr id="MatchRow253877" data-match="253877" title="2014-12-19T05:00:00+04:00"
                                hash="[object Object],[object Object]">
                                <td class="match_name"><a class="match-link" href="#">Halcones UV Xalapa - Fuerza
                                        Regia</a><span class="date">Friday 05:00</span></td>
                                <td class="odd">
                                    <button class="oddBtn btn btn-odd-green br_tooltip" data-type="back"
                                            data-id="17678454" data-value="1.5" title="" id="BackOdd17678454"
                                            data-original-title="The best quota offered by Betradar is: 1.5">&nbsp;<br>&nbsp;
                                    </button>
                                </td>
                                <td class="odd">
                                    <button class="oddBtn btn btn-odd-blue br_tooltip" data-type="lay"
                                            data-id="17678454" data-value="1.5" title="" id="LayOdd17678454"
                                            data-original-title="The best quota offered by Betradar is: 1.5">&nbsp;<br>&nbsp;
                                    </button>
                                </td>
                                <td class="odd">
                                    <button class="oddBtn btn btn-odd-green br_tooltip" data-type="back"
                                            data-id="17678455" data-value="2.17" title="" id="BackOdd17678455"
                                            data-original-title="The best quota offered by Betradar is: 2.17">&nbsp;<br>&nbsp;
                                    </button>
                                </td>
                                <td class="odd">
                                    <button class="oddBtn btn btn-odd-blue br_tooltip" data-type="lay"
                                            data-id="17678455" data-value="2.17" title="" id="LayOdd17678455"
                                            data-original-title="The best quota offered by Betradar is: 2.17">&nbsp;<br>&nbsp;
                                    </button>
                                </td>
                            </tr>
                            <tr id="MatchRow253860" data-match="253860" title="2014-12-19T05:30:00+04:00"
                                hash="[object Object],[object Object]">
                                <td class="match_name"><a class="match-link" href="#">Pioneros de Quintana Roo -
                                        Titanicos De Leon</a><span class="date">Friday 05:30</span></td>
                                <td class="odd">
                                    <button class="oddBtn btn btn-odd-green br_tooltip" data-type="back"
                                            data-id="17678452" data-value="1.18" title="" id="BackOdd17678452"
                                            data-original-title="The best quota offered by Betradar is: 1.18">&nbsp;<br>&nbsp;
                                    </button>
                                </td>
                                <td class="odd">
                                    <button class="oddBtn btn btn-odd-blue br_tooltip" data-type="lay"
                                            data-id="17678452" data-value="1.18" title="" id="LayOdd17678452"
                                            data-original-title="The best quota offered by Betradar is: 1.18">&nbsp;<br>&nbsp;
                                    </button>
                                </td>
                                <td class="odd">
                                    <button class="oddBtn btn btn-odd-green br_tooltip" data-type="back"
                                            data-id="17678453" data-value="3.56" title="" id="BackOdd17678453"
                                            data-original-title="The best quota offered by Betradar is: 3.56">&nbsp;<br>&nbsp;
                                    </button>
                                </td>
                                <td class="odd">
                                    <button class="oddBtn btn btn-odd-blue br_tooltip" data-type="lay"
                                            data-id="17678453" data-value="3.56" title="" id="LayOdd17678453"
                                            data-original-title="The best quota offered by Betradar is: 3.56">&nbsp;<br>&nbsp;
                                    </button>
                                </td>
                            </tr>
                            <tr id="MatchRow253879" data-match="253879" title="2014-12-19T05:30:00+04:00"
                                hash="[object Object],[object Object]">
                                <td class="match_name"><a class="match-link" href="#">Halcones Rojos - Jefes De Fuerza
                                        Lagunera</a><span class="date">Friday 05:30</span></td>
                                <td class="odd">
                                    <button class="oddBtn btn btn-odd-green br_tooltip" data-type="back"
                                            data-id="17678448" data-value="1.3" title="" id="BackOdd17678448"
                                            data-original-title="The best quota offered by Betradar is: 1.3">&nbsp;<br>&nbsp;
                                    </button>
                                </td>
                                <td class="odd">
                                    <button class="oddBtn btn btn-odd-blue br_tooltip" data-type="lay"
                                            data-id="17678448" data-value="1.3" title="" id="LayOdd17678448"
                                            data-original-title="The best quota offered by Betradar is: 1.3">&nbsp;<br>&nbsp;
                                    </button>
                                </td>
                                <td class="odd">
                                    <button class="oddBtn btn btn-odd-green br_tooltip" data-type="back"
                                            data-id="17678449" data-value="2.77" title="" id="BackOdd17678449"
                                            data-original-title="The best quota offered by Betradar is: 2.77">&nbsp;<br>&nbsp;
                                    </button>
                                </td>
                                <td class="odd">
                                    <button class="oddBtn btn btn-odd-blue br_tooltip" data-type="lay"
                                            data-id="17678449" data-value="2.77" title="" id="LayOdd17678449"
                                            data-original-title="The best quota offered by Betradar is: 2.77">&nbsp;<br>&nbsp;
                                    </button>
                                </td>
                            </tr>
                            <tr id="MatchRow254371" data-match="254371" title="2014-12-19T05:30:00+04:00"
                                hash="[object Object],[object Object]">
                                <td class="match_name"><a class="match-link" href="#">Barreteros De Zacatecas -
                                        Huracanes de Tampico</a><span class="date">Friday 05:30</span></td>
                                <td class="odd">
                                    <button class="oddBtn btn btn-odd-green br_tooltip" data-type="back"
                                            data-id="17678458" data-value="3.22" title="" id="BackOdd17678458"
                                            data-original-title="The best quota offered by Betradar is: 3.22">&nbsp;<br>&nbsp;
                                    </button>
                                </td>
                                <td class="odd">
                                    <button class="oddBtn btn btn-odd-blue br_tooltip" data-type="lay"
                                            data-id="17678458" data-value="3.22" title="" id="LayOdd17678458"
                                            data-original-title="The best quota offered by Betradar is: 3.22">&nbsp;<br>&nbsp;
                                    </button>
                                </td>
                                <td class="odd">
                                    <button class="oddBtn btn btn-odd-green br_tooltip" data-type="back"
                                            data-id="17678459" data-value="1.22" title="" id="BackOdd17678459"
                                            data-original-title="The best quota offered by Betradar is: 1.22">&nbsp;<br>&nbsp;
                                    </button>
                                </td>
                                <td class="odd">
                                    <button class="oddBtn btn btn-odd-blue br_tooltip" data-type="lay"
                                            data-id="17678459" data-value="1.22" title="" id="LayOdd17678459"
                                            data-original-title="The best quota offered by Betradar is: 1.22">&nbsp;<br>&nbsp;
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 right-sidebar">
            <div id="undefined-sticky-wrapper" class="sticky-wrapper" style="height: 100px;">
                <div class="panel betslip">
                    <div class="panel-heading">Betslip</div>
                    <div class="panel-body has-error empty" id="BetSlip">
                        <!--div class="betslip-message error">
                            Odds between 10 and 20 must be in increments of 0.5. Your odds have beeen updated accordingly.
                        </div>-->
                        <!-- <div class="placeholder">Place Your Bets</div> -->
                        <div class="betslip_back">
                            <div class="container-fluid">
                                <div class="row no-padding" id="back_title">
                                    <div class="col-th col-md-6"></div>
                                    <div class="col-th col-md-2">Odds</div>
                                    <div class="col-th col-md-2">Stake($)</div>
                                    <div class="col-th col-md-2 profit">Profit($)</div>
                                </div>
                            </div>
                            <div class="odds_holder" id="BackBets"></div>
                        </div>
                        <div class="betslip_lay">
                            <div class="container-fluid">
                                <div class="row no-padding" id="lay_title">
                                    <div class="col-th col-md-6"></div>
                                    <div class="col-th col-md-2">Backer's odds</div>
                                    <div class="col-th col-md-2">Backer's Stake</div>
                                    <div class="col-th col-md-2 profit">Your liability</div>
                                </div>
                            </div>
                            <div class="odds_holder" id="LayBets"></div>
                        </div>
                        <div class="betslip-buttons">

                            <div class="liability">
                                Liability: <span class="liability-total" id="Liability">0.00$</span>
                            </div>

                            <input id="ClearBetSlipBtn" type="button" class="btn btn-dark betslipButton clear"
                                   value="Clear Bets">
                            <input id="PlaceBetBtn" type="button" class="btn btn-silver betslipButton place"
                                   value="Place Bets">
                        </div>
                        <span id="betlip_placeholder" class="betlip_placeholder">Make your selection(s) on the left by clicking on the odds.</span>
                    </div>
                </div>
            </div>

            <!--<div class="panel promotions">
                <div class="panel-heading">Promotions</div>
                <div class="panel-body">
                    <div class="promotion">
                        <img class="img-responsive img-rounded" src="http://assets.cdnbf.net/ssw/June%20/BGAMEPRO-95_arcade_336x112.jpg" />
                    </div>
                    <div class="promotion">
                        <img class="img-responsive img-rounded" src="http://assets.cdnbf.net/ssw/June%20/BGAMEPRO-9_poker_XSellExhange-A-336x112.jpg" />
                    </div>
                </div>
            </div>-->

        </div>


    </div>
    <!-- row -->
</div>
<!-- container -->

<div class="push"></div>
</div>

<?php
include "includes/footer.php";
?>