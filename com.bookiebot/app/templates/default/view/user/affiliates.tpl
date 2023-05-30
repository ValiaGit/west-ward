{{$Data.modules.header}}
<body class="page-static">

<div class="wrapper">

    {{$Data.modules.topmenu}}


    {{$Data.modules.bettingmenu}}


    <div class="container">

        <div id="purchase_area_1000_gp" style="display: none;">
            <h1 style="font-size: 24px; text-align: center; margin-top: 50px; margin-bottom: 50px;">{{$lang_arr.to_get_affiliate_id_purchase}}</h1>
            <center>
                <button class="btn btn-blue-shadow" onclick="purchase(1);return false;">{{$lang_arr.purchase}}1.000€
                </button>
            </center>
        </div>


        <div id="purchase_area_500" style="display: none;">
            <h1 style="font-size: 24px; text-align: center; margin-top: 50px; margin-bottom: 50px;">{{$lang_arr.to_get_affiliate_id_purchase_500}}</h1>
            <center>
                <button class="btn btn-blue-shadow" onclick="purchase(2);return false;">{{$lang_arr.purchase}}500€
                </button>
            </center>
        </div>

        <div id="purchase_area_40" style="display: none;">
            <h1 style="    font-size: 24px; text-align: center; margin-top: 50px; margin-bottom: 50px;">{{$lang_arr.to_get_affiliate_id_purchase_40}}</h1>
            <center>
                <button class="btn btn-blue-shadow" onclick="purchase(3);return false;">{{$lang_arr.purchase}}40€
                </button>
            </center>
        </div>


        <iframe
                style="width: 100%;height: 1150px;background-color: transparent;border: 0 none;"
                scrolling="no"
                id="affiliate_iframe"
        ></iframe>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function (event) {

            if ($.cookie("user_id")) {

                //This Service Will Check if Agrred Flag Is Yes or No
                API.call('cashier.affiliate', 'terms', {}, function (termsResp) {

                    //Has Not Agreed Yet Then Show Popup
                    if (!termsResp.type) {


                        var buttons = [
                            {
                                "text": lang_arr['register_as_instructor'] + " ",
                                "click": "confrmAndSucceed(2);"
                            },
                            {
                                "text": lang_arr['register_as_affiliate'] + " ",
                                "click": "confrmAndSucceed(3);"
                            }
                        ];


                        //If User Is Child of Kyoh Ask for becoming governing partner
                        if ($.cookie('parent_affiliate_id') == 38) {
                            buttons = [
                                {
                                    "text": lang_arr['register_as_governing_partner'],
                                    "click": "confrmAndSucceed(1);"
                                },
                                {
                                    "text": lang_arr['register_as_instructor'] + " ",
                                    "click": "confrmAndSucceed(2);"
                                }
                            ];
                        }


                        /**
                         type = ('GPartner','Instructor','Free')
                         **/


                        Util.Popup.open({
                            "title": lang_arr['to_become_affiliate_terms_and_conds'],
                            "content": ` {{$Data.terms}} `,
                            "onChangeEvents": {
                                "close": ''
                            },
                            'width': '90%',
                            "buttons": buttons,
                            "onCloseAction": "window.location.href = '" + base_href + "/" + cur_lang + "'"
                        });

                    }

                    else {

                        //If during has Agreed Terms Check We got response That User Already Agreed
                        //Then WE Also know with what type user agreed on our Terms
                        //If user is either Partner or Instructor We go and check if has payed
                        if (termsResp.type == 1 || termsResp.type == 2) {

                            //Check If Payed Money
                            API.call("cashier.affiliate", "check", {type: termsResp.type}, function (response) {

                                if (response.purchased == 1) {


                                    //TODO Here We Should check if user has payed subscription fee 40 Euros


                                    var token = Session.generateProviderToken("9ecaa978-26fb-45e0-9e37-4f4c975332ee", function (err, token) {
                                        $('#affiliate_iframe').attr('src', 'https://affiliates.betplanet.win/?token=' + token + "&lang=" + cur_lang);
                                    });
                                }

                                else if (response.purchased == -1) {
                                    $('#purchase_area_40').show();
                                    $('#affiliate_iframe').hide();
                                }

                                else {
                                    if (termsResp.type == 1) {
                                        $('#purchase_area_1000').show();
                                    }
                                    else if (termsResp.type == 2) {
                                        $('#purchase_area_500').show();
                                    }

                                    $('#affiliate_iframe').hide();
                                }


                            });
                        }
                        else {

                            //TODO Here We Should Check If User Has Payed Subscription Fee 40 Euros

                            if($.cookie('user_id') == "38") {
                                var token = Session.generateProviderToken("9ecaa978-26fb-45e0-9e37-4f4c975332ee", function (err, token) {
                                    $('#affiliate_iframe').attr('src', 'https://affiliates.betplanet.win/?token=' + token + "&lang=" + cur_lang);
                                });
                                return;
                            }
                            //Check If Payed Money
                            API.call("cashier.affiliate", "check", {type: termsResp.type}, function (response) {
                                console.log(response);
                                if (response.purchased == 1) {
                                    var token = Session.generateProviderToken("9ecaa978-26fb-45e0-9e37-4f4c975332ee", function (err, token) {
                                        $('#affiliate_iframe').attr('src', 'https://affiliates.betplanet.win/?token=' + token + "&lang=" + cur_lang);
                                    });
                                }
                                else if (response.purchased == 0) {
                                    $('#purchase_area_40').show();
                                    $('#affiliate_iframe').hide();
                                }
                            });


                        }


                    }


                });

            } else {
                $('#affiliate_iframe').attr('src', 'https://affiliates.betplanet.win/' + "?lang=" + cur_lang);
            }


        });

        /**
         * type 1=GP OneTime;2=Instructor OneTime;3=Subscription Fee
         * @param type
         */
        function purchase(type) {
            API.call("cashier.affiliate", "transaction", {type: type}, function (response) {
                if (response.code == -1) {
                    // fulebi arari
                    window.location.href = base_href + "/" + cur_lang + '/user/balance_management'
                }


                else if (response.code == -2) {
                    // transaction fail
                    $('#purchase_area').show();
                    $('#affiliate_iframe').hide();
                }


                else if (response.code == 10) {
                    // success
                    window.location.href = base_href + "/" + cur_lang + '/affiliates'
                }
            });
        }


        function confrmAndSucceed(type) {
            //Users Can clik on Agree via tree options
            //Agree as Instructor Agree As Free Affiliate
            API.call('cashier.affiliate', 'terms',{type:type}, function () {
                window.location.href = base_href + "/" + cur_lang + "/affiliates";
            });
        }

    </script>

    {{$Data.modules.footer}}
