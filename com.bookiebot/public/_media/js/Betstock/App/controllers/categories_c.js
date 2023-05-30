/**
 * Categories controller
 * @type {{}}
 */
CategoriesController = {

    //Run renderer after store loads
    afterDataLoad: function(){

        this.myView().init();

    },//end afterStoreLoad();


    beforeDataLoad:function() {

        this.myStore().store = {
            sports: {},
            groups: {},
            tournaments: {},
            popular: {},
            favorites: {}
        };
    },

    /**
     * Request tournament data by tournament_id
     * @param tournament_id
     */
    initTournamentById: function(tournament_id, ignoreState){

        var me = this,
            node = me.myStore().getTournamentById(tournament_id);

        switch (!!node.outright){
            case false:

                var  matchesStore = App.getStore('matches');
                matchesStore.getTournamentData(tournament_id);

                break;
            case true:

                var  oddsStore = App.getStore('odds');
                oddsStore.getOutrightOdds(tournament_id);

                break;
        };

        if(!ignoreState)
            Router.set({type: 'tournament', id: tournament_id});

    }//end initTournamentById;


};//end {}