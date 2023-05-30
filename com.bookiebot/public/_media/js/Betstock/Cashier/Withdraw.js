var Withdraw = {

    initTransaction: function (form) {
        var data = Util.Form.serialize($(form));

        data.amount = data.amount * 100;
        var width = 1;
        var height = 1;

        if ( data.provider_interface == 1 ) {
            var winObject = window.open('', "WithdrawWindow", 'height=' + height + ',width=' + width);
        }

        try {
            var timer = setInterval(checkChild, 500);
            function checkChild() {
                if (typeof winObject !== 'undefined' && winObject.closed) {
                    Session.init();
                    clearInterval(timer);
                }
            }
        }catch(e) {
            // alert(e);
        }


        Util.Popup.openLoader();
        API.call("cashier.withdraw", "initializeTransaction", data, function (response) {

            Util.Popup.closeLoader();

            console.log(response);

            //Check Response Code And Show Message
            if (response.code != 10) {
                winObject.close();
                clearTimeout(Util.Popup.wartTimeOut);
                Util.Popup.open({title:"message",content:response.msg});

                $('input[name=amount]').val("");
                return false;

            }


            if( typeof winObject !== 'undefined' &&  response.hasOwnProperty("data")) {


                winObject.resizeTo(1024, 768);

                var fields = response.data;
                var f = document.createElement("form");
                f.setAttribute('method', "post");
                f.setAttribute('action', fields.action);
                f.setAttribute('target', "WithdrawWindow");

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

            else {
                if (response.hasOwnProperty('is_split')) {
                    if (response['is_split']) {
                        Session.init();
                        Util.Popup.open({
                            content: response['msg']
                        });
                        return false;
                    }
                }


                Session.init();
                Util.Popup.open({
                    content: lang_arr['success']
                });
            }

            $('.input-deposit').val("");
            return false;
        });

    },

    initTransactionWithAccounts: function (form) {
        var data = Util.Form.serialize($(form));

        var descText = "";

        //If Not Wire Transfer
        if (data.provider_id != 2) {
            var accounts_ajax = {
                service_name: "cashier.cards",
                method_name: "getMyCardAccounts",
                parameters: {
                    provider_id:data.provider_id
                },
                mapping: {
                    "option_name": "Pan",
                    "option_value": "account_id"
                }
            };
            descText = "If the method you used to make your deposit accepts the credit of funds, then withdrawals must first be processed back to this method (this is a legal requirement based on anti-money laundering regulations and for the security of your funds)." +
                "<br/>If you don't have registered cards <a href='#' onclick='Cards.openAddPopup(1);'>click here</a>!";

        }

        //If Wire Transfer
        else {
            var accounts_ajax = {
                service_name: "cashier.bankaccounts",
                method_name: "getMyBankAccounts",
                parameters: {
                    provider_id:data.provider_id
                },
                mapping: {
                    "option_name": "BankAccount",
                    "option_value": "account_id"
                }
            };


            descText = "Wire transfer to your bank account may take 4-7 Business days.<br>" +
                "If you don't have 'Payment Accounts' please <a href='#' onclick='Cards.openAddPopup(2);'>click here</a> to add one!";
        }

        // var CurrencyIcon = Currencies.list[sessionData.user.core_currencies_id].icon;

        var CurrencyIcon = "";
        Util.Popup.openForm({
            title: "Withdraw Money",
            description: descText,
            fields: [
                {
                    name: "provider_id",
                    type: "hidden",
                    value: data.provider_id
                },
                {
                    name: "provider_name",
                    type: "hidden",
                    value: data['provider_name']
                },
                {
                    label: lang_arr['amount'] + " ("+CurrencyIcon+")",
                    name: "amount",
                    type: "text",
                    value: parseFloat(data.amount).toFixed(2),
                    validation: {
                        required: true
                    }
                },
                {
                    label: lang_arr['choose_payment_account'],
                    name: "account_id",
                    type: "select",
                    ajax: accounts_ajax,
                    validation: {
                        required: true
                    }
                },
                {
                    label: lang_arr['account_password'],
                    name: "account_password",
                    type: "password",
                    validation: {
                        required: true
                    }
                }
            ],
            submitText: "Withdraw",
            onSubmit: "Withdraw.initTransaction"
        });
    }

};
