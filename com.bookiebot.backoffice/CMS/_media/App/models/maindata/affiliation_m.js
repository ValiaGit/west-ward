App.model('affiliation', {

    fields: {

        "transactions__id": {
            mapping: 'transactions__id',
            type: 'number', column: {width: 100},
            filter: true
        },
        "transaction_amount": {
            mapping: 'transaction_amount',
            type: 'number', column: {width: 100},
            template:function(val) {
                return val['transaction_amount'] / 100;
            },
            filter: true
        },
        "users__id": {
            mapping: 'users__id',
            type: 'number',
            column:true,
            filter: true
        },
        "username": {
            mapping: 'username',
            type: 'string',
            column:true,
            filter: false
        }



    },//end fields



    commands:[
        {
            command: [
                // {
                //     text: "Details",
                //     click: function(e) {
                //         e.preventDefault();
                //         var dataItem = this.dataItem($(e.currentTarget).closest("tr"));
                //         GameTransactionsClass.viewDetails(dataItem);
                //     }
                // }
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