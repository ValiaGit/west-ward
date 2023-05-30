/**
 * Matches controller
 * @type {{}}
 */
MatchesController = {

    /**
     * Initialize matches contoller
     */
    init: function(){

        var me = this;

        Router.guess();

    },

    /**
     * Request topbets data by tournament_id
     */
    initTopBets: function(ignoreState){
        var me = this;

        me.myStore().getTopBetsData();

        if(!ignoreState)
        Router.set({type: 'topbets'});

    },//end initTopBets();

    /**
     * Request match data by match_id
     * @param match_id
     */
    initMatchById: function(match_id, ignoreState){
        var me = this;

        me.myStore().getMatchData(match_id);

        if(!ignoreState)
        Router.set({type: 'match', id: match_id});

    },//end initMatchById();

    /**
     * Prepare data and run renderer from view
     * @param storeData
     * @param options
     */
    afterDataLoad: function(storeData, options){

        //Localize
        var me = App.getController('matches');

        switch(options.type){

            case 'tournament':

                //Take tournament id from request
                var tournament_id = options.params.tournament_id,

                //get matches from tournament object
                matches = App.getStore('categories').getTournamentById(tournament_id).matches;

                this.myView().renderTournamentContent(matches, tournament_id);

                break;

            case 'match':

                var match = storeData[options.params.match_id];

                this.myView().renderMatchContent(match);

                break;

            case 'outright':

                var tournament_id = options.params.outright_id,

                odds = App.getStore('categories').getTournamentById(tournament_id).odds;
                this.myView().renderOutrightContent(odds,tournament_id);

                break;

            case 'topbets':

                var data = me.myStore().getTopBets();

                this.myView().renderTopBetsContent(data);

                break;

        }//


    },//end afterStoreLoad();

    /**
     * Handle type update
     */
    typeUpdated: function(info){

        var me = this;
            me.myView().reRenderType(info);

    }//end typeUpdated();

};//end {}