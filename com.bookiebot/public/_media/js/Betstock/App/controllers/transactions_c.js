/**
 * Categories controller
 * @type {{}}
 */
TransactionsController = {

    init: function(){

        var me = this;

        me.myStore().requestData();

    },//end init();

    /**
     * Handler of the store data load event
     * We need to run view from here :) Woohoo!!!
     */
    afterDataLoad: function(){

        var me = this;
        me.myView().renderData();

    }//end afterDataLoad();

};//end {}