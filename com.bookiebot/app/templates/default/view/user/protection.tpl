{{$Data.modules.header}}

{{$label_class = 'control-label col-md-3'}}
{{$input_class = 'col-md-9'}}
{{$form_class = '_col-md-5 _col-md-offset-3'}}
<style>
    .protection-tab {
        position: relative;
    }

    .disable_group {
        display: none;
    }

    .disable_protection_overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        min-height: 230px;
        z-index: 999;
        background: black;
        opacity: 0.6;
        padding: 10px;
    }

    .disable_protection {
        z-index: 9999;
        position: absolute;
        margin: 50px auto;
        width: 100%;
        text-align: center;
        color: white;
    }
</style>
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
                            <div class="col-md-12">

                                <h2 class="panel-title">プレイヤー保護</h2>
                                <hr>


                                <div class="protection-group-info" style="font-size:14px;padding-left:10px;">
                                    <p>
                                        {{$lang_arr.we_offer_protection_types}}
                                    </p>

                                    <!--<ul style="list-style-type: circle;padding-left:25px;font-size:12px;margin-top:5px;">
                                        <li style="margin-bottom: 4px;">
                                            <strong>Deposit Limit - </strong>Limit the amount of money which you can
                                            deposit into your Betplanet account in a specific period of time.
                                            Loss/Transfer Limits
                                        </li>
                                        <li style="margin-bottom: 4px;">
                                            <strong>Losing Amount Limit - </strong> Limit the amount of money that you
                                            can lose for specific period of time
                                        </li>
                                        <li style="margin-bottom: 4px;">
                                            <strong>Wagering Limit - </strong> You can set the maximum wagering limit per day, week or month.

                                        </li>
                                        <li style="margin-bottom: 4px;">
                                            <strong>Session Time Out - </strong>  If you exceed the session time limit, you will be logged out from the system and you will be able to resume playing by logging in again.
                                        </li>
                                        <li style="margin-bottom: 4px;">
                                            <strong>Self-Exclusion - </strong> This will prevent you from using the
                                            site, for at least 6 months. This action cannot be reversed under any
                                            circumstances.
                                        </li>
                                    </ul>-->

                                </div>

                                <br/>


                                <div>

                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active">
                                            <a href="#pr1" aria-controls="pr1" role="tab" data-toggle="tab">{{$lang_arr.time_out}}</a>
                                        </li>
                                        <li role="presentation">
                                            <a href="#pr2" aria-controls="pr2" role="tab" data-toggle="tab">{{$lang_arr.deposit_limits}}</a></li>
                                        <li role="presentation">
                                            <a href="#pr3" aria-controls="pr3" role="tab" data-toggle="tab">{{$lang_arr.self_exculsion}}</a>
                                        </li>
                                        <li role="presentation">
                                            <a href="#pr4" aria-controls="pr4" role="tab" data-toggle="tab">{{$lang_arr.loss_limits}}</a>
                                        </li>
                                        <li role="presentation">
                                            <a href="#pr5" aria-controls="pr5" role="tab" data-toggle="tab">{{$lang_arr.wager_limits}}</a>
                                        </li>
                                        <li role="presentation">
                                            <a href="#pr6" aria-controls="pr6" role="tab" data-toggle="tab">{{$lang_arr.session_protection}}</a>
                                        </li>
                                    </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content">


                                        <!-- TimeOut -->
                                        <div role="tabpanel" class="tab-pane protection-tab active" id="pr1">
                                            <div class="disable_group disable_protection_overlay">
                                            </div>
                                            <div class="disable_group disable_protection">
                                                <p>Protection will be reset on: <span class="expiry_date_Val"></span>
                                                </p><br/>
                                                <button class="btn btn-danger disable-button disable-button"
                                                        onclick="Protection.disableProtection(this);return false;">
                                                    Disable Protection
                                                </button>
                                            </div>

                                            <div class="panel-body">
                                                <p style="width: 80%; line-height: 1.5em; margin-bottom: 22px;">
                                                    <!---->
                                                    {{$lang_arr.time_out_protection_text}}
                                                </p>
                                                <form action="" onsubmit="Protection.addProtection(this);return false;"
                                                      class="form-horizontal">

                                                    <div class="form-group">
                                                        <label class="control-label col-md-1">{{$lang_arr.period}}:</label>
                                                        <input type="hidden" name="core_protection_types_id" value="1"/>
                                                        <div class="col-md-11">
                                                            <select name="period_id"
                                                                    class="form-control period input-default">
                                                                <option value="1">24 Hours</option>
                                                                <option value="2">48 Hours</option>
                                                                <option value="4">7 Days</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-md-1">{{$lang_arr.password}}:</label>
                                                        <div class="col-md-11">
                                                            <input type="password" name="account_password"
                                                                   class="form-control input-default"
                                                                   placeholder="{{$lang_arr.enter_account_password}}">
                                                        </div>

                                                    </div>


                                                    <div class="alert alert-success col-md-4 col-md-offset-8 hidden is-active-alert"
                                                         role="alert">
                                                        <span class="protection_status_text"></span>
                                                        <button class="btn btn-danger disable-button pull-right"
                                                                onclick="Protection.disableProtection(this);return false;">
                                                            Disable
                                                        </button>
                                                    </div>

                                                    <div class="form-group">
                                                        <input type="submit" class="btn btn-block btn-dark-blue"
                                                               value="{{$lang_arr.make_changes}}">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>


                                        <!-- Depost Limit -->
                                        <div role="tabpanel" class="tab-pane protection-tab" id="pr2">
                                            <div class="disable_group disable_protection_overlay">
                                            </div>
                                            <div class="disable_group disable_protection">
                                                <p>Protection will be reset on: <span class="expiry_date_Val"></span>
                                                </p><br/>
                                                <button class="btn btn-danger disable-button"
                                                        onclick="Protection.disableProtection(this);return false;">
                                                    Disable Protection
                                                </button>
                                            </div>
                                            <div class="panel-body">
                                                <!-- Depost Limit -->
                                                <p style="width: 80%; line-height: 1.5em; margin-bottom: 22px;">
                                                    {{$lang_arr.deposit_limits_protection_protection_text}}
                                                </p>
                                                <form action="" onsubmit="Protection.addProtection(this);return false;"
                                                      class="form-horizontal">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-1">{{$lang_arr.period}}:</label>
                                                        <input type="hidden" name="core_protection_types_id" value="2"/>
                                                        <div class="col-md-11">
                                                            <select name="period_id"
                                                                    class="form-control period input-default">
                                                                <option value="7">Per Day</option>
                                                                <option value="8">Per Week</option>
                                                                <option value="9">Per Month</option>
                                                                <option value="10">Per Year</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-md-1">{{$lang_arr.amount}} (&#8364;):</label>
                                                        <div class="col-md-11">
                                                            <input type="text" name="amount"
                                                                   class="form-control input-default amount-input"
                                                                   placeholder="Enter amount" autocomplete="false">
                                                        </div>

                                                    </div>

                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1" class="col-md-1">{{$lang_arr.account_password}}:</label>
                                                        <div class="col-md-11">
                                                            <input type="password" name="account_password"
                                                                   class="form-control input-default"
                                                                   placeholder="{{$lang_arr.enter_account_password}}">
                                                        </div>
                                                    </div>


                                                    <div class="alert alert-success col-md-4 col-md-offset-8 hidden is-active-alert"
                                                         role="alert">
                                                        <span class="protection_status_text"></span>
                                                        <button class="btn btn-danger disable-button pull-right"
                                                                onclick="Protection.disableProtection(this);return false;">
                                                            Disable
                                                        </button>
                                                    </div>

                                                    <div class="form-group">
                                                        <input type="submit" class="btn btn-block btn-dark-blue"
                                                               value="{{$lang_arr.make_changes}}">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <!-- Self Exclusion -->
                                        <div role="tabpanel" class="tab-pane protection-tab" id="pr3">
                                            <div class="disable_group disable_protection_overlay">
                                            </div>
                                            <div class="disable_group disable_protection">
                                                <p>Protection will be reset on: <span class="expiry_date_Val"></span>
                                                </p><br/>
                                                <button class="btn btn-danger disable-button"
                                                        onclick="Protection.disableProtection(this);return false;">
                                                    Disable Protection
                                                </button>
                                            </div>
                                            <div class="panel-body">

                                                <p style="width: 80%; line-height: 1.5em; margin-bottom: 22px;">
                                                    {{$lang_arr.self_exculsion_protection_text}}
                                                </p>

                                                <form action="" onsubmit="Protection.addProtection(this);return false;"
                                                      class="form-horizontal">
                                                    <input type="hidden" name="core_protection_types_id" value="3"/>
                                                    <input type="hidden" name="period_id" value="6"/>
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1" class="col-md-1">Account
                                                            password</label>
                                                        <div class="col-md-11">
                                                            <input type="password" name="account_password"
                                                                   class="form-control input-default"
                                                                   placeholder="{{$lang_arr.enter_account_password}}">
                                                        </div>

                                                    </div>

                                                    <div class="alert alert-success col-md-4 col-md-offset-8 hidden is-active-alert"
                                                         role="alert">
                                                        <span class="protection_status_text"></span>
                                                        <button class="btn btn-danger disable-button pull-right"
                                                                onclick="Protection.disableProtection(this);return false;">
                                                            Disable
                                                        </button>
                                                    </div>

                                                    <div class="form-group">
                                                        <input type="submit" class="btn btn-block btn-dark-blue"
                                                               value="{{$lang_arr.make_changes}}">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>


                                        <!-- Loss Amount -->
                                        <div role="tabpanel" class="tab-pane protection-tab" id="pr4">
                                            <div class="disable_group disable_protection_overlay">
                                            </div>
                                            <div class="disable_group disable_protection">
                                                <p>Protection will be reset on: <span class="expiry_date_Val"></span>
                                                </p><br/>
                                                <button class="btn btn-danger disable-button"
                                                        onclick="Protection.disableProtection(this);return false;">
                                                    Disable Protection
                                                </button>
                                            </div>
                                            <div class="panel-body">
                                                <!-- Loss Amount -->
                                                <p style="width: 80%; line-height: 1.5em; margin-bottom: 22px;">
                                                    {{$lang_arr.loss_limits_protection_text}}
                                                </p>

                                                <form action="" onsubmit="Protection.addProtection(this);return false;"
                                                      class="form-horizontal">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1" class="col-md-1">{{$lang_arr.period}}:</label>
                                                        <input type="hidden" name="core_protection_types_id" value="4"/>
                                                        <div class="col-md-11">
                                                            <select name="period_id"
                                                                    class="form-control period input-default">
                                                                <option value="7">Per Day</option>
                                                                <option value="8">Per Week</option>
                                                                <option value="9">Per Month</option>
                                                                <option value="10">Per Year</option>
                                                            </select>
                                                        </div>

                                                    </div>

                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1" class="col-md-1">{{$lang_arr.amount}} (&#8364;):</label>
                                                        <div class="col-md-11">
                                                            <input type="text" name="amount"
                                                                   class="form-control input-default amount-input"
                                                                   placeholder="Enter amount">
                                                        </div>

                                                    </div>

                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1" class="col-md-1">{{$lang_arr.account_password}}</label>
                                                        <div class="col-md-11">
                                                            <input type="password" name="account_password"
                                                                   class="form-control input-default"
                                                                   placeholder="{{$lang_arr.enter_account_password}}">
                                                        </div>

                                                    </div>

                                                    <div class="alert alert-success col-md-4 col-md-offset-8 hidden is-active-alert"
                                                         role="alert">
                                                        <span class="protection_status_text"></span>
                                                        <button class="btn btn-danger disable-button pull-right"
                                                                onclick="Protection.disableProtection(this);return false;">
                                                            Disable
                                                        </button>
                                                    </div>

                                                    <div class="form-group">
                                                        <input type="submit" class="btn btn-block btn-dark-blue"
                                                               value="{{$lang_arr.make_changes}}">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>


                                        <!-- Wagering -->
                                        <div role="tabpanel" class="tab-pane protection-tab" id="pr5">
                                            <div class="disable_group disable_protection_overlay">
                                            </div>
                                            <div class="disable_group disable_protection">
                                                <p>Protection will be reset on: <span class="expiry_date_Val"></span>
                                                </p><br/>
                                                <button class="btn btn-danger disable-button"
                                                        onclick="Protection.disableProtection(this);return false;">
                                                    Disable Protection
                                                </button>
                                            </div>
                                            <div class="panel-body">
                                                <!-- Wagering -->
                                                <p style="width: 80%; line-height: 1.5em; margin-bottom: 22px;">
                                                    {{$lang_arr.wager_limits_protection_text}}
                                                </p>
                                                <form action="" onsubmit="Protection.addProtection(this);return false;"
                                                      class="form-horizontal">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1" class="col-md-1">{{$lang_arr.period}}:</label>
                                                        <input type="hidden" name="core_protection_types_id" value="5"/>
                                                        <div class="col-md-11">
                                                            <select name="period_id"
                                                                    class="form-control period input-default">
                                                                <option value="7">Per Day</option>
                                                                <option value="8">Per Week</option>
                                                                <option value="9">Per Month</option>
                                                                <option value="10">Per Year</option>
                                                            </select>
                                                        </div>

                                                    </div>

                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1" class="col-md-1">{{$lang_arr.amount}} (&#8364;):</label>
                                                        <div class="col-md-11">
                                                            <input type="text" name="amount"
                                                                   class="form-control amount-input input-default"
                                                                   placeholder="Enter amount" autocomplete="false">
                                                        </div>

                                                    </div>

                                                    <div class="form-group">{{$lang_arr.password}}</label>
                                                        <div class="col-md-11">
                                                            <input type="password" name="account_password"
                                                                   class="form-control input-default"
                                                                   placeholder="{{$lang_arr.enter_account_password}}"
                                                                   autocomplete="off">
                                                        </div>

                                                    </div>


                                                    <div class="alert alert-success col-md-4 col-md-offset-8 hidden is-active-alert"
                                                         role="alert">
                                                        <span class="protection_status_text"></span>
                                                        <button class="btn btn-danger disable-button pull-right"
                                                                onclick="Protection.disableProtection(this);return false;">
                                                            Disable
                                                        </button>
                                                    </div>

                                                    <div class="form-group">
                                                        <input type="submit" class="btn btn-block btn-dark-blue"
                                                               value="{{$lang_arr.make_changes}}">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>


                                        <!-- Session  Timeout -->
                                        <div role="tabpanel" class="tab-pane protection-tab" id="pr6">
                                            <div class="disable_group disable_protection_overlay">
                                            </div>
                                            <div class="disable_group disable_protection">
                                                <p>Protection will be reset on: <span class="expiry_date_Val"></span>
                                                </p><br/>
                                                <button class="btn btn-danger disable-button disable-button"
                                                        onclick="Protection.disableProtection(this);return false;">
                                                    Disable Protection
                                                </button>
                                            </div>

                                            <div class="panel-body">
                                                <!-- Session  Timeout -->
                                                <p style="width: 80%; line-height: 1.5em; margin-bottom: 22px;">
                                                    {{$lang_arr.session_protection_text}}
                                                </p>
                                                <form action="" onsubmit="Protection.addProtection(this);return false;"
                                                      class="form-horizontal">
                                                    <input type="hidden" name="period_id" value="0"/>
                                                    <input type="hidden" name="core_protection_types_id" value="6"/>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-1">{{$lang_arr.amount_in_minutes}}:</label>
                                                        <div class="col-md-11">
                                                            <input type="text" name="period_minutes"
                                                                   class="form-control period_minutes input-default"
                                                                   placeholder="">
                                                        </div>

                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-md-1">{{$lang_arr.password}}:</label>
                                                        <div class="col-md-11">
                                                            <input type="password" name="account_password"
                                                                   class="form-control input-default"
                                                                   placeholder="{{$lang_arr.enter_account_password}}">
                                                        </div>

                                                    </div>


                                                    <div class="alert alert-success col-md-4 col-md-offset-8 hidden is-active-alert"
                                                         role="alert">
                                                        <span class="protection_status_text"></span>
                                                        <button class="btn btn-danger disable-button pull-right"
                                                                onclick="Protection.disableProtection(this);return false;">
                                                            Disable
                                                        </button>
                                                    </div>

                                                    <div class="form-group">
                                                        <input type="submit" class="btn btn-block btn-dark-blue"
                                                               value="{{$lang_arr.make_changes}}">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>



                                    </div>

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


    {{$Data.modules.footer}}
    <script>
        Protection.getProtectionTypes();
    </script>



