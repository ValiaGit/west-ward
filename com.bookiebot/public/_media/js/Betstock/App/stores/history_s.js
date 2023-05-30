/**
 * History store
 */
HistoryStore = {

    model: 'history',

    proxy: {
        cancel: {
            service: 'betting.betting',
            method: 'cancelUnmatchedBet',
            root: 'data'
        },
        history: {
            service: 'betting.history',
            method: 'getHistoryList',
            root: 'data'
        }
    },

    store: {},

    listeners: {
        afterdataload: 'history.afterDataLoad'
    },

    /**
     * Cancel bet by bet id
     * If callback not available, reset history data.
     * @param id
     * @param callback
     */
    cancelBet: function(id,callback){
        var me = this;

        var user_id = Util.Cookie.get('user_id');

        if(!callback){
            callback = function(response){
                me.requestData({proxy: 'history'});
            }
        }
        me.requestData({proxy: 'cancel', params: {bet_id: id,user_id:Util.Cookie.get("user_id")}},callback);
    },
    /**
     * Initialize Categories store
     */
    init: function(){

        var me = this;
        me.store = {},
            me.topbets = {};

        var me = this,
            user_id = Util.Cookie.get('user_id');

        var from = moment().subtract(7,"days").format('YYYY-MM-DD');
        var to = moment().add(1,"days").format('YYYY-MM-DD');

        if(user_id){
            this.proxy.history.params = {user_id:user_id, from: from,to:to};
        }

    }//end init();

};//end {}