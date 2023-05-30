App.model('balances', {

    fields: {

        core_daily_balance_snapshots__core_users_id: {type: 'number', filter: {placeholder: 'Numeric only'}, column: {width: 100}},
        balance: {
            convert: function (val) {
                if(val<=0) {
                    return 0;
                }
                return (val / 100).toFixed(2);
            },
            filter: {type: 'range'},
            column: true
        },

        balance_date: {type: 'string', filter: false, column: true},
        core_daily_balance_snapshots__datestring: {type: 'string', filter: true, column: true}
    }//end fields

});//end {}