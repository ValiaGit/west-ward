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
                                            <li class="text-right">
                                                <a href="http://bookiebot.com/en/user/balance_management">Balance
                                                    Management</a></li>
                                            <li class="text-right active">
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
                        <strong>11:30:50</strong> Jan.07,2015
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
        <li class="active">
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

    <div class="panel panel-default panel-profile">

    <div class="container-fluid">
    <div class="row">
    <div class="col-md-6">
    <h2 class="panel-title">Account Settings</h2>
    <hr>
    <div class="container-fluid profile-section">
    <div class="row">

    <div class="_col-md-5 _col-md-offset-3">
    <form role="form" class="form-horizontal" id="info_form">
    <div class="form-group">
        <label class="control-label col-md-3">Username:</label>

        <div class="col-md-9">
            <input type="text" class="form-control input-default" disabled="" id="field_username" name="field_username">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3">First name:</label>

        <div class="col-md-9">
            <input type="text" class="form-control input-default" disabled="" id="field_first_name"
                   name="field_first_name">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3">Last name:</label>

        <div class="col-md-9">
            <input type="text" class="form-control input-default" disabled="" id="field_last_name"
                   name="field_last_name">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3">Birth Date:</label>

        <div class="col-md-9">
            <input type="text" class="form-control input-default" disabled="" id="field_birthdate"
                   name="field_birthdate">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3">Nickname:</label>

        <div class="col-md-9">
            <input type="text" class="form-control input-default" id="field_nickname" name="field_nickname">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3">Mobile:</label>

        <div class="col-md-9">
            <input type="text" class="form-control input-default" id="field_phone" name="field_phone">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3">Email:</label>

        <div class="col-md-9">
            <input type="text" class="form-control input-default" id="field_email" name="field_email">
        </div>
    </div>
    <div class="form-group">
    <label class="control-label col-md-3">Country:</label>

    <div class="col-md-9">
    <select name="field_country" class="custom-select" id="field_country"
            data-name="field_country" title="" tabindex="-1">

    <option value="1">Albania</option>
    <option value="2">Algeria</option>
    <option value="3">Albania</option>
    <option value="4">Algeria</option>
    <option value="5">American Samoa</option>
    <option value="6">Andorra</option>
    <option value="7">Angola</option>
    <option value="8">Anguilla</option>
    <option value="9">Antarctica</option>
    <option value="10">Antigua and Barbuda</option>
    <option value="11">Argentina</option>
    <option value="12">Armenia</option>
    <option value="13">Aruba</option>
    <option value="14">Australia</option>
    <option value="15">Austria</option>
    <option value="16">Azerbaijan</option>
    <option value="17">Bahamas</option>
    <option value="18">Bahrain</option>
    <option value="19">Bangladesh</option>
    <option value="20">Barbados</option>
    <option value="21">Belarus</option>
    <option value="22">Belgium</option>
    <option value="23">Belize</option>
    <option value="24">Benin</option>
    <option value="25">Bermuda</option>
    <option value="26">Bhutan</option>
    <option value="27">Bolivia</option>
    <option value="28">Bonaire, Sint Eustatius and Saba</option>
    <option value="29">Bosnia and Herzegovina</option>
    <option value="30">Botswana</option>
    <option value="31">Bouvet Island</option>
    <option value="32">Brazil</option>
    <option value="33">British Indian Ocean Territory</option>
    <option value="34">Brunei</option>
    <option value="35">Bulgaria</option>
    <option value="36">Burkina Faso</option>
    <option value="37">Burundi</option>
    <option value="38">Cambodia</option>
    <option value="39">Cameroon</option>
    <option value="40">Canada</option>
    <option value="41">Cape Verde</option>
    <option value="42">Cayman Islands</option>
    <option value="43">Central African Republic</option>
    <option value="44">Chad</option>
    <option value="45">Chile</option>
    <option value="46">China</option>
    <option value="47">Christmas Island</option>
    <option value="48">Cocos (Keeling) Islands</option>
    <option value="49">Colombia</option>
    <option value="50">Comoros</option>
    <option value="51">Congo</option>
    <option value="52">Cook Islands</option>
    <option value="53">Costa Rica</option>
    <option value="54">Cote d'ivoire (Ivory Coast)</option>
    <option value="55">Croatia</option>
    <option value="56">Cuba</option>
    <option value="57">Curacao</option>
    <option value="58">Cyprus</option>
    <option value="59">Czech Republic</option>
    <option value="60">Democratic Republic of the Congo</option>
    <option value="61">Denmark</option>
    <option value="62">Djibouti</option>
    <option value="63">Dominica</option>
    <option value="64">Dominican Republic</option>
    <option value="65">Ecuador</option>
    <option value="66">Egypt</option>
    <option value="67">El Salvador</option>
    <option value="68">Equatorial Guinea</option>
    <option value="69">Eritrea</option>
    <option value="70">Estonia</option>
    <option value="71">Ethiopia</option>
    <option value="72">Falkland Islands (Malvinas)</option>
    <option value="73">Faroe Islands</option>
    <option value="74">Fiji</option>
    <option value="75">Finland</option>
    <option value="76">France</option>
    <option value="77">French Guiana</option>
    <option value="78">French Polynesia</option>
    <option value="79">French Southern Territories</option>
    <option value="80">Gabon</option>
    <option value="81">Gambia</option>
    <option value="82">Georgia</option>
    <option value="83">Germany</option>
    <option value="84">Ghana</option>
    <option value="85">Gibraltar</option>
    <option value="86">Greece</option>
    <option value="87">Greenland</option>
    <option value="88">Grenada</option>
    <option value="89">Guadaloupe</option>
    <option value="90">Guam</option>
    <option value="91">Guatemala</option>
    <option value="92">Guernsey</option>
    <option value="93">Guinea</option>
    <option value="94">Guinea-Bissau</option>
    <option value="95">Guyana</option>
    <option value="96">Haiti</option>
    <option value="97">Heard Island and McDonald Islands</option>
    <option value="98">Honduras</option>
    <option value="99">Hong Kong</option>
    <option value="100">Hungary</option>
    <option value="101">Iceland</option>
    <option value="102">India</option>
    <option value="103">Indonesia</option>
    <option value="104">Iran</option>
    <option value="105">Iraq</option>
    <option value="106">Ireland</option>
    <option value="107">Isle of Man</option>
    <option value="108">Israel</option>
    <option value="109">Italy</option>
    <option value="110">Jamaica</option>
    <option value="111">Japan</option>
    <option value="112">Jersey</option>
    <option value="113">Jordan</option>
    <option value="114">Kazakhstan</option>
    <option value="115">Kenya</option>
    <option value="116">Kiribati</option>
    <option value="117">Kosovo</option>
    <option value="118">Kuwait</option>
    <option value="119">Kyrgyzstan</option>
    <option value="120">Laos</option>
    <option value="121">Latvia</option>
    <option value="122">Lebanon</option>
    <option value="123">Lesotho</option>
    <option value="124">Liberia</option>
    <option value="125">Libya</option>
    <option value="126">Liechtenstein</option>
    <option value="127">Lithuania</option>
    <option value="128">Luxembourg</option>
    <option value="129">Macao</option>
    <option value="130">Macedonia</option>
    <option value="131">Madagascar</option>
    <option value="132">Malawi</option>
    <option value="133">Malaysia</option>
    <option value="134">Maldives</option>
    <option value="135">Mali</option>
    <option value="136">Malta</option>
    <option value="137">Marshall Islands</option>
    <option value="138">Martinique</option>
    <option value="139">Mauritania</option>
    <option value="140">Mauritius</option>
    <option value="141">Mayotte</option>
    <option value="142">Mexico</option>
    <option value="143">Micronesia</option>
    <option value="144">Moldava</option>
    <option value="145">Monaco</option>
    <option value="146">Mongolia</option>
    <option value="147">Montenegro</option>
    <option value="148">Montserrat</option>
    <option value="149">Morocco</option>
    <option value="150">Mozambique</option>
    <option value="151">Myanmar (Burma)</option>
    <option value="152">Namibia</option>
    <option value="153">Nauru</option>
    <option value="154">Nepal</option>
    <option value="155">Netherlands</option>
    <option value="156">New Caledonia</option>
    <option value="157">New Zealand</option>
    <option value="158">Nicaragua</option>
    <option value="159">Niger</option>
    <option value="160">Nigeria</option>
    <option value="161">Niue</option>
    <option value="162">Norfolk Island</option>
    <option value="163">North Korea</option>
    <option value="164">Northern Mariana Islands</option>
    <option value="165">Norway</option>
    <option value="166">Oman</option>
    <option value="167">Pakistan</option>
    <option value="168">Palau</option>
    <option value="169">Palestine</option>
    <option value="170">Panama</option>
    <option value="171">Papua New Guinea</option>
    <option value="172">Paraguay</option>
    <option value="173">Peru</option>
    <option value="174">Phillipines</option>
    <option value="175">Pitcairn</option>
    <option value="176">Poland</option>
    <option value="177">Portugal</option>
    <option value="178">Puerto Rico</option>
    <option value="179">Qatar</option>
    <option value="180">Reunion</option>
    <option value="181">Romania</option>
    <option value="182">Russia</option>
    <option value="183">Rwanda</option>
    <option value="184">Saint Barthelemy</option>
    <option value="185">Saint Helena</option>
    <option value="186">Saint Kitts and Nevis</option>
    <option value="187">Saint Lucia</option>
    <option value="188">Saint Martin</option>
    <option value="189">Saint Pierre and Miquelon</option>
    <option value="190">Saint Vincent and the Grenadines</option>
    <option value="191">Samoa</option>
    <option value="192">San Marino</option>
    <option value="193">Sao Tome and Principe</option>
    <option value="194">Saudi Arabia</option>
    <option value="195">Senegal</option>
    <option value="196">Serbia</option>
    <option value="197">Seychelles</option>
    <option value="198">Sierra Leone</option>
    <option value="199">Singapore</option>
    <option value="200">Sint Maarten</option>
    <option value="201">Slovakia</option>
    <option value="202">Slovenia</option>
    <option value="203">Solomon Islands</option>
    <option value="204">Somalia</option>
    <option value="205">South Africa</option>
    <option value="206">South Georgia and the South Sandwich Islands</option>
    <option value="207">South Korea</option>
    <option value="208">South Sudan</option>
    <option value="209">Spain</option>
    <option value="210">Sri Lanka</option>
    <option value="211">Sudan</option>
    <option value="212">Suriname</option>
    <option value="213">Svalbard and Jan Mayen</option>
    <option value="214">Swaziland</option>
    <option value="215">Sweden</option>
    <option value="216">Switzerland</option>
    <option value="217">Syria</option>
    <option value="218">Taiwan</option>
    <option value="219">Tajikistan</option>
    <option value="220">Tanzania</option>
    <option value="221">Thailand</option>
    <option value="222">Timor-Leste (East Timor)</option>
    <option value="223">Togo</option>
    <option value="224">Tokelau</option>
    <option value="225">Tonga</option>
    <option value="226">Trinidad and Tobago</option>
    <option value="227">Tunisia</option>
    <option value="228">Turkey</option>
    <option value="229">Turkmenistan</option>
    <option value="230">Turks and Caicos Islands</option>
    <option value="231">Tuvalu</option>
    <option value="232">Uganda</option>
    <option value="233">Ukraine</option>
    <option value="234">United Arab Emirates</option>
    <option value="235">United Kingdom</option>
    <option value="236">United States</option>
    <option value="237">United States Minor Outlying Islands</option>
    <option value="238">Uruguay</option>
    <option value="239">Uzbekistan</option>
    <option value="240">Vanuatu</option>
    <option value="241">Vatican City</option>
    <option value="242">Venezuela</option>
    <option value="243">Vietnam</option>
    <option value="244">Virgin Islands, British</option>
    <option value="245">Virgin Islands, US</option>
    <option value="246">Wallis and Futuna</option>
    <option value="247">Western Sahara</option>
    <option value="248">Yemen</option>
    <option value="249">Zambia</option>
    <option value="250">Zimbabwe</option>
    </select>
    </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3">City:</label>

        <div class="col-md-9">
            <input type="text" class="form-control input-default" id="field_city" name="field_city">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3">Address:</label>

        <div class="col-md-9">
            <input type="text" class="form-control input-default" id="field_address" name="field_address">
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-4 col-md-offset-8">
            <button type="submit" class="btn btn-block btn-dark-blue"
                    onclick="Settings.updateUserInfo($('#info_form'));return false;">
                Update Settings
            </button>
        </div>
    </div>

    </form>
    </div>
    <!-- col -->
    </div>
    <!-- row -->
    </div>
    <!-- container -->


    <h2 class="panel-title">Privacy Settings</h2>
    <hr>
    <div class="container-fluid profile-section">
        <div class="row">


            <div class="_col-md-5 _col-md-offset-3">
                <form class="form-horizontal" id="privacy_form">


                    <div class="form-group">
                        <label class="control-label col-md-3">My Bets Are:</label>

                        <div class="col-md-9">

                            <select name="bet_privacy" id="bet_privacy"
                                    class="custom-select full-width select2-offscreen" title="" tabindex="-1">
                                <option value="1">Public</option>
                                <option value="0">Private</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Show my:</label>

                        <div class="col-md-9">

                            <select name="name_privacy" id="name_privacy"
                                    class="custom-select full-width select2-offscreen" title="" tabindex="-1">
                                <option value="1">Full name</option>
                                <option value="0">Nickname</option>
                            </select>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-md-4 col-md-offset-8">
                            <button type="submit" class="btn btn-block btn-dark-blue"
                                    onclick="Settings.updatePrivacyInfo();return false;">
                                Update Privacy Settings
                            </button>
                        </div>
                    </div>
                </form>

            </div>
            <!-- col -->


        </div>
        <!-- row -->
    </div>
    <!-- container -->


    </div>
    <!-- col -->
    <div class="col-md-6">

        <h2 class="panel-title">Security Settings</h2>
        <hr>
        <div class="container-fluid profile-section">
            <div class="row">
                <div class="_col-md-5 _col-md-offset-3">
                    <form role="form" class="form-horizontal" onsubmit="Settings.changePassword(this);return false;">
                        <div class="form-group">
                            <label class="control-label col-md-3">Old Password:</label>

                            <div class="col-md-9">
                                <input type="password" class="form-control input-default" name="old_password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">New Password:</label>

                            <div class="col-md-9">
                                <input type="password" class="form-control input-default" name="new_password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Confirm new password:</label>

                            <div class="col-md-9">
                                <input type="password" class="form-control input-default" name="confirm_new_password">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-8">
                                <button type="submit" class="btn btn-block btn-dark-blue">Change Password</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- col -->
            </div>
            <!-- row -->
        </div>
        <!-- container -->


        <h2 class="panel-title">Profile Picture</h2>
        <hr>
        <div class="container-fluid profile-section">
            <div class="row">
                <div class="_col-md-5 _col-md-offset-3">
                    <div class="form-group">
                        <label class="control-label col-md-3"><img
                                src="http://bookiebot.com/uploads/social/profile/82/94b0080ed55a6ba6d1732be225a97bbda3b5a1e4.jpg"
                                class="img-responsive img-rounded img-thumbnail" id="profile_thumb"></label>

                        <div class="col-md-9">
                            <form onsubmit="Settings.updateProfileImage(this);return false;">
                                <input type="file" class="form-control input-default" name="image"> <br>
                                <input type="submit" class="btn btn-block btn-dark-blue" name="submit"
                                       value="Upload Profile Picture">
                            </form>
                        </div>
                    </div>
                </div>
                <!-- col -->
            </div>
            <!-- row -->
        </div>
        <!-- container -->


        <h2 class="panel-title">Account Verification Status</h2>
        <hr>
        <div class="container-fluid profile-section" style="font-size:15px;">
            <div class="row">
                <div class="col-md-12">Email - <span id="email-verification">Verified</span> <span
                        class="glyphicon glyphicon-ok"></span></div>
            </div>
            <br>

            <div class="row">
                <div class="col-md-8">Personal Identity - <span id="person-verification">Not Verified</span> <span
                        class="glyphicon"></span></div>
            </div>
            <br>

            <div class="row">
                <div class="col-md-8">Phone - <span id="phone-verification">Not Verified</span> <span
                        class="glyphicon"></span></div>
            </div>
            <br>

            <div class="row">
                <div class="col-md-8">Credit Card - <span id="card-verification">Verified</span> <span
                        class="glyphicon glyphicon-ok"></span></div>
            </div>


            <!-- col -->

            <!-- row -->
        </div>
        <!-- container -->

    </div>
    <!-- col -->
    </div>
    <!-- row -->
    <hr>
    <div class="row" style="padding:10px;">
        <div class="col-md-7">
            <h2 class="panel-title">IDENTIFICATION DOCUMENTS</h2>
            <span class="btn btn-sm btn-dark-blue" style="margin-top: -23px;float:right"
                  onclick="Settings.openAddNewDocument();">ADD NEW DOCUMENT</span>
            <hr>
            <div class="container-fluid profile-section">
                <div class="row">
                    <table class="table table-custom" id="user_documents_table">
                        <thead>
                        <tr>
                            <th>Country</th>
                            <th>DATE MODIFIED</th>
                            <th>DOCUMENT TYPE</th>
                            <th>DOCUMENT NUMBER</th>
                            <th>STATUS</th>
                            <th>DOCUMENT COPY</th>
                        </tr>
                        </thead>
                        <tbody id="personalDocuments">
                        <tr>
                            <td>Iraq</td>
                            <td>2015-01-05</td>
                            <td>Passport</td>
                            <td>01239012930123</td>
                            <td>Unverified</td>
                            <td>
                                <button class="btn btn-dark-blue"
                                        onclick="Settings.openDocumentUploadForm(30);return false;">UPLOAD COPY
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>Dominica</td>
                            <td>2014-12-16</td>
                            <td>Driving License</td>
                            <td>23234234</td>
                            <td>Unverified</td>
                            <td>
                                <button class="btn btn-dark-blue"
                                        onclick="Settings.openDocumentUploadForm(29);return false;">UPLOAD COPY
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>Comoros</td>
                            <td>2014-12-15</td>
                            <td>Driving License</td>
                            <td>232332423423</td>
                            <td>Unverified</td>
                            <td>PENDING APPROVAL</td>
                        </tr>
                        <tr>
                            <td>Cayman Islands</td>
                            <td>2014-12-15</td>
                            <td>Driving License</td>
                            <td>098723662222</td>
                            <td>Unverified</td>
                            <td>PENDING APPROVAL</td>
                        </tr>
                        </tbody>
                    </table>
                    <p class="empty_message hidden"></p>
                </div>
                <!-- row -->
            </div>
            <!-- container -->
        </div>
        <!-- end col-md-8-->
        <div class="col-md-5 documents-explanation-text">
            <h4>For security reasons, we kindly ask you to add one copy of the following documents from each
                category:</h4>

            <h6>1. A government-issued form of photographic identification:</h6>
            <ul>
                <li>Passport</li>
                <li>Driving licence with photo</li>
                <li>National Identity Card</li>
            </ul>
        </div>

    </div>
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


    <script type="text/javascript"
            src="http://bookiebot.com/app/templates/default/view/_media/js/Betstock/User/Settings.js"></script>
    <script>
        Settings.getUserInfo();
    </script>
    <div class="push"></div>
    </div>

<?php
include "includes/footer.php";
?>