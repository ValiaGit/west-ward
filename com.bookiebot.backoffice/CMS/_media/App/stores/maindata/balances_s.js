App.store('balances',{

    model: 'balances',

    proxy: {
        list: {
            service: 'user.user',
            method: 'getBalanceHistory',
            root: 'data'
        }

    },

    store: [],

    listeners: {
        afterdataload: 'balances.afterDataLoad'
    },

    getListData: function(){

        var me = this;

        me.requestData({proxy: 'list'});
    },

    /**
     * Initialize Categories store
     */
    init: function(){

    }//end init();

});//end {}