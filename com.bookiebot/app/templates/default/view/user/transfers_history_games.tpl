{{$Data.modules.header}}
<body>

<div class="wrapper">

    {{$Data.modules.topmenu}}
    {{$Data.modules.bettingmenu}}

    <div class="container">

        <div class="row">

            <div class="col-md-12">


                {{$Data.modules.accountmenu}}
                {{$Data.modules.accountsubmenu}}


                <div class="panel panel-default panel-profile no-space">

                    <div class="row" style="padding-top:15px">
                        <div class="col-md-6 col-md-offset-3">
                            <div class="container-fluid no-space">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <input type="text" placeholder="Date from"
                                               class="form-control input-default full-width"
                                               id="dpd1">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <input type="text" placeholder="Date to"
                                               class="form-control input-default full-width"
                                               id="dpd2">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <input type="submit" class="btn btn-28 btn-space btn-dark-blue"
                                               id="SubmitGameTransactionsSearch" value="Search">
                                    </div>
                                </div>
                                <!-- row -->

                            </div>
                            <!-- container -->
                        </div>
                        <!-- col -->
                    </div>

                    <table class="table table-custom" id="gameTransactionsHistory">
                        <thead>
                        <tr>
                            <th>{{$lang_arr.date}}</th>
                            <th>{{$lang_arr.provider}}</th>
                            <th>{{$lang_arr.amount}} (&#8364;)</th>
                            <th>{{$lang_arr.transfer_type}}</th>
                            <th>{{$lang_arr.transfer_status}}</th>
                            <th>IP</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="9" class="text-right large-space">

                            </td>
                        </tr>
                        </tfoot>

                    </table>
                </div>
                <!-- panel -->
            </div>
            <!-- col -->

        </div>
        <!-- row -->

    </div>
    <!-- container -->



    {{$Data.modules.footer}}

    <script type="text/javascript">
        GameTransactions.getData();
        $('#dpd1').datepicker({
            dateFormat:"yy-mm-dd"
        });
        $('#dpd2').datepicker({
            dateFormat:"yy-mm-dd"
        });
    </script>


