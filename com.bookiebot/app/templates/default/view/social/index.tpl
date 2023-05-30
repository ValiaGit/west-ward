{{$Data.modules.header}}
<body class="page-social">

<div class="wrapper">


{{$Data.modules.topmenu}}
{{$Data.modules.bettingmenu}}

<div class="container">

    <div class="row">

            <div class="col-md-3 social-sidebar">
                <div class="social-sidebar-inside">
                    <ul class="nav nav-page nav-social">
                        {{$Data.modules.socialmenu}}
                    </ul>

                    <div class="nav-social-heading">
                        <h3><i class="glyphicon glyphicon-user social-nav-icon"></i> {{$lang_arr.my_community}}</h3>
                    </div>

                    <ul class="nav nav-page nav-social" id="my_communities">
                    </ul>
                </div>
            </div>


            <div class="col-md-6">
                <div class="block-post">
                    <div class="container-fluid">
                        <div class="row">
                            <form method="POST" onsubmit="Posts.addPost(this);return false;" enctype="multipart/form-data">
                                <div class="col-md-9 rel no-pr">
                                    <input type="text" class="form-control input-comment" autofocus="on" id="message_text" tabindex="1" name="content" placeholder="Write a message" />
                                    <input type="file" id="file" name="image" class="hidden" />
                                    <a class="btn-upload" onclick="return document.getElementById('file').click();" style="margin-top: 9px;"><em id="photo_text">Upload Photo</em><i class="glyphicon glyphicon-camera"></i></a>
                                </div>
                                <!-- col -->
                                <div class="col-md-3">
                                    <input type="submit" tabindex="2" class="btn btn-dark-blue btn-block" type="submit" value="Post">
                                </div>
                            </form>
                        </div>
                        <!-- row -->
                    </div>
                    <!-- container fluid -->
                </div>
                <!-- block-post -->




                <div class="feed" id="stream">
                </div><!-- feed -->



            </div>

            <div class="col-md-3 social-matches sortable">

                <div class="upcomings-widget">
                    <div class="heading">
                        <h2>
                            {{$lang_arr.upcoming}}
                            <span class="move glyphicon glyphicon-move pull-right "></span>
                        </h2>
                    </div>
                    <div id="upcoming_widget">
                    </div>
                </div>


                <div class="bets-by-friends">
                    <div class="heading">
                        <h2>
                            {{$lang_arr.bets_by_friends}}
                            <span class="move glyphicon glyphicon-move pull-right"></span>
                        </h2>
                    </div>
                    <div class="items">
                        <div id="bets_by_friends"></div>
                    </div>
                </div>




            </div>


    </div>

</div>



{{$Data.modules.footer}}
<script src="{{$THEME}}/js/libs/highslide/highslide.js"></script>
<script>
    Friends.getBetsByFriends();
    Posts.getFriendsFeed();
    Community.getMyCommunitiesList();
    UpcomingsWidget.getData();
</script>



