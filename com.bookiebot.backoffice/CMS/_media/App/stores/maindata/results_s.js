App.store('results',{

    model: 'results',

    proxy: {
        service: 'results.prematch',
        method: 'getResultsList',
        root: 'data'
    },

    store: [],

    listeners: {
        afterdataload: 'results.afterDataLoad'
    },

    /**
     * Initialize Categories store
     */
    init: function(){
        console.log(this.proxy)
    }//end init();



});//end {}