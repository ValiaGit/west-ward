App.model('gametrans', {

    fields: {

        "transactions__id": {
            mapping: 'transactions__id',
            type: 'number', column: {width: 100},
            filter: true
        },
        "users__id": {
            mapping: 'users__id',
            type: 'number',
            column:true,
            filter: true
        },
        "transactions__type": {
            mapping: 'transactions__type',
            type: 'number',
            filter: true,
            column: true,
            template:function(val) {
                /**
                     1 - Core To Game; Game CashIn
                     2 - Game To Core; Game CashOut
                     3 - Rollback Deposit
                     4 - Rolback Withdraw
                 */

                switch(val['transactions__type']) {
                    case 1:
                    case "1":
                        return "From Main to Provider (1)";
                        break;
                    case 2:
                    case "2":
                        return "From Provider to Main (2)";
                        break;
                    case 3:
                    case "3":
                        return "Rollback From Main to Provider (3)";
                        break;
                    case 4:
                    case "4":
                        return "Rollback From Provider to Main (4)";
                        break;
                }
            }
        },
        "username": {
            mapping: 'username',
            type: 'string',
            column: true
        },
        "transactions__transaction_unique_id": {
            mapping: 'transactions__transaction_unique_id',
            column: true, filter: true
        },
        "transaction_amount": {
            mapping: 'transaction_amount',
            column: true,
            template: function (v) {
                return (v['transaction_amount'] / 100).toFixed(2)+" €";
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

        "transactions__transaction_time": {
            mapping: 'transactions__transaction_time',
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
            template: "#= kendo.toString(kendo.parseDate(transactions__transaction_time, 'yyyy-MM-dd'), 'dd/MM/yyyy HH:mm:ss') #",
            //template: function(row) {
            //    return moment(row['transactions__transaction_date']).format('DD/MM/YYYY HH:mm:ss');
            //}
        },

        "providers_id": {mapping: 'providers_id', type: 'number', column: false, filter: false},
        "providers__license_id": {
            mapping: 'providers__license_id',
            type: 'number',
            column: true,
            filter: true,
            template:function(row) {

                switch(row['providers__license_id']) {
                    case 1:
                    case "1":
                        return "MGA (1)";
                        break;
                    case 2:
                    case "2":
                        return "Curacao (2)";
                        break;
                }
            }

        },

        "provider_title": {mapping: 'provider_title', type: 'string', column: true, filter: false}


    },//end fields


    commands:[
        {
            command: [
                {
                    text: "Details",
                    click: function(e) {
                        e.preventDefault();
                        var dataItem = this.dataItem($(e.currentTarget).closest("tr"));
                        GameTransactionsClass.viewDetails(dataItem);
                    }
                }
                // {
                //     text: "Complete",
                //     click: function(e) {
                //         e.preventDefault();
                //         var dataItem = this.dataItem($(e.currentTarget).closest("tr"));
                //         TransactionsClass.markAsCompleted(dataItem);
                //     }
                // },
                // {
                //     text: "Cancel",
                //     click: function(e) {
                //         e.preventDefault();
                //         var dataItem = this.dataItem($(e.currentTarget).closest("tr"));
                //         TransactionsClass.markAsCanceled(dataItem);
                //     }
                // }



            ],

            title: " ", width: "180px" }
    ]

});//end {}