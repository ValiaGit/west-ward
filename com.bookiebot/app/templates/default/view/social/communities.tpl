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
            <div class="col-md-9">


                <div class="friends-list">
                    <h1 class="page-title" style="padding-left:20px;font-size:18px;margin-bottom:15px;">All Communities
                        <button class="btn btn-success btn-sm pull-right" onclick="Community.OpenCreateClubPopup();" style="margin-right:10px">
                            <span class="glyphicon glyphicon-plus"></span>
                            Create Club
                        </button>
                    </h1>

                        <div class="container-fluid">
                            <hr />
                            <div class="row " id="AllCommunities">
                            </div>
                            <!-- row -->
                        </div>
                    <!-- container-fluid -->
                </div>
                <!-- friends-list -->

            </div>



        </div>

    </div>

    {{$Data.modules.footer}}
    <script src="{{$THEME}}/js/libs/highslide/highslide.js"></script>
    <script>
        Community.getMyCommunitiesList();
        Community.getAllCommunities();
        UpcomingsWidget.getData();
    </script>



