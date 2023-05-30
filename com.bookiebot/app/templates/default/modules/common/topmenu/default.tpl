<div class="navbar navbar-blue navbar-fixed-top top-navbar" role="navigation">
    <div class="container">
        <div class="row relative">
            <div class="col-md-12">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span>
                        <span class="icon-bar"></span> <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand {{$domain}}" href="{{$base_href}}/{{$cur_lang}}">Bookiebot</a>
                </div>
                <!-- navbar-header -->
                <div class="navbar-collapse collapse clearfix">

                    <ul class="nav navbar-nav navbar-icons">
                        {{$i=1}}
                        {{foreach $Data.main_menu_list as $page}}
                            <li{{if Fn::isActive($page.url)}} class="active"{{/if}}>
                                <a href="{{$page.url}}" onclick="{{$page.onclick}}">
                                    <i class="icon icon-{{$page.icon}}"></i>
                                    <span class="text">{{$page.title}}</span>
                                </a>
                            </li>
                            {{$i=$i+1}}
                        {{/foreach}}
                    </ul>

                    {{if 1 eq 2}}
                    <div class="search-form pull-left">
                        <input type="text" class="search-input" id="peopleGroupSearch" onkeyup="Search.init(event);return false;" value="" placeholder="Search People or Groups" />
                        <button class="search-btn glyphicon glyphicon-search"></button>

                        <div class="search-results" tabindex="0" onblur="Search.blur(event); return false;">

                            <div class="search-results-inner">
                                <div class="search-items">

                                </div>
                            </div>
                            <!-- search-results-inner -->

                        </div>
                        <!-- search-results -->

                    </div>
                    <!-- search-form -->
                    {{/if}}

                    <ul class="nav navbar-top navbar-nav navbar-pages">
                        {{foreach $Data.secondary_menu_list as $page}}
                            <li {{if Fn::isActive($page.url)}} class="active"{{/if}}>
                                <a href="{{$page.url}}">{{$page.title}}</a></li>
                        {{/foreach}}
                    </ul>

                        <form class="navbar-form form-login navbar-right hidden" id="loginForm" method="post" novalidate="novalidate" autocomplete="off" onsubmit="Session.login(this);return false;">
                            <div class="form-group">
                                <input autocomplete="off" type="text" name="username" placeholder="{{$lang_arr.username_or_email}}" class="form-control input-small input-sm">
                            </div>
                            <div class="form-group">
                                <input autocomplete="off" type="password" name="password" placeholder="{{$lang_arr.password}}" class="form-control input-small input-sm">
                            </div>
                            <button type="submit" class="btn btn-sm btn-blue">{{$lang_arr.login}}</button>
                            <!--<a class="icon-fb" href="{{$base_href}}/{{$cur_lang}}/fb/login"></a>
                            <a class="icon-google" href="#" id="signInButton"></a>-->
                        </form>





                    <div class="hidden loggedIn">
                        <div class="navbar-right">

                            <ul class="nav navbar-nav navbar-profile">
                                <li>
                                    <span class="u_balance hidden" style="display: block;margin-top: 23px;color: white;padding-right: 10px;"></span>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <img id="profile_pic" src="" alt="" />  {{$lang_arr.my_account}}
                                        <span class="badge notifications_badge"></span>
                                        <b class="caret"></b>
                                    </a>
                                    <ul class="dropdown-menu">
                                        {{foreach $Data.user_menu_list as $curpage}}
                                            <li class="text-right{{if Fn::isActive($curpage.url)}} active{{/if}}">
                                                <a href="{{$curpage.url}}">
                                                    {{$curpage.title}}
                                                    {{if $curpage.id eq 25}}
                                                        <span class="badge notifications_badge"></span>
                                                    {{/if}}
                                                </a>
                                            </li>
                                        {{/foreach}}
                                    </ul>
                                </li>

                            </ul>

                            <button class="btn btn-blue btn-sm btn-logout" onclick="Session.logout()">{{$lang_arr.logout}}</button>
                        </div>
                    </div>

                    <ul class="nav navbar-nav navbar-right hidden">
                        <li>
                            <a>
                                <select name="" class="input-normal" title="">
                                    {{foreach $Data.langs as $lang}}{{/foreach}}
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
                            <a href="#"><i class="icon-{{$cur_lang}}"></i></a>
                            <ul class="children">
                                <li>
                                    <a href="#" onclick="Util.changeLang('ru'); return false;"><i class="icon-ru"></i></a>
                                </li>
                                <li>
                                    <a href="#" onclick="Util.changeLang('en'); return false;"><i class="icon-en"></i></a>
                                </li>
                                <li>
                                    <a href="#" onclick="Util.changeLang('ka'); return false;"><i class="icon-ka"></i></a>
                                </li>
                                <li>
                                    <a href="#" onclick="Util.changeLang('de'); return false;"><i class="icon-de"></i></a>
                                </li>
                                <li>
                                    <a href="#" onclick="Util.changeLang('ja'); return false;"><i class="icon-ja"></i></a>
                                </li>
                                <li>
                                    <a href="#" onclick="Util.changeLang('az'); return false;"><i class="icon-az"></i></a>
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
