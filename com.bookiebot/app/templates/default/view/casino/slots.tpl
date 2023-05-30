{{$Data.modules.header}}
<body class="page-static">


<!-- <div class="wrapper" style="background: url({{$THEME}}/backgrounds/slots.jpg) no-repeat center top;"> -->

    <div class="wrapper">

    {{$Data.modules.topmenu}}


    {{$Data.modules.bettingmenu}}

        {{if $ip|in_array:$config.whitelist or true}}
        <div class="container" id="casino">
            <div class="row">
                <div class="col-md-10">


                    <div class="swiper-container casino-slider">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide item">
                                <img src="{{$THEME}}/slides/s1.jpg" alt="Slots">
                            </div>
                            <div class="swiper-slide item">
                                <img src="{{$THEME}}/slides/s2.jpg" alt="Slots">
                            </div>
                            <div class="swiper-slide item">
                                <img src="{{$THEME}}/slides/s4.jpg" alt="Slots">
                            </div>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>


                    <nav class="navbar navbar-default">
                        <div class="container-fluid">
                            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                              <ul class="nav navbar-nav" id="casino_top">
                                <li class="active"><a class="renderGames" href="#" data-location="top" data-type="category" data-id="11">{{$lang_arr.featured}}</a></li>
                                <li id="all"><a class="renderGames" href="#" data-location="top" data-type="provider" data-id="">{{$lang_arr.all_providers}}</a></li>
                                <!--<li><a class="renderGames" href="#" data-location="top" data-type="provider" data-id="2">NET</a></li>-->
                                <li><a class="renderGames" href="#" data-location="top" data-type="provider" data-id="1">MLS</a></li>
                                <li><a class="renderGames" href="#" data-location="top" data-type="provider" data-id="3">TPG</a></li>
                                <li><a class="renderGames" href="#" data-location="top" data-type="provider" data-id="4">1X2</a></li>
                                <li><a class="renderGames" href="#" data-location="top" data-type="provider" data-id="5">AMY</a></li>
                                <li><a class="renderGames" href="#" data-location="top" data-type="provider" data-id="6">CTY</a></li>
                                <li><a class="renderGames" href="#" data-location="top" data-type="provider" data-id="7">ELK</a></li>
                                <!--<li><a class="renderGames" href="#" data-location="top" data-type="provider" data-id="8">EVL</a></li>-->
                                <li><a class="renderGames" href="#" data-location="top" data-type="provider" data-id="10">NGN</a></li>
                                <li><a class="renderGames" href="#" data-location="top" data-type="provider" data-id="11">PSN</a></li>
                                <li><a class="renderGames" href="#" data-location="top" data-type="provider" data-id="13">TWB</a></li>
                                <li><a class="renderGames" href="#" data-location="top" data-type="provider" data-id="14">VGS</a></li>
                                <li><a class="renderGames" href="#" data-location="top" data-type="provider" data-id="15">WMG</a></li>
                                <li><a class="renderGames" href="#" data-location="top" data-type="provider" data-id="16">MRS</a></li>
                                <li><a class="renderGames" href="#" data-location="top" data-type="provider" data-id="17">PTG</a></li>
                                <li><a class="renderGames" href="#" data-location="top" data-type="provider" data-id="18">PPY</a></li>
                              </ul>
                            </div><!-- /.navbar-collapse -->
                        </div><!-- /.container-fluid -->
                    </nav>

                    <div class="row" id="slots_list"></div>

                </div>
                <div class="col-md-2">

                    <div class="input-group" id="search">
                      <input type="text" class="form-control" placeholder="{{$lang_arr.search}}">
                      <span class="input-group-btn">
                        <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                      </span>
                    </div><!-- /input-group -->


                    <div class="panel panel-branded">
                      <div class="panel-heading">{{$lang_arr.categories}}</div>

                      <div class="list-group" id="casino_cats">
                        <a href="#" class="renderGames list-group-item" data-type="category" data-id="" id="cat_all">{{$lang_arr.all_providers}}</a>
                        <a href="#" class="renderGames list-group-item" data-type="category" data-id="4" id="cat_4">{{$lang_arr.new}}</a>
                        <a href="#" class="renderGames list-group-item" data-type="category" data-id="1" id="cat_1">{{$lang_arr.classic_slots}}</a>
                        <a href="#" class="renderGames list-group-item" data-type="category" data-id="2" id="cat_2">{{$lang_arr.lottery_games}}</a>
                        <a href="#" class="renderGames list-group-item" data-type="category" data-id="3" id="cat_3">{{$lang_arr.mini_games}}</a>
                        <a href="#" class="renderGames list-group-item" data-type="category" data-id="5" id="cat_5">{{$lang_arr.other_games}}</a>
                        <a href="#" class="renderGames list-group-item" data-type="category" data-id="6" id="cat_6">{{$lang_arr.popular_games}}</a>
                        <a href="#" class="renderGames list-group-item" data-type="category" data-id="7" id="cat_7">{{$lang_arr.table_games}}</a>
                        <a href="#" class="renderGames list-group-item" data-type="category" data-id="8" id="cat_8">{{$lang_arr.top_slots}}</a>
                        <a href="#" class="renderGames list-group-item" data-type="category" data-id="9" id="cat_9">{{$lang_arr.video_slots}}</a>
                        <a href="#" class="renderGames list-group-item" data-type="category" data-id="10" id="cat_10">{{$lang_arr.video_poker}}</a>
                    </div>


                    </div>
                </div>


            </div> <!-- .row -->
        </div> <!-- .container -->
    {{else}}
        <div class="container page-container" style="margin-top:30px;">
            <div class="row">
                <div class="col-md-12 page-content">
                    <div class="content">
                        <h1>COMING SOON</h1>
                        {{$ip}}
                    </div>
                </div>
            </div>
        </div>
    {{/if}}

    <script>
        var render_opt = {prov: '', cat: 11};

        document.addEventListener("DOMContentLoaded", function(event) {
            Casino.casinoPageAssets();
            Casino.renderGames(render_opt);
        });
    </script>

    {{$Data.modules.footer}}
