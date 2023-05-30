/**
 * Categories store
 */
MatchesStore = {

    model: 'matches',

    proxy: {
        tournament: {
            service: 'betting.matches',
            method: 'getMatchesByTournamentID'
        },
        match: {
            service: 'betting.matches',
            method: 'getMatch'
        },
        topbets: {
            service: 'betting.topmatches',
            method: 'getTopMatches'
        }
    },

    store: {},
    topbets: {},

    listeners: {
        afterdataload: 'matches.afterDataLoad'
    },

    /**
     * Initialize Categories store
     */
    init: function(){

    },//end init();

    /**
     * Gets data by tournament id
     * @param tournament_id
     */
    getTournamentData: function(tournament_id){
        var me = this;
        me.destroyMatches();
        App.getStore('categories').clearTournamentMatches(tournament_id);
        Util.addLoader('#MiddleContainer');
        var req_params = {tournament_id:tournament_id};

        var catStore = App.getStore("categories");
        console.log(catStore.intervalMinutes);
        if(typeof catStore.intervalMinutes != undefined && catStore.intervalMinutes!="-1") {
            req_params.intervalMinutes = App.getStore("categories").intervalMinutes;
        }
        me.requestData({proxy: 'tournament', params: req_params, type: 'tournament'});
    },//end getLeague();

    /**
     * Gets top bets data
     */
    getTopBetsData: function(){
        var me = this;
        me.destroyMatches();
        me.requestData({proxy: 'topbets', type: 'topbets'});
    },

    /**
     * Gets match data by id
     * @param match_id
     */
    getMatchData: function(match_id){
        var me = this;
        Util.addLoader("#MiddleContainer");
        //Soo, we need to get match data now
        me.requestData({proxy: 'match', params: {match_id:match_id}, type: 'match', dataType: 'single'});

    },//end getMatchData;

    newItem: function(item,options){
        var me = this;

        switch(options.type){
            case 'tournament':
                //if type was tournament
                //add torunament id reference into match reference
                item.tournament_id = options.params.tournament_id;
                //and save this match to it's related tournament object
                App.getStore('categories').getTournamentById(item.tournament_id).matches.push(item.id);
            case 'topbets':
                //IF we have top bets here, we need to create sub array by sport_id
                if(!me.topbets[item.sport]){ me.topbets[item.sport] = []; }
                me.topbets[item.sport].push(item.id);
            case 'match':
                //If type was match, we need to save it as is
                me.store[item.id] = item;
                break;

        }//end switch;

    },//end newItem();

    destroyMatches: function(){
        var me = this;
            me.store = {},
            me.topbets = {};
    },


    /**
     * Returns reference of type by match and type ids
     * @param match_id
     * @param type_id
     */
    getTypeByMatchAndTypeId: function(match_id, type_id){

        var me = this;

        try{
            return me.store[match_id].oddTypes[type_id];
        }catch(e){
            console.error(e);
        }

    },//end getTypeByMatchAndTypeId();

    /**
     * returns pair as string
     * @param id
     * @returns {string}
     */
    getPair: function(id){
        var me = this,
            match = me.getItemById(id),
            pair = match.home + ' - ' + match.away;

        return pair;
    },//end getPair();

    /**
     * Get TopBets data
     * @returns {*}
     */
    getTopBets: function(){
       return this.topbets;
    }//end getTopBets();

};//end {}