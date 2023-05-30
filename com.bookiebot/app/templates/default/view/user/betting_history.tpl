{{$Data.modules.header}}
<script type="text/javascript">
    var whereami = "history";
</script>
<body class="page-betting-history">

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
                            <h2 class="panel-title">{{$lang_arr.betting_history}}</h2>
                            <hr>
                            <!--<h4 class="hidden" id="no_history_bets">You Dont Have Placed Any Bets Yet!</h4>
-->

                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-8 col-md-offset-2">
                                        <form method="POST" action="" class="form-inline">

                                            <div class="container-fluid no-space">
                                                <form method="POST" onsubmit="History.search(this);return false;">
                                                    <div class="row">
                                                        <div class="form-group col-md-2">
                                                            <input type="text" placeholder="{{$lang_arr.date_from}}" class="form-control input-default full-width" id="dpd1"/>
                                                        </div>
                                                        <div class="form-group col-md-2">
                                                            <input type="text" placeholder="{{$lang_arr.date_to}}" class="form-control input-default full-width" id="dpd2"/>
                                                        </div>
                                                        <div class="form-group col-md-2">
                                                            <select id="bet_type" class="form-control input-default full-width">
                                                                <option value="-1   ">{{$lang_arr.bet_type}}</option>
                                                                <option value="1">{{$lang_arr.lay}}</option>
                                                                <option value="2">{{$lang_arr.back}}</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-3">
                                                            <select id="bet_status" class="form-control input-default full-width">
                                                                <option value="-1">{{$lang_arr.bet_status}}</option>
                                                                <option value="0">{{$lang_arr.bet_made}}</option>
                                                                <option value="1">{{$lang_arr.fully_matched}}</option>
                                                                <option value="2">{{$lang_arr.partially_matched}}</option>
                                                                <option value="3">{{$lang_arr.won}}</option>
                                                                <option value="4">{{$lang_arr.lose}}</option>
                                                                <option value="5">{{$lang_arr.canceled_received_money}}</option>
                                                                <option value="6">{{$lang_arr.partially_canceled}}</option>
                                                                <option value="7">{{$lang_arr.partially_canceled_lost}}</option>
                                                                <option value="9">{{$lang_arr.partially_canceled_won}}</option>
                                                                <option value="10">{{$lang_arr.not_matched_returned_money}}</option>
                                                                <option value="11">{{$lang_arr.private_rejected}}</option>
                                                                <option value="12">{{$lang_arr.private_accepted}}</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-1">
                                                            <input type="submit" class="btn btn-28 btn-space btn-dark-blue" id="SubmitHistorySearch" value="{{$lang_arr.search}}"/>
                                                        </div>
                                                    </div>
                                                    <!-- row -->
                                                </form>
                                            </div>
                                            <!-- container -->

                                        </form>
                                    </div>
                                    <!-- col -->
                                </div>
                                <!-- row -->
                            </div>
                            <!-- container -->

                        </div>
                        <!-- col -->
                    </div>
                    <!-- row -->
                </div>
                <!-- container -->

                <table class="table table-custom hidden" id="bets_history_table">
                    <thead>
                    <tr>
                        <th>{{$lang_arr.market}}</th>
                        <th>{{$lang_arr.selection}}</th>
                        <th>{{$lang_arr.bid_type}}</th>
                        <th>{{$lang_arr.bet_id}}</th>
                        <th>{{$lang_arr.bet_placed}}</th>
                        <th>{{$lang_arr.odds_req}}</th>
                        <th>{{$lang_arr.stake}} (&#8364;)</th>
                        <th>{{$lang_arr.unmatched}} (&#8364;)</th>
                        <th>{{$lang_arr.status}}</th>
                        <th>{{$lang_arr.profit_loss}}(&#8364;)</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="10" class="text-right large-space">{{$lang_arr.betting_history_text}}</td>
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
    $('#dpd1').datepicker();
    $('#dpd2').datepicker();
</script>
