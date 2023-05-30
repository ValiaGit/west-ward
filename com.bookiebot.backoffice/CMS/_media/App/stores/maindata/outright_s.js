App.store('outright',{

    model: 'matches',

    proxy: {
        service: 'prematch.match',
        method: 'getMatchesList',
        root: 'data'
    },

    store: [],

    listeners: {
        afterdataload: 'outright.afterDataLoad'
    },


    /**
     * Initialize Categories store
     */
    init: function() {

    }//end init();



});//end {}