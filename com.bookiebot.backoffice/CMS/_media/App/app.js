/**
 * Application class
 * @type Object
 */
App = {

    views: {},
    models: {},
    stores: {},
    controllers: {},

    /**
     * Initialize Application class
     */
    init: function(){

    },

    /**
     * Get Controller by Index
     * @param index
     * @returns Controller
     */
    getController: function(index){
        return App.controllers[index];
    },

    /**
     * Get Store by Index
     * @param index
     * @returns Store
     */
    getStore: function(index){
        return App.stores[index];
    },

    /**
     * Get Model by Index
     * @param index
     * @returns Model
     */
    getModel: function(index){
        return App.models[index];
    },

    /**
     * Get View by Index
     * @param index
     * @returns View
     */
    getView: function(index){
        return App.views[index];
    },

    view: function(key,child){
        App.ext(key,View,child);
        App.views[key] = child;
    },

    controller: function(key,child){
        App.ext(key,Controller,child);
        App.controllers[key] = child;
    },

    store: function(key,child){
        App.ext(key,Store,child);
        App.stores[key] = child;
    },

    model: function(key,child){
        App.ext(key,Model,child);
        App.models[key] = child;
    },


    ext: function(key,_super,_child){

        var f;
        for(f in _super){
            if(typeof _child[f] == 'undefined')
                _child[f] = _super[f];
        }//end for

        _child.index  = key;
        _child._super = _super;

    }//end ext();
};


extend = function(_super,_child){

}; //end extend();

