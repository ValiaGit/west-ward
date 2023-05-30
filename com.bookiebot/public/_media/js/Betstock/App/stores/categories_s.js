//noinspection JSUnusedGlobalSymbols
/**
 * Categories store
 */
CategoriesStore = {

    model: 'sport',

    proxy: {
        default: {
            service: 'betting.categories',
            method: 'getCategoryList',
            params:{
                user_id: $.cookie("user_id")
            }
        },

        addfav: {
            service: 'betting.categories',
            method: 'addFavTournament'
        },

        removefav: {
            service: 'betting.categories',
            method: 'removeFavTournament'
        }
    },

    store: {
        sports: {},
        groups: {},
        tournaments: {},
        popular: {},
        favorites: {}
    },

    listeners: {
        afterdataload: 'categories.afterDataLoad',
        beforedataload: 'categories.beforeDataLoad',
        addfav: 'categories.view.addFavCallback'
    },

    /**
     * Initialize Categories store
     */
    init: function(intervalMinutes){

        var me = this;
        me.intervalMinutes = intervalMinutes;
        var requestParams = {};
        if(intervalMinutes != -1) {
            requestParams = {
                params:{
                    intervalMinutes:intervalMinutes
                }
            };
        }

        me.requestData(requestParams);

    },//end init();

    /**
     * Add tournament as favorite
     * @param id
     */
    addFav: function(id){

        var me = this;

        var user_id = Util.Cookie.get('user_id');

        var callback = function(response){
            if(response.code == 10){
                me.trigger('addfav');
            }
        };
        me.requestData({proxy: 'addfav', params: {tournament_id: id,    user_id:user_id}},callback);

    },//end addFav();

    newItem: function(item){
        var me = this;
        switch(item.type){
            case 'sport':
               me.store.sports[item.id] = item;
               break;
            case 'group':
               me.store.groups[item.id] = item;
               break;
            case 'tournament':
               me.store.tournaments[item.id] = item;

                if(item.popular)
                me.store.popular[item.id] = item;

                if(item.fav)
                me.store.favorites[item.id] = item;
               break;
        }
    },//end newItem();

    /**
     * Clear tournament matches data
     * @param id
     */
    clearTournamentMatches: function(id){
        var me = this;
            me.getData().tournaments[id].matches = [];
    },//end clearTournamentMatches();

    // --------- GETTERS --------- \\
    /**
     * Get sport by id
     * @param id
     * @return {*}
     */
    getSportById: function(id){
        return this.store.sports[id];
    },//end getSportById();

    /**
     * Returns group by id
     * @param id
     * @return {*}
     */
    getGroupById: function(id){
        return this.store.groups[id];
    },//getGroupById();

    /**
     * Get tournament by id
     * @param id
     * @return {*}
     */
    getTournamentById: function(id){
        return this.store.tournaments[id];
    },

    /**
     * Get tournament, group and sport data by tournament id
     * @param id
     * @returns {*}
     */
    getNestedByTournament: function(id){
       var me = this,
           t = me.getTournamentById(id),    //tournament
           g = me.getGroupById(t.parent),   //group
           s = me.getSportById(g.parent);   //sport

       return {tournament: t, group: g, sport: s};
    }//end getNestedByTournament();

};//end {}