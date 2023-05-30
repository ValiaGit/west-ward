{{$Data.modules.header}}
<body>

<div class="wrapper">
    <script>
        var commpunity_id = {{$Data.community_id}};
    </script>
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


                <div class="block-group" style="background-image: url('http://lorempixel.com/700/180/sports/')">
                    <div class="group-head">
                        <div class="thumb">
                            <img id="community_logo" src="" alt=""/>
                        </div>
                        <!-- thumb -->
                        <div class="details">
                            <h2 id="community_title"></h2>

                            <p id="community_sport"></p>
                        </div>
                        <!-- details -->
                        <div class="buttons">
                            <button class="btn btn-sm btn-group hidden community_id" id="joinCommunity" rel="">Join
                                Community
                            </button>
                            <button class="btn btn-sm btn-group hidden community_id" id="leaveCommunity" rel="">Leave
                                Community
                            </button>
                        </div>
                        <!-- buttons -->
                    </div>
                    <!-- group head -->
                </div>
                <!-- block-group -->

                <div class="block-post">
                    <div class="container-fluid">
                        <div class="row">
                            <form method="POST" onsubmit="Posts.addPost(this,{{$Data.community_id}});return false;"
                                  enctype="multipart/form-data">
                                <div class="col-md-9 rel no-pr">
                                    <input type="text" class="form-control input-comment" autofocus="on"
                                           id="message_text" tabindex="1" name="content" placeholder="Write a message"/>
                                    <input type="file" id="file" name="image" class="hidden"/>
                                    <input type="hidden" id="community_id" name="community_id" class="hidden" value="{{$Data.community_id}}"/>
                                    <a class="btn-upload" onclick="return document.getElementById('file').click();"
                                       style="margin-top: 9px;"><em id="photo_text">Upload Photo</em><i
                                                class="glyphicon glyphicon-camera"></i></a>
                                </div>
                                <!-- col -->
                                <div class="col-md-3">
                                    <input type="submit" tabindex="2" class="btn btn-dark-blue btn-block" type="submit"
                                           value="Post">
                                </div>
                            </form>
                        </div>
                        <!-- row -->
                    </div>
                    <!-- container fluid -->
                </div>
                <!-- block-post -->


                <div class="feed" id="stream">
                </div>
                <!-- feed -->


            </div>

            <div class="col-md-3 social-matches">

                <div class="heading">
                    <h2>
                        {{$lang_arr.upcoming}}
                    </h2>
                </div>

                <div id="upcoming_widget">

                </div>

                <!--<div id="team_bets">
                    <div class="heading">
                        <h2>
                            {{$lang_arr.team_bets_for}} <span class="competitor_name"></span>
                        </h2>
                    </div>

                    <div id="bets_by_friends" class="bets-by-friends">
                    </div>
                </div>-->
            <hr />
                <div id="team_bets">



                </div>


            </div>

        </div>

    </div>

    {{$Data.modules.footer}}
    <script src="{{$THEME}}/js/libs/highslide/highslide.js"></script>
    <script>
        Community.getMyCommunitiesList();
        Community.getCommunity({{$Data.community_id}});
        UpcomingsWidget.getData();
    </script>


