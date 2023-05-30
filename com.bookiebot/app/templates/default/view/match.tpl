{{$Data.modules.header}}
<body class="page-match">

<div class="wrapper">

    {{$Data.modules.topmenu}}


    {{$Data.modules.bettingmenu}}



    <div class="container main-container">
        <div class="row">
            {{include file='view/includes/Betting/Left.tpl'}}

                <div class="col-md-6 match-container">
                    <div id="odds-panel"></div>
                    <div class="match-heading soccer">
                        <div class="heading-bar">
                            <h2 id="match_cat_tournament"></h2>
                            <a class="btn-close" href="{{$base_href}}/{{$cur_lang}}">
                                <i class="icon-close-alt"></i>
                            </a>
                            <!-- btn-close -->
                        </div>
                        <!-- heading-bar -->
                        <div class="data">
                            <div class="date" id="matchDate"></div>
                            <div class="teams" id="matchTeams"></div>
                        </div>
                    </div>
                    <!-- match heading -->

                    <div class="match-details">

                        <!--<ul class="nav nav-tabs match-tabs tabs-5 hidden" id="marketTabs">
                            <li class="active"><a href="#match-tab-1" role="tab" data-toggle="tab">Popular</a></li>
                            <li><a href="#match-tab-2" data-toggle="tab">Team Markets</a></li>
                            <li><a href="#match-tab-3" data-toggle="tab">Goal Markets</a></li>
                            <li><a href="#match-tab-4" data-toggle="tab">Score Markets</a></li>
                            <li><a href="#match-tab-5" data-toggle="tab">Player Markets</a></li>
                        </ul>
                         tabs -->

                        <div class="tab-content">
                            <div class="tab-pane active" id="match-tab-1">
                                <div id="matchOdds"></div>
                            </div>
                            <div class="tab-pane" id="match-tab-2">...</div>
                            <div class="tab-pane" id="match-tab-3">s</div>
                            <div class="tab-pane" id="match-tab-4">...</div>
                            <div class="tab-pane" id="match-tab-5">...</div>
                        </div>
                        <!-- tab content -->


                    </div>
                    <!-- match details -->
                </div>
                <!-- match container -->

            {{include file='view/includes/Betting/Right.tpl'}}

        </div>
        <!-- row -->
    </div>
    <!-- container -->



    {{$Data.modules.footer}}

    <script>
        var opened_match_id = {{$Data.match_id}};
        Matches.getMatch({{$Data.match_id}});
    </script>

