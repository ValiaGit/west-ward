App.store('matches',{

    model: 'matches',

    proxy: {
        service: 'prematch.match',
        method: 'getMatchesList',
        root: 'data'
    },

    store: [],

    listeners: {
        afterdataload: 'matches.afterDataLoad'
    },


    /**
     * Initialize Categories store
     */
    init: function() {

    }//end init();



});//end {}