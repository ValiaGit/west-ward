var Cards = {


    openAddPopup: function (provider_id) {
        if(provider_id ==1) {
            this.openAddCard();
        } else {
            this.openAddBank();
        }
    },

    /**
     *
     */
    openAddCard:function() {

        var YearOptions = [];
        var Year = new Date().getFullYear();
        for (y = Year; y < Year+40; y++) {
            YearOptions.push({
                option_name:y,
                option_value:y
            });
        }

        var MonthOptions = [];
        for(var m = 1;m<13;m++){
            var val = m;
            if(m<10) {
                val = "0"+m;
            }
            MonthOptions.push({
                option_name:val,
                option_value:val
            });
        }



        Util.Popup.openForm({
            title: "Add Card",
            fields: [
                {
                    name: "provider_id",
                    type: "hidden",
                    value: 1

                },
                {
                    name: "card_type",
                    type: "select",
                    label: "Card Type",
                    validation: {
                        required: true
                    },
                    options: [
                        {
                            option_name: "Visa",
                            option_value: "VISA"
                        },
                        {
                            option_name: "Mastercard",
                            option_value: "MASTERCARD"
                        },
                        {
                            option_name: "Amex",
                            option_value: "AMEX"
                        }
                    ]
                },
                // {
                //     name: "card_owner_name",
                //     type: "text",
                //     label: "Card Owner Name",
                //     validation: {
                //         required: true
                //     }
                // },
                {
                    name: "card_number",
                    type: "text",
                    label: "Card Number",
                    validation: {
                        required: true
                    }
                },
                {
                    name: "expiry_month",
                    type: "select",
                    label: "Exp. Month",
                    options:MonthOptions,
                    validation: {
                        required: true
                    }
                },
                {
                    name: "expiry_year",
                    type: "select",
                    options:YearOptions,
                    label: "Exp. Year",
                    validation: {
                        required: true
                    }
                }
            ],
            onSubmit: "Cards.addCard"
        });
    },


    /**
     *
     */
    openAddBank:function() {
        Util.Popup.openForm({
            title: "Add Bank Account for Wire Transfers",
            fields: [
                {
                    name: "provider_id",
                    type: "hidden",
                    value: 2

                },
                {
                    label: lang_arr['choose_country'],
                    name: "country_id",
                    type: "select",
                    ajax: {
                        service_name: "common.countries",
                        method_name: "getList",
                        parameters: {},
                        mapping: {
                            "option_name": "short_name",
                            "option_value": "iso3"
                        }
                    },
                    validation: {
                        required: true
                    }

                },
                {
                    name: "bank_name",
                    type: "text",
                    label: "Bank Name",
                    validation: {
                        required: true
                    }
                },
                {
                    name: "bank_account",
                    type: "text",
                    label: "Account Number",
                    validation: {
                        required: true
                    }
                },
                {
                    name: "bank_code",
                    type: "text",
                    label: "Bank Code",
                    validation: {
                        required: true
                    }
                },
                {
                    name: "payee",
                    type: "text",
                    label: "Payee",
                    validation: {
                        required: true
                    }
                },
                {
                    name: "swift_code",
                    type: "text",
                    label: "SWIFT",
                    validation: {
                        required: true
                    }
                }
            ],
            onSubmit: "Cards.addBankAccount"
        });
    },

    /**
     *
     * @param form
     */
    addCard: function (form) {
        var self = this;
        var data = Util.Form.serialize($(form));

        Util.Popup.openLoader();
        API.call("cashier.cards", "addCard", data, function (addResponse) {
            console.log(addResponse);
            Util.Popup.closeLoader();
            if (addResponse.code == 10) {
                self.getCardAccounts();
                Util.Popup.open({
                    content: "Card was added successfully!"
                });
            } else {
                Util.Popup.openWarn(addResponse.msg);
            }
        });

    },


    /**
     *
     * @param form
     */
    addBankAccount:function(form) {
        var self = this;
        var data = Util.Form.serialize($(form));

        Util.Popup.openLoader();
        API.call("cashier.bankaccounts", "addBankAccount", data, function (addResponse) {
            console.log(addResponse);
            Util.Popup.closeLoader();
            if (addResponse.code == 10) {
                self.getCardAccounts();
                Util.Popup.open({
                    content: "Bank account was added successfully!"
                });
            } else {
                Util.Popup.openWarn(addResponse.msg);
            }
        });
    },

    /**
     *
     */
    listtbody: $('table#cards_list'),


    /**
     *
     */
    getCardAccounts: function () {
        var self = this;
        API.call("cashier.cards", "getMyCardAccounts", {all:true}, function (response) {

            if (response.code == 10) {
                var Cards = response.data;
                var CardsHTML = "";
                for (var index in Cards) {

                    var curCard = Cards[index];
                    var active_amount = 0;
                    if(curCard.active_amount) {
                        active_amount = curCard.active_amount/100;
                    }

                    var Pan = curCard.Pan;
                    var money_providers_id = curCard.money_providers_id;

                    var ConfirmationStatus = curCard.ConfirmationStatus;
                    switch(ConfirmationStatus){
                        case 1:
                        case "1":
                            ConfirmationStatus = "<strong style='color:green'>CONFIRMED</strong>";
                            break;
                        case 0:
                        case "0":
                            ConfirmationStatus = "<strong>NOT CONFIRMED</strong>";
                            break;
                    }

                    var AddDate = curCard.AddDate;
                    AddDate = moment(AddDate).format("D-MM-YYYY HH:mm");


                    if(curCard['account_type'] == 1 || !curCard['account_type']) {
                        var Image = "<img src='"+base_href + '/_media/images/cards/1.png?id='+new Date().getTime()+"' />";
                        if (curCard.Type == "AMEX") {
                            Image = "<img src='"+base_href + '/_media/images/cards/2.png?id='+new Date().getTime()+"' />";
                        }
                    } else if(curCard['account_type'] == 2) {
                        Image = "<img src='"+base_href + '/_media/images/cards/5.png?id='+new Date().getTime()+"' />";

                        Pan = "<strong>Bank</strong>: "+curCard['BankName']+", <strong>BankCode</strong>:"+curCard['BankName']+"<br/>" +
                            "<strong>BankAccount</strong>: "+curCard['BankAccount']+"" +
                            "<br/>" +
                            "<strong>Payee</strong>:"+curCard['Payee']+", <strong>SWIFT</strong>: "+curCard['SwiftCode'];
                    }

                    if(money_providers_id == 16) {
                        Image = "<img src='https://betplanet.win/_media/images/money_providers/12.png' />";
                    }




                    CardsHTML += '<tr id="card-' + curCard.account_id + '">' +
                        '<td class="col-md-2">' + Image + '</td>' +
                        '<td class="pan-number text-center">' + Pan + '</td>' +
                        '<td class="col-md-2 text-center">' + AddDate + '</td>' +
                        '<td class="col-md-2 text-center">' + ConfirmationStatus + '</td>' +
                        '<td>'+active_amount.toFixed(2)+'</td>' +
                        '<td class="col-md-1 text-center"><span class="btn btn-danger btn-xs pull-right" onclick="Cards.deleteCard(' + curCard.account_id + ')">DELETE</span></td>' +
                        '</tr>';
                }
                self.listtbody.find("tbody").html(CardsHTML);
                $('.hist_tooltip').tooltip();

            } else {
                self.listtbody.find("tbody").html("<p class='no-data'>You don't have cards!</p>");
            }
        });
    },

    /**
     *
     * @param card_id
     * @returns {boolean}
     */
    deleteCard: function (card_id) {

        var confAnswer = confirm("Do you really want to delete card?");
        if(!confAnswer) {
            return false;
        }


        API.call("cashier.cards", "deleteCard", {account_id: card_id}, function (response) {
            console.log(response);
            if (response.code == 10) {
                $('#card-' + card_id).fadeOut();

            }
        });
    }

};




