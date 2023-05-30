<div class="col-md-3 right-sidebar" data-step="3" data-intro="Your chosen events will be shown in betslip">
    <div id="undefined-sticky-wrapper" class="sticky-wrapper" style="height: 100px;">
        <div class="panel betslip"  id="BetSlip">
            <div class="panel-heading">
                <ul class="nav nav-tabs">
                    <li class="active hidden betslip_tab">
                        <a href="#betslip-1" data-toggle="tab" id="betslip-1-clicker">{{$lang_arr.betslip}}</a>
                    </li>
                    <li class="hidden betslip_tab">
                        <a href="#betslip-2" data-toggle="tab" id="betslip-2-clicker">{{$lang_arr.open_bets}}
                            <em id="opened_bets_num"></em>
                        </a>
                    </li>
                    <li class="hidden betslip_tab">
                        <a href="#betslip-3" data-toggle="tab" id="betslip-3-clicker">{{$lang_arr.received_bets}}
                            <em id="received_bets_num"></em>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="tab-content">
                <div class="tab-pane active" id="betslip-1">
                    <div class="panel-body has-error has-back has-lay">

                        <div class="betslip_back">
                            <div class="container-fluid">
                                <div class="row no-padding" id="back_title">
                                    <div class="col-th col-md-6"><em>{{$lang_arr.back}}</em></div>
                                    <div class="col-th col-md-2">{{$lang_arr.odds}}</div>
                                    <div class="col-th col-md-2">{{$lang_arr.stake}}<br/> ({{$lang_arr.min}}. 2€)</div>
                                    <div class="col-th col-md-2 profit">{{$lang_arr.profit}}</div>
                                </div>
                            </div>
                            <div class="odds_holder" id="BackBets"></div>
                        </div>

                        <div class="betslip_lay">
                            <div class="container-fluid">
                                <div class="row no-padding" id="lay_title">
                                    <div class="col-th col-md-6"><em>{{$lang_arr.lay}}</em></div>
                                    <div class="col-th col-md-2">{{$lang_arr.odds}}</div>
                                    <div class="col-th col-md-2">{{$lang_arr.stake}} <br/> ({{$lang_arr.min}}. 2€)</div>
                                    <div class="col-th col-md-2 profit">{{$lang_arr.liability}}</div>
                                </div>
                            </div>

                            <div class="odds_holder" id="LayBets"></div>
                        </div>

                        <div class="betslip-buttons">
                            <div class="liability">{{$lang_arr.liability}}: <span class="liability-total" id="Liability">0.00 &#8364;</span>
                            </div>
                            <input id="ClearBetSlipBtn" type="button" class="btn btn-dark betslipButton clear"
                                   value="{{$lang_arr.cancel}}">
                            <input id="PlaceBetBtn" type="button" class="btn btn-bs-blue betslipButton place"
                                   value="{{$lang_arr.place_bets}}">
                        </div>

                        <span id="betlip_placeholder" class="betlip_placeholder">
                            {{$lang_arr.betslip_empty}}
                            <br/>
                            <br/>
                            <button class="btn btn-small" onclick="Autobet.make()">Auto Selection</button>
                        </span>
                    </div>
                </div>

                <div class="tab-pane" id="betslip-2">
                    <div class="panel-body">

                        <div class="empty-placeholder" style="display: none;">
                            <span class="" style="padding:10px;">{{$lang_arr.no_open_bets}}</span>
                        </div>
                        <div class="betslip_back">
                            <div class="container-fluid">
                                <div class="row no-padding" id="back_title">
                                    <div class="col-th col-md-6"><em>{{$lang_arr.back}}</em></div>
                                    <div class="col-th col-md-2">{{$lang_arr.odds}}</div>
                                    <div class="col-th col-md-2">{{$lang_arr.stake}}</div>
                                    <div class="col-th col-md-2 profit">{{$lang_arr.unmatched}}</div>
                                </div>
                            </div>
                            <div class="odds_holder">
                            </div>
                        </div>


                        <div class="betslip_lay">
                            <div class="container-fluid">
                                <div class="row no-padding" id="lay_title">
                                    <div class="col-th col-md-6"><em>{{$lang_arr.lay}}</em></div>
                                    <div class="col-th col-md-2">{{$lang_arr.odds}}</div>
                                    <div class="col-th col-md-2">{{$lang_arr.stake}}</div>
                                    <div class="col-th col-md-2 profit">{{$lang_arr.unmatched}}</div>
                                </div>
                            </div>

                            <div class="odds_holder">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="betslip-3">
                    <div class="panel-body">

                        <div class="empty-placeholder" style="display: none;">
                            <span class="" style="padding:10px;">{{$lang_arr.no_received_bets}}</span>
                        </div>

                        <div class="betslip_back">
                            <div class="container-fluid">
                                <div class="row no-padding" id="back_title">
                                    <div class="col-th col-md-6"><em>{{$lang_arr.back}}</em></div>
                                    <div class="col-th col-md-2">{{$lang_arr.odds}}</div>
                                    <div class="col-th col-md-2">{{$lang_arr.stake}}</div>
                                    <div class="col-th col-md-2 profit">{{$lang_arr.unmatched}}</div>
                                </div>
                            </div>
                            <div class="odds_holder">
                            </div>
                        </div>


                        <div class="betslip_lay">
                            <div class="container-fluid">
                                <div class="row no-padding" id="lay_title">
                                    <div class="col-th col-md-6"><em>{{$lang_arr.lay}}</em></div>
                                    <div class="col-th col-md-2">{{$lang_arr.odds}}</div>
                                    <div class="col-th col-md-2">{{$lang_arr.stake}}</div>
                                    <div class="col-th col-md-2 profit">{{$lang_arr.unmatched}}</div>
                                </div>
                            </div>

                            <div class="odds_holder">
                            </div>
                        </div>

                    </div>
                </div>


            </div>

            <!--<a href="#" onclick="Games.openKeno();">
                <img src="/_media/images/keno.jpg?1431481784" id="OpenKeno"  class="hidden"  style="margin-top:20px">
            </a>-->
        </div>

    </div>


    <!--<img src="https://www.matchbook.com/contentAsset/raw-data/1690024c-e1b3-4059-ac9e-d6262ac31c54/mediumBg?byInode=true" class="img-responsive"/>

-->
</div>

