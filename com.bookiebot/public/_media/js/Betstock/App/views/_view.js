/**
 * Main class for all Views
 * @type Object
 */
View = {

    current: {
        type: 'home'
    },

    /**
     * Empty init method
     */
    init: function(){},

    /**
     * Parse templates and return built string
     * @param tpl
     * @param vars
     * @returns {*}
     */
    parseTpl: function(tpl,vars){

        var ret = '', i, index, regexp

        var matched = tpl.match(/{{([A-Za-z0-9_]+)}}/g);

        for(i in matched){
            index = matched[i].slice(2,-2);
            regexp = new RegExp('{{'+index+'}}', "g");

            tpl = tpl.replace(regexp,vars[index]?vars[index]:'');
        }

        return tpl;

    },//end parseTpl

    /**
     * Returns controller of current store
     */
    myController: function(){
        return App.getController(this.index);
    },//end myController();

    /**
     * Returns store of current controller
     */
    myStore: function(){
        return App.getStore(this.index);
    },//end myController();

    /**
     * Returns model of current controller
     */
    myModel: function(){
        return App.getModel(this.index);
    }//end myModel();

};//end {}