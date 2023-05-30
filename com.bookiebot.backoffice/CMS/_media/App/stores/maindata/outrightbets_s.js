App.store('outrightbets',{

    model: 'bets',

    proxy: {
        service: 'betting.outrightbets',
        method: 'getBetList',
        root: 'data'
    },

    store: [],

    listeners: {
        afterdataload: 'outrightbets.afterDataLoad'
    },


    /**
     * Initialize Categories store
     */
    init: function() {

    }//end init();



});//end {}