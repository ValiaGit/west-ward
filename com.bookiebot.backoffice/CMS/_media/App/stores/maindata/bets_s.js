App.store('bets',{

    model: 'bets',

    proxy: {
        service: 'betting.bets',
        method: 'getBetList',
        root: 'data'
    },

    store: [],

    listeners: {
        afterdataload: 'bets.afterDataLoad'
    },


    /**
     * Initialize Categories store
     */
    init: function() {

    }//end init();



});//end {}