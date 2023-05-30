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

    createGrid: function (id, target) {
        //Destory Grid Of Leagues
        var grid = target.find('#'+id);

        if(!grid.length){
            target.append('<div id="'+id+'"></div>');
            return target.find("#"+id);
        }

        var GridData = grid.data("kendoGrid");

        if (typeof GridData != 'undefined') {
            if(GridData)
                GridData.destroy();
            grid.empty();
        }

        grid.html('').removeClass("k-grid");
        grid.html('').removeClass("k-widget");

        return grid;
    },

    /**
     * Render Filters
     */
    createFilters: function(target, options){

        var me = this;

        if(!options) options = {};

        var filter = new Filter({fields: me.myModel().fields, store: me.index, proxy: options.proxy?options.proxy:false });

        if(!target.find('.filter-container').length)
            target.prepend(filter.render());

    },//end renderFilter();


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
    },//end myModel();

    /**
     * Destroys kendo grid if exists
     * @param grid_id
     */
    destroyGrid: function(grid_id){

        var el = $("#"+grid_id),
            grid = el.data('kendoGrid');
        if(grid) grid.destroy();
            el.empty();
    }

};//end {}