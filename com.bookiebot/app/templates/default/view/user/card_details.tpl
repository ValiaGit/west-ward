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
                    <div class="container-fluid">
                        <div class="row">
                            <div class="inside-panel">

                                <div class="inside-content">
                                    <div style="margin-bottom:10px;">
                                        <a href="#" onclick="Cards.openAddPopup(1);return false;"
                                           class="btn btn-default">
                                            <span class="glyphicon glyphicon-plus"></span> Add Card Account
                                        </a>
                                        <a href="#" onclick="Cards.openAddPopup(2);return false;"
                                           class="btn btn-default">
                                            <span class="glyphicon glyphicon-plus"></span> Add Bank Account
                                        </a>
                                        <br/>
                                    </div>

                                    <table class="table table-bordered" id="cards_list">
                                        <thead>
                                        <tr>
                                            <th>Account Type</th>
                                            <th>Account Number</th>
                                            <th>Add Date</th>
                                            <th>Confirmation
                                                <i style="cursor:pointer" class="hist_tooltip" data-original-title="To confirm Payment Account send us copy of Cred/Debit Card on email: support@bookiebot.com. In case of Bank Account send us copy of Bank statement where we can see Account holders name, Bank name and Account number, also at support@bookiebot.com">(?)</i>
                                            </th>
                                            <th width="215px">Deposited money on balance (&#8364;)
                                                <i style="cursor:pointer"  class="hist_tooltip" data-original-title="The Amount, which was deposited from current account and is still in system, was not withdrawed or lost">(?)</i>
                                            </th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>

                                </div>

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

    <!-- Cashier Classes -->

    {{$Data.modules.footer}}
    <script>
        Cards.getCardAccounts();
    </script>



