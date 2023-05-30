App.store('transactions',{

    model: 'transactions',

    proxy: {
        service: 'financial.transactions',
        method: 'getTransactionsList',
        root: 'data'
    },

    store: [],

    listeners: {
        afterdataload: 'transactions.afterDataLoad'
    },


    /**
     * Initialize Categories store
     */
    init: function() {

    }//end init();



});//end {}