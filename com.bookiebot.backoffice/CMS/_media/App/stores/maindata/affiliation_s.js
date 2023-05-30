App.store('affiliation',{

    model: 'affiliation',

    proxy: {
        service: 'financial.affiliatetransactions',
        method: 'getTransactionsList',
        root: 'data'
    },

    store: [],

    listeners: {
        afterdataload: 'affiliation.afterDataLoad'
    },


    /**
     * Initialize Categories store
     */
    init: function() {

    }//end init();




});//end {}