var Deposit = {

    /**
     *
     * @param form
     */
    initTransaction: function (form) {
        var data = Util.Form.serialize($(form));

        data.amount = data.amount * 100;
        console.log(data['commission']);

        var width = 1;
        var height = 1;

        var winObject = window.open('', "DepositWindow", 'height=' + height + ',width=' + width);




        try {
            var timer = setInterval(checkChild, 500);
            function checkChild() {
                if (winObject.closed) {
                    Session.init();
                    clearInterval(timer);
                }
            }
        }catch(e) {
            // alert(e);
        }

        Util.Popup.openLoader();
        API.call("cashier.deposit", "initializeTransaction", data, function (response) {
            console.log(response);
            Util.Popup.closeLoader();

            if(response.code == -1008) {
                if(typeof winObject != "undefined") {
                    winObject.close();
                }

                //Util.Popup.close();

                Util.Popup.open({
                    content: "<h2>You have activated deposit limit protection!</h2>" +
                    "<br/> Activation date: "+response['protection']['create_time']+" " +
                    "<br/> Limit Reset Date: date "+response['protection']['expire_date']+" " +
                    "<br/> Available Amount To Deposit: € "+(response['protection']['available_amount_to_deposit']/100).toFixed(2)+""
                });
                return false;
            }

            if (response.code != 10) {
                if(typeof winObject != "undefined") {
                    winObject.close();
                }

                Util.Popup.open({
                    content: response.msg
                });
                return false;
            }


            //If Payment Has Data Fields We Open Outside Popup
            if(response.hasOwnProperty("data")) {
                winObject.resizeTo(1024, 768);

                var fields = response.data;
                var f = document.createElement("form");

                $(document.body).append(f);

                f.setAttribute('method', "post");
                f.setAttribute('action', fields.action);
                f.setAttribute('target', "DepositWindow");

                for (index in fields) {
                    var current = fields[index];

                    var input = document.createElement("input"); //input element, text
                    input.setAttribute('type', "hidden");
                    input.setAttribute('name', index);
                    input.setAttribute('value', current);
                    f.appendChild(input);
                }

                f.submit();
                try {
                    var timer = setInterval(checkChild, 500);

                    function checkChild() {
                        if (winObject.closed) {
                            Session.init();
                            clearInterval(timer);
                        }
                    }
                }catch(e) {
                    console.log(e);
                }

            }

            //If Payment Is Processed Inside Our System
            else {
                if(typeof winObject != undefined && winObject) {
                    //Close Popup Widow
                    winObject.close();
                }


                //Check Response Code And Show Message
                if(response.code == 10) {
                    Session.init();
                    Util.Popup.open({
                        content:lang_arr['success']
                    });
                }


            }





            $('.input-deposit').val("");
            return false;
        });
    },

    /**
     *
     * @param form
     */
    initTransactionWithAccounts: function (form) {
        var data = Util.Form.serialize($(form));
        console.log(data);
        Util.Popup.openForm({
            title: "Deposit Money",
            description: "If you don't have registered cards <a href='#' onclick='Cards.openAddPopup(1);'>click here</a>!",
            fields: [
                {
                    name: "provider_id",
                    type: "hidden",
                    value: data.provider_id,
                    validation: {
                        required: true
                    }
                },
                {
                    name: "provider_name",
                    type: "hidden",
                    value: data.provider_name,
                    validation: {
                        required: true
                    }
                },
                {
                    label: lang_arr['amount']+" (&#8364;)",
                    name: "amount",
                    type: "text",
                    value: parseFloat(data.amount).toFixed(2),
                    validation: {
                        required: true
                    },
                    onchange:function(input) {
                        var amount = $(input).val();
                        var commission = $('input[name=commission').val();

                        var comPercent = commission/amount*100;


                        var net_amount = amount * ((100-commission)/100);
                        var commision_cut = amount - net_amount;

                        $('input[name=commission_amount').val(commision_cut.toFixed(2));
                    }
                },
                {
                    label: lang_arr['commission']+"&#8364;",
                    name: "commission",
                    type: "text",
                    value: data.commission,
                    disabled:true,
                    type:"hidden"
                },
                {
                    label: lang_arr['commission']+" (&#8364;)",
                    name: "commission_amount",
                    type: "text",
                    value: (data.amount * data.commission/100).toFixed(2),
                    disabled:true

                },
                {
                    label: lang_arr['choose_card'],
                    name: "account_id",
                    type: "select",
                    ajax: {
                        service_name: "cashier.cards",
                        method_name: "getMyCardAccounts",
                        parameters: {},
                        mapping: {
                            "option_name": "Pan",
                            "option_value": "account_id"
                        }
                    },
                    validation: {
                        required: true
                    }

                },
                {
                    label: lang_arr['enter_cvc'],
                    name: "security_code",
                    type: "text",
                    validation: {
                        required: true
                    }
                },
            ],
            onSubmit:"Deposit.initTransaction"
        });
    }


};
