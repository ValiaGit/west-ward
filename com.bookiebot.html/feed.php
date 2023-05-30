<?php
$page_body_class = "page-feed";
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
                        <li class="active">
                            <a href="http://bookiebot.com/en/social">
                                <span class="glyphicon glyphicon-user"></span>
                                <span class="text">PEOPLE</span>
                            </a>
                        </li>
                    </ul>

                    <div class="search-form pull-left">
                        <input type="text" class="search-input" id="peopleGroupSearch" onkeyup="Search.init(event);return false;" value="" placeholder="Search People or Groups">
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

                    <form class="navbar-form form-login navbar-right hidden" method="post" id="loginForm" novalidate="novalidate" autocomplete="off" onsubmit="Session.login(this);return false;">
                        <div class="form-group">
                            <input type="text" name="username" placeholder="Username or Email" autocomplete="off" class="form-control input-small input-sm">
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" placeholder="Password" autocomplete="off" class="form-control input-small input-sm">
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
                                        <img id="profile_pic" src="http://bookiebot.com/uploads/social/profile/82/94b0080ed55a6ba6d1732be225a97bbda3b5a1e4.jpg" alt="">  My Account
                                        <b class="caret"></b>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="text-right">
                                            <a href="http://bookiebot.com/en/user/balance_management">Balance Management</a></li>
                                        <li class="text-right">
                                            <a href="http://bookiebot.com/en/user/settings">Account Settings</a></li>
                                        <li class="text-right">
                                            <a href="http://bookiebot.com/en/user/betting_history">Betting History</a></li>
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
                    <strong>15:20:29</strong> Jan.07,2015
                </div>
                <!-- current time -->
            </div>
            <!-- cold -->
            <div class="col-md-6 col-sm-6 col-xs-6 text-right hidden" id="forgot_register" style="display: none;">
                <a href="#" onclick="ForgotPass.openDialog();return false;"> Forgot your password?</a>
                <a class="blue" href="#" onclick="Registration.openDialog();return false;">Register Now!</a>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6 text-right" id="userData" style="display: block;"><span class="profile-label">Welcome, </span> <a class="profile-label bold cap blue" href="http://bookiebot.com/en/user/settings">peter </a>&nbsp;&nbsp;UserId:82&nbsp;&nbsp;<span class="profile-label">Balance:</span><span class="profile-label bold"> 49156.59$</span></div>
            <!-- col -->
        </div>
        <!-- row -->


    </div>
    <!-- container -->
</div>
<!-- navbar -->

