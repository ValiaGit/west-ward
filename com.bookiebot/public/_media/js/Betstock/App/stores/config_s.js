/**
 * Config store
 */
ConfigStore = {

    model: 'config',

    proxy: {
        service: 'betting.odds',
        method: 'getConfiguration'
    },

    dataType: 'single', //It means that json data retrieved from the server
                        //isn't an array of items. It contains one and only root object.

    store: {},

    /**
     * Initialize Categories store
     */
    init: function() {

        var me = this;
        me.requestData();

    },//end init();

    /**
     * Returns type data by type_id
     * @param id
     * @return {*}
     */
    getTypeById: function(id){

        //localize
        var me = this;
        if(me.store.typeinfo && me.store.typeinfo[id]){
            return me.store.typeinfo[id];
        }else{
            return false; //TODO Check if i need empty object even if it doesn't exists either null or false
        }

    },//end getTypeById()



    getMainOddTypeIDBySportId: function(sport_id) {
        var me  = this;
        return me.getData().sports[sport_id]
    }


};//end {}