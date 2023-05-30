App.model('transactions', {

    fields: {

        "transactions__id": {
            mapping: 'transactions__id',
            type: 'number', column: {width: 100},
            filter: true
        },
        "users_id": {
            mapping: 'users_id',
            type: 'number',
            filter: true
        },
        "transactions__type": {
            mapping: 'transactions__type',
            type: 'number',
            filter: true,
            column: true,
            template:function(val) {
                switch(val['transactions__type']) {
                    case 1:
                    case "1":
                        return "Deposit (1)";
                        break;
                    case 2:
                    case "2":
                        return "Withdraw (2)";
                        break;
                }
            }
        },
        "users__id": {
            mapping: 'users__id',
            type: 'number',
            column: true,
            filter:true
        },
        "users_fullname": {
            mapping: 'users_fullname',
            type: 'string',
            column: true
        },
        "transactions_transaction_unique_id": {
            mapping: 'transactions_transaction_unique_id',
            column: false, filter: false
        },
        "transactions_bank_transaction_id": {
            mapping: 'transactions_bank_transaction_id',
            column: true, filter: false
        },
        "account_pan": {
            mapping: 'account_pan',
            column: true, filter: false
        },
        "transactions_amount": {
            mapping: 'transactions_amount',
            column: true,
            template: function (v) {
                return (v['transactions_amount'] / 100).toFixed(2)+" €";
            }
        },
        "transactions_net_amount": {
            mapping: 'transactions_net_amount',
            column: true,
            template: function (v) {
                return (v['transactions_net_amount'] / 100).toFixed(2)+" €";
            }
        },
        "transactions__status": {
            mapping: 'transactions__status',
            type: 'string',
            template:function(val) {

                switch(val['transactions__status']) {
                    case 0:
                    case "0":
                        return "Initialised (0)";
                        break;
                    case 1:
                    case "1":
                        return "Confirmed (1)";
                        break;
                    case 2:
                    case "2":
                        return "Rejected (2)";
                        break;
                    case 3:
                    case "3":
                        return "Payment Failed (3)";
                        break;
                    case 4:
                    case "4":
                        return "Needs Revision (4)";
                        break;
                    case 5:
                    case "5":
                        return "Waiting Wire Transfer To Complete (5)";
                        break;
                }
            },
            column: true, filter: true
        },
        "transactions_commission": {
            mapping: 'transactions_commission', column: true, template: function (v) {
                if(!parseInt(v['transactions_commission']) || isNaN(parseInt(v['transactions_commission']))) return 0;
                return (parseInt(v['transactions_commission']) / 100).toFixed(2)+"€";
            }
        },
        "transactions__transaction_date": {
            mapping: 'transactions__transaction_date',
            type: 'date',
            filterable:{
                extra:true,
                operators: {
                    date: {
                        lt: "Is before",
                        gt: "Is after"
                    }
                }
            },
            column: true,
            template: "#= kendo.toString(kendo.parseDate(transactions__transaction_date, 'yyyy-MM-dd'), 'dd/MM/yyyy HH:mm:ss') #",
            //template: function(row) {
            //    return moment(row['transactions__transaction_date']).format('DD/MM/YYYY HH:mm:ss');
            //}
        },
        "transactions_bank_transaction_date": {
            mapping: 'transactions_bank_transaction_date',
            type: 'time',
            is_date_picker: true,
            column: false,
            convert: function (val) {
                if(val) {
                    if(val[val.length-1] == "Z") {
                        val = val.substring(0,val.length-1);
                    }
                    return moment(val).format("DD/MM/YYYY HH:mm:ss");
                } else {
                    return val;
                }
            }
        },
        "providers_id": {mapping: 'providers_id', type: 'number', column: false, filter: false},
        "provider_title": {mapping: 'provider_title', type: 'string', column: true, filter: false},
        "transactions__is_manual_adjustment": {
            title: "Is Manual Adjustment",
            mapping: 'transactions__is_manual_adjustment',
            type: 'number', column: true,
            filter: true
        }

    },//end fields

    commands:[
        {
            command: [
                {
                    text: "Details",
                    click: function(e) {
                        e.preventDefault();
                        var dataItem = this.dataItem($(e.currentTarget).closest("tr"));
                        TransactionsClass.viewDetails(dataItem);
                    }
                },
                {
                    text: "Complete",
                    click: function(e) {
                        e.preventDefault();
                        var dataItem = this.dataItem($(e.currentTarget).closest("tr"));
                        TransactionsClass.markAsCompleted(dataItem);
                    }
                },
                {
                    text: "Cancel",
                    click: function(e) {
                        e.preventDefault();
                        var dataItem = this.dataItem($(e.currentTarget).closest("tr"));
                        TransactionsClass.markAsCanceled(dataItem);
                    }
                }



            ],

         title: " ", width: "180px" }
    ]

});//end {}