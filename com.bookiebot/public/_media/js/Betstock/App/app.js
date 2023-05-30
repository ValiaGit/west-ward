/**
 * Application class
 * @type Object
 */
App = {

    controllers: ['categories','matches','odds','betslip','history'],
    models: ['sport','group','tournament','matches','config','odds','history'],
    stores: ['categories','matches','config','odds','betslip','history'],
    views: ['categories','matches','odds','betslip','history','whereismoney'],

    init: function(){
        AppInit();
    },

    /**
     * Get Controller by Index
     * @param index
     * @returns Controller
     */
    getController: function(index){
        return window[index.charAt(0).toUpperCase() + index.slice(1)+'Controller'];
    },

    /**
     * Get Store by Index
     * @param index
     * @returns Store
     */
    getStore: function(index){
        return window[index.charAt(0).toUpperCase() + index.slice(1)+'Store'];
    },

    /**
     * Get Model by Index
     * @param index
     * @returns Model
     */
    getModel: function(index){
        return window[index.charAt(0).toUpperCase() + index.slice(1)+'Model'];
    },

    /**
     * Get View by Index
     * @param index
     * @returns View
     */
    getView: function(index){
        return window[index.charAt(0).toUpperCase() + index.slice(1)+'View'];
    },

    /**
     * Private
     * Initialize Controllers, Models, Stores and Views
     * Adds methods from main classes
     */
    initComponents: function(){
        //Localize
        var me = this, _super, _child, i,
            /**
             * Extend child to super
             * @param _super
             * @param _child
             */
            extend = function(_super,_child){
                var f;
                for(f in _super){
                    if(typeof _child[f] == 'undefined')
                        _child[f] = _super[f];
                }//end for
            }; //end extend();

        //Init controllers
        _super = Controller;
        for(i = 0; i<me.controllers.length; i++){
            _child = me.getController(me.controllers[i]);
            extend(_super,_child);
            _child.index = me.controllers[i];
            _child._super = _super;
        }//end controllers

        //Init Models
        _super = Model;
        for(i = 0; i<me.models.length; i++){
            _child = me.getModel(me.models[i]);
            extend(_super,_child);
            _child.index = me.models[i];
            _child._super = _super;
        }//end models

        //Init Stores
        _super = Store;
        for(i = 0; i<me.stores.length; i++){
            _child = me.getStore(me.stores[i]);
            extend(_super,_child);
            _child.index = me.stores[i];
            _child._super = _super;
        }//end stores

        //Init Views
        _super = View;
        for(i = 0; i<me.views.length; i++){
            _child = me.getView(me.views[i]);
            extend(_super,_child);
            _child.index = me.views[i];
        }//end stores

    }//end initComponents();



};

