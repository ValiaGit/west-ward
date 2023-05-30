{{$Data.modules.header}}
<body class="page-social">

<div class="wrapper">

    {{$Data.modules.topmenu}}
    {{$Data.modules.bettingmenu}}

    <div class="container">

        <div class="row">
            <div class="col-md-3 social-sidebar">

                <ul class="nav nav-page nav-social">
                    {{$Data.modules.socialmenu}}
                </ul>

                <div class="nav-social-heading">
                    <h3><i class="glyphicon glyphicon-user social-nav-icon"></i> {{$lang_arr.my_community}}</h3>
                </div>

                <ul class="nav nav-page nav-social" id="my_communities">

                </ul>

            </div>
            <div class="col-md-6">

                <div class="block-profile">
                <div class="profile-head">
                <div class="thumb">
                <img src="/app/templates/default/view/_media/images/no-avatar.jpg" alt="" />
                </div>
                <!-- thumb -->
                <div class="details">
                <h2>Name Lastname</h2>
                <p>1 september. 1990  &nbsp;&bull;&nbsp; Tbilisi. Georgia</p>
                </div>
                <!-- details -->
                <div class="buttons">
                <button class="btn btn-sm btn-profile">Add Friend</button>
                <button class="btn btn-sm btn-profile">Message</button>
                </div>
                <!-- buttons -->
                </div>
                <!-- profile-head -->
                <div class="profile-bottom">
                <ul>
                <li>Bets: <span>54</span></li>
                <li>Wins: <span>54</span></li>
                <li>Losts: <span>54</span></li>
                </ul>
                </div>
                <!-- profile-bottom -->
                </div>
                <!--block-profile -->

            </div>

            <div class="col-md-3 social-matches">

                <div class="heading">
                    <h2>
                        {{$lang_arr.upcoming}}
                    </h2>
                </div>



                <div id="upcoming_widget">
                </div>


            </div>


        </div>

    </div>

    {{$Data.modules.footer}}

    <script>
        Friends.init();
        Community.getMyCommunitiesList();
        UpcomingsWidget.getData();
    </script>



