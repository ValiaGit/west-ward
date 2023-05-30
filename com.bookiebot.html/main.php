<?php
$page_body_class = "page-home";
include "includes/header.php";
?>

<div class="wrapper" id="root">
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
							<li class="active">
								<a href="http://bookiebot.com/en">
									<i class="icon icon-betting"></i>
									<span class="text">BETTING</span>
								</a>
							</li>
							<li>
								<a href="http://bookiebot.com/en/social">
									<i class="icon icon-social"></i>
									<span class="text">PEOPLE</span>
								</a>
							</li>
						</ul>
						<li>
								<a href="http://localhost/westward/com.bookiebot.html/feed.php">
									<i class="icon icon-social"></i>
									<span class="text">Feedback</span>
								</a>
							</li>

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
							<li><a href="http://bookiebot.com/en/page/show/about_us">About Us</a></li>
							<li><a href="http://bookiebot.com/en/page/show/what_is_betstock">How Make Bets</a></li>
							<li><a href="http://bookiebot.com/en/blog">FAQ</a></li>
						</ul>

						<form class="navbar-form form-login navbar-right hidden" method="post" id="loginForm"
							  novalidate="novalidate" autocomplete="off" onsubmit="Session.login(this);return false;">
							<div class="form-group">
								<input type="text" name="username" placeholder="Username or Email" autocomplete="off"
									   class="form-control input-small input-sm" autofocus>
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


	<div class="navbar navbar-default navbar-sub-header">
		<div class="container">


			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-6">
					<div class="current-time">
						<strong>10:46:55</strong> Jan.07,2015
					</div>
					<!-- current time -->
				</div>
				<!-- cold -->
				<div class="col-md-6 col-sm-6 col-xs-6 text-right hidden" id="forgot_register" style="display: none;">
					<a href="#" onclick="ForgotPass.openDialog();return false;"> Forgot your password?</a>
					<a class="blue" href="#" onclick="Registration.openDialog();return false;">Register Now!</a>
				</div>

				<div class="col-md-6 col-sm-6 col-xs-6 text-right" id="userData" style="display: block;">
					<span class="profile-label">Welcome, </span>
					<a class="profile-label bold cap blue" href="http://bookiebot.com/en/user/settings">peter </a>&nbsp;&nbsp;UserId:82&nbsp;&nbsp;
					<span class="profile-label">Balance:</span>
					<span class="profile-label bold"> 49156.59$</span>
				</div>
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
								<li data-id="5871" class="popular sports list-group-item collapsed"><a
										title="FIFA Club World Cup" href="#">FIFA Club World Cup</a></li>
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
										<li data-id="1084" class="groups list-group-item collapsed"><a title="International" href="#"
																									   class="expand collapsed"><i
													class="flag flag-false"></i> International</a>
											<ul class="level-3" style="display: none;">
												<li data-id="5177" class="tournaments list-group-item"><a title="Euroleague" href="#">
														Euroleague</a></li>
												<li data-id="4804" class="tournaments list-group-item"><a title="Euroleague, Group A" href="#">
														Euroleague, Group A</a></li>
												<li data-id="4810" class="tournaments list-group-item"><a title="Euroleague, Group D" href="#">
														Euroleague, Group D</a></li>
											</ul>
										</li>
										<li data-id="1132" class="groups list-group-item expanded"><a title="USA" href="#"
																									  class="expand expanded"><i
													class="flag flag-us"></i> USA</a>
											<ul class="level-3" style="display: block;">
												<li data-id="5172" class="tournaments list-group-item"><a
														title="NBA 2014/15 - Conference Western - Winner" href="#"> NBA 2014/15 - Conference
														Western - Winner</a></li>
												<li data-id="5623" class="tournaments list-group-item"><a title="NCAA Men" href="#"> NCAA
														Men</a></li>
											</ul>
										</li>
									</ul>
								</li>
								<li data-id="339" class="sports list-group-item expanded"><a title="Rugby" href="#" class="expand expanded"><i
											class="sport-rugby"></i>Rugby</a>
									<ul class="level-2" style="display: block;">
										<li data-id="1075" class="groups list-group-item collapsed"><a title="Rugby Union" href="#"
																									   class="expand collapsed"><i
													class="flag flag-false"></i> Rugby Union</a>
											<ul class="level-3" style="display: none;">
												<li data-id="5265" class="tournaments list-group-item"><a title="European Rugby Champions Cup"
																										  href="#"> European Rugby Champions
														Cup</a></li>
												<li data-id="4026" class="tournaments list-group-item"><a title="Pro D2" href="#"> Pro D2</a>
												</li>
											</ul>
										</li>
									</ul>
								</li>
								<li data-id="357" class="sports list-group-item expanded"><a title="Snooker" href="#" class="expand expanded"><i
											class="sport-snooker"></i>Snooker</a>
									<ul class="level-2" style="display: block;">
										<li data-id="1183" class="groups list-group-item collapsed"><a title="International" href="#"
																									   class="expand collapsed"><i
													class="flag flag-false"></i> International</a>
											<ul class="level-3" style="display: none;">
												<li data-id="6264" class="tournaments list-group-item"><a title="German Masters Qualifiers 2015"
																										  href="#"> German Masters Qualifiers
														2015</a></li>
												<li data-id="5299" class="tournaments list-group-item"><a title="The Masters - Winner" href="#">
														The Masters - Winner</a></li>
											</ul>
										</li>
									</ul>
								</li>
								<li data-id="336" class="sports list-group-item collapsed"><a title="Soccer" href="#"
																							  class="expand collapsed"><i
											class="sport-soccer"></i>Soccer</a>
									<ul class="level-2" style="display: none;">
										<li data-id="1147" class="groups list-group-item collapsed"><a title="England" href="#"
																									   class="expand collapsed"><i
													class="flag flag-en"></i> England</a>
											<ul class="level-3" style="display: none;">
												<li data-id="3280" class="tournaments list-group-item"><a title="Championship" href="#">
														Championship</a></li>
												<li data-id="3282" class="tournaments list-group-item"><a title="Conference National" href="#">
														Conference National</a></li>
												<li data-id="5062" class="tournaments list-group-item"><a title="Conference Premier - Winner"
																										  href="#"> Conference Premier -
														Winner</a></li>
												<li data-id="5064" class="tournaments list-group-item"><a title="FA Cup 2014/15 - Winner"
																										  href="#"> FA Cup 2014/15 - Winner</a>
												</li>
											</ul>
										</li>
										<li data-id="1102" class="groups list-group-item expanded"><a title="Germany" href="#"
																									  class="expand expanded"><i
													class="flag flag-de"></i> Germany</a>
											<ul class="level-3" style="display: block;">
												<li data-id="3294" class="tournaments list-group-item"><a title="2. Bundesliga" href="#"> 2.
														Bundesliga</a></li>
												<li data-id="5119" class="tournaments list-group-item"><a
														title="Bundesliga 2014/15 - w/o FC Bayern Munich - Winner" href="#"> Bundesliga 2014/15
														- w/o FC Bayern Munich - Winner</a></li>
											</ul>
										</li>
										<li data-id="1148" class="groups list-group-item expanded"><a title="International" href="#"
																									  class="expand expanded"><i
													class="flag flag-false"></i> International</a>
											<ul class="level-3" style="display: block;">
												<li data-id="5080" class="tournaments list-group-item"><a title="null" href="#"> null</a></li>
												<li data-id="6337" class="tournaments list-group-item"><a title="AFC Asian Cup, Group D"
																										  href="#"> AFC Asian Cup, Group D</a>
												</li>
											</ul>
										</li>
										<li data-id="1088" class="groups list-group-item collapsed"><a title="International Youth" href="#"
																									   class="expand collapsed"><i
													class="flag flag-false"></i> International Youth</a>
											<ul class="level-3" style="display: none;">
												<li data-id="4411" class="tournaments list-group-item"><a title="U18 Friendly Games" href="#">
														U18 Friendly Games</a></li>
												<li data-id="5163" class="tournaments list-group-item"><a
														title="U21 European Championship 2015 - Group B - Winner" href="#"> U21 European
														Championship 2015 - Group B - Winner</a></li>
											</ul>
										</li>
										<li data-id="1150" class="groups list-group-item expanded"><a title="Italy" href="#"
																									  class="expand expanded"><i
													class="flag flag-it"></i> Italy</a>
											<ul class="level-3" style="display: block;">
												<li data-id="5128" class="tournaments list-group-item"><a title="Coppa Italia" href="#"> Coppa
														Italia</a></li>
												<li data-id="4419" class="tournaments list-group-item"><a title="Serie B" href="#"> Serie B</a>
												</li>
											</ul>
										</li>
										<li data-id="1098" class="groups list-group-item collapsed"><a title="Scotland" href="#"
																									   class="expand collapsed"><i
													class="flag flag-sc"></i> Scotland</a>
											<ul class="level-3" style="display: none;">
												<li data-id="3287" class="tournaments list-group-item"><a title="League One" href="#"> League
														One</a></li>
												<li data-id="5113" class="tournaments list-group-item"><a
														title="Premier League 2014/15 - Winner" href="#"> Premier League 2014/15 - Winner</a>
												</li>
											</ul>
										</li>
										<li data-id="1151" class="groups list-group-item collapsed"><a title="Spain" href="#"
																									   class="expand collapsed"><i
													class="flag flag-es"></i> Spain</a>
											<ul class="level-3" style="display: none;">
												<li data-id="5132" class="tournaments list-group-item"><a title="Copa Del Rey 2014/15 - Winner"
																										  href="#"> Copa Del Rey 2014/15 -
														Winner</a></li>
												<li data-id="3753" class="tournaments list-group-item"><a title="Primera Division" href="#">
														Primera Division</a></li>
												<li data-id="5133" class="tournaments list-group-item"><a
														title="Primera Division 2014/15 - Top Goalscorer" href="#"> Primera Division 2014/15 -
														Top Goalscorer</a></li>
												<li data-id="5134" class="tournaments list-group-item"><a
														title="Primera Division 2014/15 - w/o Real &amp; Barca" href="#"> Primera Division
														2014/15 - w/o Real &amp; Barca</a></li>
												<li data-id="5135" class="tournaments list-group-item"><a
														title="Primera Division 2014/15 - Winner" href="#"> Primera Division 2014/15 -
														Winner</a></li>
												<li data-id="3794" class="tournaments list-group-item"><a title="Segunda B Group II" href="#">
														Segunda B Group II</a></li>
												<li data-id="3754" class="tournaments list-group-item"><a title="Segunda Division" href="#">
														Segunda Division</a></li>
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
				<div id="odds-panel-sticky-wrapper" class="sticky-wrapper" style="height: 0px;">
					<div id="odds-panel"></div>
				</div>
				<div class="panel panel-grid grid-top">
					<div class="panel-heading clearfix"><h2 class="grid-title">Top Matches</h2>
						<ul class="nav nav-tabs" id="top_matches_tabs">
							<li class="active"><a href="#sport-336" data-toggle="tab">Soccer</a></li>
							<li class=""><a href="#sport-353" data-toggle="tab">Handball</a></li>
							<li class=""><a href="#sport-355" data-toggle="tab">Winter Sports</a></li>
						</ul>
					</div>
					<div class="tab-content" id="top_matches_content">
						<div class="tab-pane active" id="sport-336">
							<div class="panel panel-grid grid-top" id="TournamentGrid336">
								<div class="panel-content leagues">
									<table class="table table-responsive">
										<thead>
										<tr>
											<th class="half">Pair</th>
											<th class="text-center" colspan="2">1</th>
											<th class="text-center" colspan="2">X</th>
											<th class="text-center" colspan="2">2</th>
										</tr>
										</thead>
										<tbody>
										<tr id="MatchRow254185" data-match="254185" title="2014-12-20T18:00:00+04:00"
											hash="[object Object],[object Object],[object Object]">
											<td class="match_name"><a class="match-link" href="#">Rochdale FC - Notts
													County</a><span class="date">Saturday 18:00</span></td>
											<td class="odd">
												<button class="oddBtn btn btn-odd-green br_tooltip" data-type="back"
														data-id="17383666" data-value="1.85" title="" id="BackOdd17383666"
														data-original-title="The best quota offered by Betradar is: 1.85">
													&nbsp;<br>&nbsp;</button>
											</td>
											<td class="odd">
												<button class="oddBtn btn btn-odd-blue" data-type="lay" data-id="17383666"
														data-value="2.40" title="" id="LayOdd17383666">2.40<br>5.00$
												</button>
											</td>
											<td class="odd">
												<button class="oddBtn btn btn-odd-green br_tooltip" data-type="back"
														data-id="17383667" data-value="3.21" title="" id="BackOdd17383667"
														data-original-title="The best quota offered by Betradar is: 3.21">
													&nbsp;<br>&nbsp;</button>
											</td>
											<td class="odd">
												<button class="oddBtn btn btn-odd-blue br_tooltip" data-type="lay"
														data-id="17383667" data-value="3.21" title="" id="LayOdd17383667"
														data-original-title="The best quota offered by Betradar is: 3.21">
													&nbsp;<br>&nbsp;</button>
											</td>
											<td class="odd">
												<button class="oddBtn btn btn-odd-green br_tooltip" data-type="back"
														data-id="17383668" data-value="3.61" title="" id="BackOdd17383668"
														data-original-title="The best quota offered by Betradar is: 3.61">
													&nbsp;<br>&nbsp;</button>
											</td>
											<td class="odd">
												<button class="oddBtn btn btn-odd-blue br_tooltip" data-type="lay"
														data-id="17383668" data-value="3.61" title="" id="LayOdd17383668"
														data-original-title="The best quota offered by Betradar is: 3.61">
													&nbsp;<br>&nbsp;</button>
											</td>
										</tr>
										<tr id="MatchRow253731" data-match="253731" title="2014-12-20T22:00:00+04:00"
											hash="[object Object],[object Object],[object Object]">
											<td class="match_name"><a class="match-link" href="#">Stade Rennes - Stade
													Reims</a><span class="date">Saturday 22:00</span></td>
											<td class="odd">
												<button class="oddBtn btn btn-odd-green br_tooltip selected"
														data-type="back" data-id="17386834" data-value="1.73" title=""
														id="BackOdd17386834"
														data-original-title="The best quota offered by Betradar is: 1.73">
													&nbsp;<br>&nbsp;</button>
											</td>
											<td class="odd">
												<button class="oddBtn btn btn-odd-blue br_tooltip" data-type="lay"
														data-id="17386834" data-value="1.73" title="" id="LayOdd17386834"
														data-original-title="The best quota offered by Betradar is: 1.73">
													&nbsp;<br>&nbsp;</button>
											</td>
											<td class="odd">
												<button class="oddBtn btn btn-odd-green br_tooltip" data-type="back"
														data-id="17386835" data-value="3.17" title="" id="BackOdd17386835"
														data-original-title="The best quota offered by Betradar is: 3.17">
													&nbsp;<br>&nbsp;</button>
											</td>
											<td class="odd">
												<button class="oddBtn btn btn-odd-blue br_tooltip" data-type="lay"
														data-id="17386835" data-value="3.17" title="" id="LayOdd17386835"
														data-original-title="The best quota offered by Betradar is: 3.17">
													&nbsp;<br>&nbsp;</button>
											</td>
											<td class="odd">
												<button class="oddBtn btn btn-odd-green br_tooltip" data-type="back"
														data-id="17386836" data-value="4.21" title="" id="BackOdd17386836"
														data-original-title="The best quota offered by Betradar is: 4.21">
													&nbsp;<br>&nbsp;</button>
											</td>
											<td class="odd">
												<button class="oddBtn btn btn-odd-blue br_tooltip" data-type="lay"
														data-id="17386836" data-value="4.21" title="" id="LayOdd17386836"
														data-original-title="The best quota offered by Betradar is: 4.21">
													&nbsp;<br>&nbsp;</button>
											</td>
										</tr>
										<tr id="MatchRow253337" data-match="253337" title="2014-12-26T15:45:00+04:00"
											hash="[object Object],[object Object],[object Object]">
											<td class="match_name"><a class="match-link" href="#">Chelsea FC - West Ham
													Utd</a><span class="date">Friday 15:45</span></td>
											<td class="odd">
												<button class="oddBtn btn btn-odd-green br_tooltip" data-type="back"
														data-id="17293922" data-value="1.28" title="" id="BackOdd17293922"
														data-original-title="The best quota offered by Betradar is: 1.28">
													&nbsp;<br>&nbsp;</button>
											</td>
											<td class="odd">
												<button class="oddBtn btn btn-odd-blue br_tooltip selected" data-type="lay"
														data-id="17293922" data-value="1.28" title="" id="LayOdd17293922"
														data-original-title="The best quota offered by Betradar is: 1.28">
													&nbsp;<br>&nbsp;</button>
											</td>
											<td class="odd">
												<button class="oddBtn btn btn-odd-green br_tooltip" data-type="back"
														data-id="17293923" data-value="4.48" title="" id="BackOdd17293923"
														data-original-title="The best quota offered by Betradar is: 4.48">
													&nbsp;<br>&nbsp;</button>
											</td>
											<td class="odd">
												<button class="oddBtn btn btn-odd-blue br_tooltip" data-type="lay"
														data-id="17293923" data-value="4.48" title="" id="LayOdd17293923"
														data-original-title="The best quota offered by Betradar is: 4.48">
													&nbsp;<br>&nbsp;</button>
											</td>
											<td class="odd">
												<button class="oddBtn btn btn-odd-green br_tooltip" data-type="back"
														data-id="17293924" data-value="7.86" title="" id="BackOdd17293924"
														data-original-title="The best quota offered by Betradar is: 7.86">
													&nbsp;<br>&nbsp;</button>
											</td>
											<td class="odd">
												<button class="oddBtn btn btn-odd-blue br_tooltip" data-type="lay"
														data-id="17293924" data-value="7.86" title="" id="LayOdd17293924"
														data-original-title="The best quota offered by Betradar is: 7.86">
													&nbsp;<br>&nbsp;</button>
											</td>
										</tr>
										<tr id="MatchRow253331" data-match="253331" title="2014-12-26T20:30:00+04:00"
											hash="[object Object],[object Object],[object Object]">
											<td class="match_name"><a class="match-link" href="#">Arsenal FC - Queens Park
													Rangers</a><span class="date">Friday 20:30</span></td>
											<td class="odd">
												<button class="oddBtn btn btn-odd-green br_tooltip" data-type="back"
														data-id="17293885" data-value="1.22" title="" id="BackOdd17293885"
														data-original-title="The best quota offered by Betradar is: 1.22">
													&nbsp;<br>&nbsp;</button>
											</td>
											<td class="odd">
												<button class="oddBtn btn btn-odd-blue br_tooltip" data-type="lay"
														data-id="17293885" data-value="1.22" title="" id="LayOdd17293885"
														data-original-title="The best quota offered by Betradar is: 1.22">
													&nbsp;<br>&nbsp;</button>
											</td>
											<td class="odd">
												<button class="oddBtn btn btn-odd-green br_tooltip" data-type="back"
														data-id="17293886" data-value="4.94" title="" id="BackOdd17293886"
														data-original-title="The best quota offered by Betradar is: 4.94">
													&nbsp;<br>&nbsp;</button>
											</td>
											<td class="odd">
												<button class="oddBtn btn btn-odd-blue br_tooltip" data-type="lay"
														data-id="17293886" data-value="4.94" title="" id="LayOdd17293886"
														data-original-title="The best quota offered by Betradar is: 4.94">
													&nbsp;<br>&nbsp;</button>
											</td>
											<td class="odd">
												<button class="oddBtn btn btn-odd-green br_tooltip" data-type="back"
														data-id="17293887" data-value="9.01" title="" id="BackOdd17293887"
														data-original-title="The best quota offered by Betradar is: 9.01">
													&nbsp;<br>&nbsp;</button>
											</td>
											<td class="odd">
												<button class="oddBtn btn btn-odd-blue br_tooltip" data-type="lay"
														data-id="17293887" data-value="9.01" title="" id="LayOdd17293887"
														data-original-title="The best quota offered by Betradar is: 9.01">
													&nbsp;<br>&nbsp;</button>
											</td>
										</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="tab-pane " id="sport-353">
							<div class="panel panel-grid grid-top" id="TournamentGrid353">
								<div class="panel-content leagues">
									<table class="table table-responsive">
										<thead>
										<tr>
											<th class="half">Pair</th>
										</tr>
										</thead>
										<tbody>
										<tr id="MatchRow254361" data-match="254361" title="2014-12-20T21:00:00+04:00"
											hash="">
											<td class="match_name"><a class="match-link" href="#">HC Erlangen - SC
													Magdeburg</a><span class="date">Saturday 21:00</span></td>
										</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="tab-pane " id="sport-355">
							<div class="panel panel-grid grid-top" id="TournamentGrid355">
								<div class="panel-content leagues">
									<table class="table table-responsive">
										<thead>
										<tr>
											<th class="half">Pair</th>
										</tr>
										</thead>
										<tbody>
										<tr id="MatchRow254743" data-match="254743" title="2014-12-18T16:25:00+04:00" hash="">
											<td class="match_name">
												<a class="match-link" href="#">Wierer, Dorothea - Soukalova, Gabriela</a>
												<span class="date">Thursday 16:25</span>
											</td>
										</tr>
										<tr id="MatchRow254757" data-match="254757" title="2014-12-18T16:25:00+04:00" hash="">
											<td class="match_name">
												<a class="match-link" href="#">Gossner, Miriam - Preuss, Franziska</a>
												<span class="date">Thursday 16:25</span>
											</td>
										</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- TODO -->
			<div class="col-md-3 right-sidebar">
				<div id="undefined-sticky-wrapper" class="sticky-wrapper" style="height: 100px;">
					<div class="panel betslip">
						<div class="panel-heading">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#betslip-1" data-toggle="tab">System</a></li>
								<li><a href="#betslip-2" data-toggle="tab">Active bets</a></li>
								<li><a href="#betslip-3" data-toggle="tab">Requests <em>(1)</em></a></li>
							</ul>
						</div>

						<div class="tab-content">
							<div class="tab-pane active" id="betslip-1">
								<div class="panel-body has-error has-back has-lay" id="BetSlip">
									<div class="betslip_back">
										<div class="container-fluid">
											<div class="row no-padding" id="back_title">
												<div class="col-th col-md-6"><em>Back</em></div>
												<div class="col-th col-md-2">Odds</div>
												<div class="col-th col-md-2">Stake</div>
												<div class="col-th col-md-2 profit">Profit</div>
											</div>
										</div>
										<div class="odds_holder" id="BackBets">
											<div class="ticket_wrapper" id="BackBet17386834" data-id="17386834" data-type="back">
												<div class="ticket_header row">
													<div class="ticket_title col-md-10">Stade Rennes - Stade Reims</div>
													<div class="ticket_buttons col-md-2">
														<a href="#" class="btn-icon"><i class="icon icon-betslip-profile"></i></a>
														<a href="#" class="btn-icon"><i class="icon icon-betslip-delete"></i></a>
													</div>
												</div>
												<div class="ticket_item row">
													<div class="col-md-6 div-team text-hidden">
														<em>Match Odds</em>
														<em>Stade Rennes</em>
													</div>
													<div class="col-bs col-md-2">
														<div class="betslip-spinner">
															<input type="text" class="input-bs input-xs input-odd" value="1.73" title="">
															<span class="num-btn up">&nbsp;</span>
															<span class="num-btn down">&nbsp;</span>
														</div>
													</div>
													<div class="col-bs col-md-2">
														<input type="text" class="input-bs input-stake" value="" title="">
													</div>
													<div class="col-bs col-md-2 profit">$0.00</div>
												</div>
											</div>

											<div class="ticket_wrapper" id="BackBet17386835" data-id="17386835" data-type="back">
												<div class="ticket_header row">
													<div class="ticket_title col-md-10">Stade Rennes - Stade Reims</div>
													<div class="ticket_buttons col-md-2">
														<a href="#" class="btn-icon"><i class="icon icon-betslip-profile"></i></a>
														<a href="#" class="btn-icon"><i class="icon icon-betslip-delete"></i></a>
													</div>
												</div>
												<div class="ticket_item row">
													<div class="col-md-6 div-team text-hidden">
														<em>Match Odds</em>
														<em>Stade Rennes</em>
													</div>
													<div class="col-bs col-md-2">
														<div class="betslip-spinner">
															<input type="text" class="input-bs input-xs input-odd" value="1.73" title="">
															<span class="num-btn up">&nbsp;</span>
															<span class="num-btn down">&nbsp;</span>
														</div>
													</div>
													<div class="col-bs col-md-2">
														<input type="text" class="input-bs input-stake" value="" title="">
													</div>
													<div class="col-bs col-md-2 profit">$0.00</div>
												</div>
											</div>
										</div>
									</div>

									<div class="betslip_lay">
										<div class="container-fluid">
											<div class="row no-padding" id="lay_title">
												<div class="col-th col-md-6"><em>Lay</em></div>
												<div class="col-th col-md-2">Odds</div>
												<div class="col-th col-md-2">Stake</div>
												<div class="col-th col-md-2 profit">Profit</div>
											</div>
										</div>

										<div class="odds_holder" id="LayBets">
											<div class="ticket_wrapper" id="LayBet17293922" data-id="17293922" data-type="lay">
												<div class="ticket_header row">
													<div class="ticket_title col-md-10">Chelsea FC - West Ham Utd</div>
													<div class="ticket_buttons col-md-2">
														<a href="#" class="btn-icon"><i class="icon icon-betslip-profile"></i></a>
														<a href="#" class="btn-icon"><i class="icon icon-betslip-delete"></i></a>
													</div>
												</div>
												<div class="ticket_item row">
													<div class="col-md-6 div-team text-hidden">
														<em>Match Odds</em>
														<em>Stade Rennes</em>
													</div>
													<div class="col-bs col-md-2">
														<div class="betslip-spinner">
															<input type="text" class="input-bs input-xs input-odd" value="1.73" title="">
															<span class="num-btn up">&nbsp;</span>
															<span class="num-btn down">&nbsp;</span>
														</div>
													</div>
													<div class="col-bs col-md-2">
														<input type="text" class="input-bs input-stake" value="" title="">
													</div>
													<div class="col-bs col-md-2 profit">$0.00</div>
												</div>
											</div>
										</div>
									</div>

									<div class="betslip-buttons">
										<div class="liability">Liability: <span class="liability-total" id="Liability">0.00$</span></div>
										<input id="ClearBetSlipBtn" type="button" class="btn btn-dark betslipButton clear" value="Cancel">
										<input id="PlaceBetBtn" type="button" class="btn btn-bs-blue betslipButton place" value="Place Bets">
									</div>

									<span id="betlip_placeholder" class="betlip_placeholder">Make your selection(s) on the left by clicking on the odds.</span>
								</div>
							</div>

							<div class="tab-pane" id="betslip-2">
								<div class="panel-body">
									TAB #2
								</div>
							</div>

							<div class="tab-pane" id="betslip-3">
								<div class="panel-body">
									TAB #3
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- TODO -->


		</div>
		<!-- row -->
	</div>
	<!-- container -->

	<div id="root_footer"></div>
</div>
<!-- wrapper -->

<?php
include "includes/footer.php";
?>
