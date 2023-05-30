/**
 * Matches controller
 * @type {{}}
 */
OddsController = {

    /**
     * Returns main odd type depends on sport id
     * @param id
     * @returns {*}
     */
    getMainOddTypeBySportId: function(id){

        //localize data
        var me = this,
            conf = App.getStore('config'), //config store
            type_id = conf.getMainOddTypeIDBySportId(id);//TODO this must be got from a config data



        return conf.getTypeById(type_id);

    },//end getMainOddTypesBySportId();

    /**
     * Returns highest backBid for odd
     * Must be called like .apply(odd) or .call(odd)
     * @returns {*}
     */
    getHighestBackBid: function(){

        var data = this.back;

        if(data && data.highest){
            return data.highest;
        }//end if

        return false;
    },//end getHighestBackBid();

    /**
     * Returns highest backBid for odd
     * Must be called like .apply(odd) or .call(odd)
     * @returns {*}
     */
    getHighestLayBid: function(){

        var data = this.lay;

        if(data && data.highest){
            return data.highest;
        }//end if

    }//end getHighestBackBid();

};//end {}