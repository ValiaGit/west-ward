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


                <div class="friends-list">
                    <h1 class="page-title" style="padding-left:20px;font-size:18px;margin-bottom:15px;">Friends</h1>
                    <div class="container-fluid">

                        <div class="row" id="MyFriendsList">
                        </div>
                        <!-- row -->
                    </div>
                    <!-- container-fluid -->
                </div>
                <!-- friends-list -->

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



