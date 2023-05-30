App.store('gametrans',{

    model: 'gametrans',

    proxy: {
        service: 'financial.gametransactions',
        method: 'getTransactionsList',
        root: 'data'
    },

    store: [],

    listeners: {
        afterdataload: 'gametrans.afterDataLoad'
    },


    /**
     * Initialize Categories store
     */
    init: function() {

    }//end init();




});//end {}