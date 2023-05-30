/**
 * Main class for all Controllers
 * @type Object
 */
Controller = {

    /**
     * Empty init method
     */
    init: function(){},

    /**
     * Returns store of current controller
     */
    myStore: function(){
        return App.getStore(this.store?this.store:this.index);
    },//end myController();

    /**
     * Returns model of current controller
     */
    myView: function(){
        return App.getView(this.view?this.view:this.index);
    },//end myView;

    /**
     * Returns model of current controller
     */
    myModel: function(){
        return App.getModel(this.model?this.model:this.index);
    }//end myModel();

};//end {}