<div class="container">

    <div class="row">

        <div class="col-md-3 social-sidebar">
            <ul class="nav nav-page nav-social">
                <li class="active">
                    <a href="http://bookiebot.com/en/social">
                        <span class="glyphicon glyphicon-th-list social-nav-icon"></span> Feed
                    </a>
                </li>
                <li>
                    <a href="http://bookiebot.com/en/social/messages">
                        <span class="glyphicon glyphicon-envelope social-nav-icon"></span> Messages
                    </a>
                </li>
                <li>
                    <a href="http://bookiebot.com/en/social/friends">
                        <span class="glyphicon glyphicon-user social-nav-icon"></span> Friends
                    </a>
                </li>

            </ul>

            <div class="nav-social-heading">
                <h3><i class="glyphicon glyphicon-user social-nav-icon"></i> My Communities</h3>
            </div>

            <ul class="nav nav-page nav-social" id="my_communities"><li id="community_li_1"><a href="/en/social/community/1"><span class="glyphicon glyphicon-star social-nav-icon"></span> FC Barcelona (Members:4)</a></li><li id="community_li_2"><a href="/en/social/community/2"><span class="glyphicon glyphicon-star social-nav-icon"></span> Clermont Foot (Members:5)</a></li></ul>
        </div>


        <div class="col-md-6">
            <div class="block-post">
                <div class="container-fluid">
                    <div class="row">
                        <form onsubmit="Posts.addPost(this);return false;" enctype="multipart/form-data">
                            <div class="col-md-9 rel no-pr">
                                <input type="text" class="form-control input-comment" autofocus="on" id="message_text" tabindex="1" name="content" placeholder="Write a message">
                                <input type="file" id="file" name="image" class="hidden">
                                <a class="btn-upload" onclick="return document.getElementById('file').click();" style="margin-top: 9px;"><em id="photo_text">Upload Photo</em><i class="glyphicon glyphicon-camera"></i></a>
                            </div>
                            <!-- col -->
                            <div class="col-md-3">
                                <input type="submit" tabindex="2" class="btn btn-dark-blue btn-block" value="Post">
                            </div>
                        </form>
                    </div>
                    <!-- row -->
                </div>
                <!-- container fluid -->
            </div>
            <!-- block-post -->




            <div class="feed" id="stream"><!-- feed item --><!-- feed item --><div class="feed-item" id="feed_item-209"><a class="icon-close btn-remove" href="#" onclick="Posts.deletePost(209);return false;" title="Remove"></a><div class="feed-info"><div class="feed-avatar">   <a href="http://bookiebot.com/uploads/social/profile/82/a0e71e6eae11b739a820e407b000014af76cbc6b.jpg" class="highslide" onclick="return hs.expand(this)"><img src="http://bookiebot.com/uploads/social/profile/82/94b0080ed55a6ba6d1732be225a97bbda3b5a1e4.jpg" alt=""></a></div><!-- feed-avatar --><div class="feed-author">    <h3><a href="#">Peter Seisenbacher</a></h3>    <div class="feed-date">       <i class="icon-date"></i> 2014-12-12 20:40:54   </div><!-- feed date --> </div><!-- feed author --> </div>    <!-- feed info -->   <div class="feed-content">   <p style="margin-bottom:10px;">Link: <a href="#" onclick="window.open(&quot;http://www.betfair.com/exchange/football/event?id=27319776&amp;exp=e&quot;,&quot;Test&quot;,&quot;width=1024,height=768&quot;)">http://www.betfair.com/exchange/football/event?id=27319776&amp;exp=e</a></p>   </div>    <!-- feed content -->   <ul class="feed-buttons">       <li class="like-btn /*has-liked*/">          <a href="#" onclick="Posts.like(209);return false;"><i class="icon-heart"></i> Like <span>(0)</span></a>     </li>      <!-- like btn -->      <li class="comments-btn">         <a href="#"><i class="icon-comments"></i> Comment <span>(0)</span></a>      </li>      <!-- comments btn -->   </ul>   <!-- feed-buttons -->    <div class="feed-comments">       <div class="comment-form">           <form onsubmit="Posts.addComment(this,209);return false;" method="post">               <div class="container-fluid">               <div class="row">                       <div class="col-md-12">                       <input class="form-control input-comment" type="text" name="comment" placeholder="Write a comment...">                       </div>                   <!-- col -->                      <!-- <div class="col-md-3">                     <button class="btn btn-block btn-dark-blue">Post</button>                      </div>                       col -->                   </div>           </div>           </form>   </div>       <!-- comment form --></div>   <!-- feed comments --></div><!-- feed item --><!-- feed item --><!-- feed item --><!-- feed item --><div class="feed-item" id="feed_item-186"><div class="feed-info"><div class="feed-avatar">   <a href="http://bookiebot.com/uploads/social/profile/46/2e4f6531c0384208c2af209ab6c1216254ca109f.jpg" class="highslide" onclick="return hs.expand(this)"><img src="http://bookiebot.com/uploads/social/profile/46/1216e7df41489f3b0768488d9b35efb92f4e05a7.jpg" alt=""></a></div><!-- feed-avatar --><div class="feed-author">    <h3><a href="#">Shako Test Nick</a></h3>    <div class="feed-date">       <i class="icon-date"></i> 2014-10-20 23:17:43   </div><!-- feed date --> </div><!-- feed author --> </div>    <!-- feed info -->   <div class="feed-content">   <p style="margin-bottom:10px;">Holla</p>   </div>    <!-- feed content -->   <ul class="feed-buttons">       <li class="like-btn /*has-liked*/">          <a href="#" onclick="Posts.like(186);return false;"><i class="icon-heart"></i> Like <span>(0)</span></a>     </li>      <!-- like btn -->      <li class="comments-btn">         <a href="#"><i class="icon-comments"></i> Comment <span>(0)</span></a>      </li>      <!-- comments btn -->   </ul>   <!-- feed-buttons -->    <div class="feed-comments"><div class="comment" id="comment-item-70"><div class="comment-info"> <a class="icon-close btn-remove" href="#" onclick="Posts.deleteComment(70,186);return false;" title="Remove"></a> <div class="comment-avatar">      <img src="http://bookiebot.com/uploads/social/profile/82/94b0080ed55a6ba6d1732be225a97bbda3b5a1e4.jpg" alt="">  </div>  <!-- comment-avatar -->  <div class="comment-author">     <h3><a href="#">Peter Seisenbacher</a></h3>    <div class="comment-date">         <i class="icon-date"></i> 2014-12-03 13:18:05   </div>     <!-- comment date --></div> <!-- comment author --></div><!-- comment info --><div class="comment-content">Ok</div> <!-- comment content --></div><div class="comment" id="comment-item-71"><div class="comment-info"> <a class="icon-close btn-remove" href="#" onclick="Posts.deleteComment(71,186);return false;" title="Remove"></a> <div class="comment-avatar">      <img src="http://bookiebot.com/uploads/social/profile/82/94b0080ed55a6ba6d1732be225a97bbda3b5a1e4.jpg" alt="">  </div>  <!-- comment-avatar -->  <div class="comment-author">     <h3><a href="#">Peter Seisenbacher</a></h3>    <div class="comment-date">         <i class="icon-date"></i> 2014-12-03 13:18:10   </div>     <!-- comment date --></div> <!-- comment author --></div><!-- comment info --><div class="comment-content">asd</div> <!-- comment content --></div>       <div class="comment-form">           <form onsubmit="Posts.addComment(this,186);return false;" method="post">               <div class="container-fluid">               <div class="row">                       <div class="col-md-12">                       <input class="form-control input-comment" type="text" name="comment" placeholder="Write a comment...">                       </div>                   <!-- col -->                      <!-- <div class="col-md-3">                     <button class="btn btn-block btn-dark-blue">Post</button>                      </div>                       col -->                   </div>           </div>           </form>   </div>       <!-- comment form --></div>   <!-- feed comments --></div><!-- feed item --><!-- feed item --><div class="feed-item" id="feed_item-140"><div class="feed-info"><div class="feed-avatar">   <a href="http://bookiebot.com/uploads/social/profile/46/2e4f6531c0384208c2af209ab6c1216254ca109f.jpg" class="highslide" onclick="return hs.expand(this)"><img src="http://bookiebot.com/uploads/social/profile/46/1216e7df41489f3b0768488d9b35efb92f4e05a7.jpg" alt=""></a></div><!-- feed-avatar --><div class="feed-author">    <h3><a href="#">Shako Test Nick</a></h3>    <div class="feed-date">       <i class="icon-date"></i> 2014-10-15 09:00:13   </div><!-- feed date --> </div><!-- feed author --> </div>    <!-- feed info -->   <div class="feed-content">   <p style="margin-bottom:10px;">test judo</p><img class="thumbnail" src="http://bookiebot.com/uploads/social/posts/a0ec24981fe5519d6614e95485e819ec.gif">   </div>    <!-- feed content -->   <ul class="feed-buttons">       <li class="like-btn /*has-liked*/">          <a href="#" onclick="Posts.like(140);return false;"><i class="icon-heart"></i> Like <span>(0)</span></a>     </li>      <!-- like btn -->      <li class="comments-btn">         <a href="#"><i class="icon-comments"></i> Comment <span>(0)</span></a>      </li>      <!-- comments btn -->   </ul>   <!-- feed-buttons -->    <div class="feed-comments">       <div class="comment-form">           <form onsubmit="Posts.addComment(this,140);return false;" method="post">               <div class="container-fluid">               <div class="row">                       <div class="col-md-12">                       <input class="form-control input-comment" type="text" name="comment" placeholder="Write a comment...">                       </div>                   <!-- col -->                      <!-- <div class="col-md-3">                     <button class="btn btn-block btn-dark-blue">Post</button>                      </div>                       col -->                   </div>           </div>           </form>   </div>       <!-- comment form --></div>   <!-- feed comments --></div><!-- feed item --><!-- feed item --><!-- feed item --><div class="feed-item" id="feed_item-123"><div class="feed-info"><div class="feed-avatar">   <a href="http://bookiebot.com/uploads/social/profile/83/2439a6073063391fa3aa1f9d1e7bf770b5ab0d1d.jpg" class="highslide" onclick="return hs.expand(this)"><img src="http://bookiebot.com/uploads/social/profile/83/7109a3e9d90b502499a71a56f0fcb0b23769985e.jpg" alt=""></a></div><!-- feed-avatar --><div class="feed-author">    <h3><a href="#">giorgi aleksidze</a></h3>    <div class="feed-date">       <i class="icon-date"></i> 2014-09-23 02:51:34   </div><!-- feed date --> </div><!-- feed author --> </div>    <!-- feed info -->   <div class="feed-content">   <p style="margin-bottom:10px;">My Team Is The Best!!!</p>   </div>    <!-- feed content -->   <ul class="feed-buttons">       <li class="like-btn /*has-liked*/">          <a href="#" onclick="Posts.like(123);return false;"><i class="icon-heart"></i> Like <span>(0)</span></a>     </li>      <!-- like btn -->      <li class="comments-btn">         <a href="#"><i class="icon-comments"></i> Comment <span>(0)</span></a>      </li>      <!-- comments btn -->   </ul>   <!-- feed-buttons -->    <div class="feed-comments"><div class="comment" id="comment-item-37"><div class="comment-info">  <div class="comment-avatar">      <img src="http://bookiebot.com/uploads/social/profile/84/39ad906240c60bdcaf9a6b47c1b0de96ef40a4eb.jpg" alt="">  </div>  <!-- comment-avatar -->  <div class="comment-author">     <h3><a href="#">kyoh kunishio</a></h3>    <div class="comment-date">         <i class="icon-date"></i> 2014-10-12 10:55:08   </div>     <!-- comment date --></div> <!-- comment author --></div><!-- comment info --><div class="comment-content">Hello everyone</div> <!-- comment content --></div><div class="comment" id="comment-item-38"><div class="comment-info">  <div class="comment-avatar">      <img src="http://bookiebot.com/uploads/social/profile/46/1216e7df41489f3b0768488d9b35efb92f4e05a7.jpg" alt="">  </div>  <!-- comment-avatar -->  <div class="comment-author">     <h3><a href="#">aleko tsibadze</a></h3>    <div class="comment-date">         <i class="icon-date"></i> 2014-10-12 11:40:18   </div>     <!-- comment date --></div> <!-- comment author --></div><!-- comment info --><div class="comment-content">My Team is good also!</div> <!-- comment content --></div>       <div class="comment-form">           <form onsubmit="Posts.addComment(this,123);return false;" method="post">               <div class="container-fluid">               <div class="row">                       <div class="col-md-12">                       <input class="form-control input-comment" type="text" name="comment" placeholder="Write a comment...">                       </div>                   <!-- col -->                      <!-- <div class="col-md-3">                     <button class="btn btn-block btn-dark-blue">Post</button>                      </div>                       col -->                   </div>           </div>           </form>   </div>       <!-- comment form --></div>   <!-- feed comments --></div><!-- feed item --><!-- feed item --><!-- feed item --><!-- feed item --><!-- feed item --></div><!-- feed -->



        </div>

        <div class="col-md-3 social-matches bets-by-friends">
            <div class="heading">
                <h2>
                    Upcoming Events
                </h2>
            </div>
            <div id="upcoming_widget"><div class="list-custom list-light-blue"><ul class="navigation level-1"><li class="list-group-item collapsed"><a href="#" class="expand soccer collapsed"><i class="sport-soccer"></i>Soccer <span class="badge widget-badge pull-right" style="margin-top: -3px;margin-right: 8px;">7</span></a>  <ul class="level-2" style="display: none;">      <li class="list-group-item" title="Australia - Kuwait"><a href="http://bookiebot.com/en/p/match/255205"><span class="time">09-01 12:00</span> <span class="pair">Australia - Kuwait</span></a></li><li class="list-group-item" title="Uzbekistan - North Korea"><a href="http://bookiebot.com/en/p/match/255209"><span class="time">10-01 10:00</span> <span class="pair">Uzbekistan - North Korea</span></a></li><li class="list-group-item" title="Saudi Arabia - China"><a href="http://bookiebot.com/en/p/match/255208"><span class="time">10-01 12:00</span> <span class="pair">Saudi Arabia - China</span></a></li><li class="list-group-item" title="United Arab Emirates - Qatar"><a href="http://bookiebot.com/en/p/match/255211"><span class="time">11-01 10:00</span> <span class="pair">United Arab Emirates - Qatar</span></a></li><li class="list-group-item" title="Iran - Bahrain"><a href="http://bookiebot.com/en/p/match/255210"><span class="time">11-01 12:00</span> <span class="pair">Iran - Bahrain</span></a></li><li class="list-group-item" title="Japan - Palestine"><a href="http://bookiebot.com/en/p/match/255441"><span class="time">12-01 10:00</span> <span class="pair">Japan - Palestine</span></a></li><li class="list-group-item" title="Jordan - Iraq"><a href="http://bookiebot.com/en/p/match/255212"><span class="time">12-01 12:00</span> <span class="pair">Jordan - Iraq</span></a></li>      </ul>   </li></ul>  </div><div class="list-custom list-light-blue"><ul class="navigation level-1"><li class="list-group-item collapsed"><a href="#" class="expand snooker collapsed"><i class="sport-snooker"></i>Snooker <span class="badge widget-badge pull-right" style="margin-top: -3px;margin-right: 8px;">3</span></a>  <ul class="level-2" style="display: none;">      <li class="list-group-item" title="Hawkins, Barry - Carter, Alistair"><a href="http://bookiebot.com/en/p/match/253504"><span class="time">13-01 22:00</span> <span class="pair">Hawkins, Barry - Carter, Alistair</span></a></li><li class="list-group-item" title="Allen, Mark - Higgins, John"><a href="http://bookiebot.com/en/p/match/254447"><span class="time">14-01 16:00</span> <span class="pair">Allen, Mark - Higgins, John</span></a></li><li class="list-group-item" title="Junhui, Ding - Perry, Joe"><a href="http://bookiebot.com/en/p/match/255043"><span class="time">14-01 22:00</span> <span class="pair">Junhui, Ding - Perry, Joe</span></a></li>      </ul>   </li></ul>  </div></div>

            <div class="heading">
                <h2>
                    Bets By Friends
                </h2>
            </div>
            <div class="items">
                <div id="bets_by_friends"><p style="padding-left:14px;font-size:16px;">There aren't any team bets yet!</p></div>
            </div>
            <script>
                $().ready(function() {
                    Friends.getBetsByFriends();
                });
            </script>



        </div>

        <!--<div class="col-md-3 social-matches bets-by-friends">

             items
            </div>-->

    </div>

</div>

<div class="push"></div>
</div>

<?php
include "includes/footer.php";
?>