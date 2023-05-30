{{$Data.modules.header}}
<body>

<div class="wrapper">

    {{$Data.modules.topmenu}}

    {{$Data.modules.bettingmenu}}

    <div class="container">

        <div class="row">

            <div class="col-md-12">


                {{$Data.modules.accountmenu}}


                <div class="panel panel-default panel-profile">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <h2 class="panel-title">Access Log</h2>
                                <hr />
                            </div>
                            <!-- col -->
                        </div>
                        <!-- row -->
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                <table id="access_log" class="table table-access table-custom-border table-custom" style="margin-bottom:20px;">
                                    <thead>
                                        <th class="text-center">Access Date</th>
                                        <th class="text-center">Access IP</th>
                                        <th class="text-center"></th>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
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
        AccessLog.getData("2014-01-01","2016-01-01");
    </script>


