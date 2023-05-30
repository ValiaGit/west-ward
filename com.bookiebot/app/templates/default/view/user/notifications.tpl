{{$Data.modules.header}}

{{$label_class = 'control-label col-md-3'}}
{{$input_class = 'col-md-9'}}
{{$form_class = '_col-md-5 _col-md-offset-3'}}

<body>

<div class="wrapper">
    {{$Data.modules.topmenu}}

    {{$Data.modules.bettingmenu}}




    <div class="container">

        <div class="row">

            <div class="col-md-12">

                {{$Data.modules.accountmenu}}

                <div class="panel panel-default panel-profile">

                    <div class="container-fluid" style="padding-bottom:25px">
                        <div class="row">
                            <div class="col-md-4">

                                <div class="panel panel-default">
                                    <div class="panel-heading">{{$lang_arr.friend_requests}}</div>
                                    <div class="panel-body" id="ReceivedRequests">



                                    </div>
                                </div>

                            </div>
                            <!--<div class="col-md-4">
                                <div class="panel panel-default">
                                    <div class="panel-heading">Requested Bets</div>
                                    <div class="panel-body">
                                        Panel content
                                    </div>
                                </div>

                            </div>-->
                            <!--<div class="col-md-4">
                                <div class="panel panel-default">
                                    <div class="panel-heading">Social</div>
                                    <ul class="list-group">
                                        <li class="list-group-item">Cras justo odio</li>
                                        <li class="list-group-item">Dapibus ac facilisis in</li>
                                        <li class="list-group-item">Morbi leo risus</li>
                                        <li class="list-group-item">Porta ac consectetur ac</li>
                                        <li class="list-group-item">Vestibulum at eros</li>
                                    </ul>
                                </div>
                            </div>-->

                            <!-- col -->
                        </div>
                        <!-- row -->
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


    {{$Data.modules.footer}}
    <script>
        Friends.getReceivedRequests();
    </script>



