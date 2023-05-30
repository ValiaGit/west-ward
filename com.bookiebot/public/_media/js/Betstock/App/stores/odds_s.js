/**
 * Config store
 */
OddsStore = {

    model: 'odds',

    dataType: 'multi',

    proxy: {
        outrights: {
            service: 'betting.outright',
            method: 'getOutrightTournament',
            root: 'data'
        },
        oddtype: {
            service: 'betting.odds',
            method: 'getOddsByTypeAndMatchID',
            root: 'odds',
            afterparse: function(data,options,scope){

                var me = scope,
                    type_id = options.params.odd_type_id,
                    match_id = options.params.match_id,
                    type = App.getStore('matches').getTypeByMatchAndTypeId(match_id,type_id);

                    //Update matched amount and status to type reference
                    type.matched = (data.matched/100).toFixed(2);
                    type.status = data.status;

                me.trigger('typeupdate',[{match_id: match_id, type_id: type_id}]);

            }
        }

    },

    store: {},

    listeners:{
        afterdataload: 'matches.afterDataLoad',
        typeupdate: 'matches.typeUpdated'
    },

    /**
     * Get type data from server
     * by type_id and match_id
     *
     * @param info
     */
    updateType: function(info){

        var me = this;

        me.requestData({proxy: 'oddtype',   params: {match_id: info.match_id, odd_type_id: info.type_id}, type:'oddtype'});


    },//end updateType();

    /**
     * Gets data by tournament id
     * @param tournament_id
     */
    getOutrightOdds: function(tournament_id){
        var me = this;
        Util.addLoader('#MiddleContainer');
        App.getStore('categories').getTournamentById(tournament_id).odds = [];
        me.requestData({proxy: 'outrights', params: {outright_id:tournament_id}, type: 'outright'});

    },//end getOutrightOdds();

    newItem: function(item,options){

        var me = this;

        switch(options.type){
            case 'outright':

                var tournament = App.getStore('categories').getTournamentById(options.params.outright_id);

                //Save odd reference into tournament
                tournament.odds.push(item.id);

                me.store[item.id] = item;

                break;
            case 'oddtype':

                item = $.extend(true, me.store[item.id],item);

                App.getStore('matches').getTypeByMatchAndTypeId(item.match_id, item.type_id);
                break;
        }

        me.store[item.id] = item;

    }//end newItem();

};//end {}