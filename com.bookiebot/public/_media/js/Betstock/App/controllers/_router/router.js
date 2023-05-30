/**
 * Router
 * @type {{}}
 */
Router = {

    init: function(){

        var me = this;
        window.onpopstate = function(event) {
            me.open(event.state);
        };

    },

    /**
     * Set current state
     * @param data
     */
    set: function(data){

        //Build url
        //Pattern: {{lang}}/p/{{type}}(/{{id}}?)
        var url = '/'+cur_lang+'/p/'+data.type + (data.id?'/'+data.id:'');

        //Push State to History
        history.pushState(data,false,url);

    },//end setCurrent();

    /**
     * Init custom state
     * @param state
     */
    open: function(state){

        var type = state?state.type:'topbets';

        switch(type){
            case 'topbets':
                App.getController('matches').initTopBets(true);
                break;
            case 'tournament':
                App.getController('categories').initTournamentById(state.id,true);
                break;
            case 'match':
                App.getController('matches').initMatchById(state.id,true);
                break;
        }//end switch

    },//end open();

    /**
     * Parse url and open according state
     */
    guess: function(){

        var me = this,
            path = window.location.pathname,
            bits = path.split('/').reverse();

        if(bits[1]=='tournament' && +bits[0]){
            me.open({type: 'tournament', id: +bits[0]});
        }else
        if(bits[1]=='match' && +bits[0]){
            me.open({type: 'match', id: +bits[0]});
        }else{
            me.open({type: 'topbets'});
        }

    },//end reload();

    /**
     * Reloads data for current match or tournament
     */
    reload: function(){
        var me = this;
        me.guess();
    }//end reload();

}//end {}

Router.init();