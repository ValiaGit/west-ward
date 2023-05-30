/**
 * Categories controller
 * @type {{}}
 */
HistoryController = {

    init: function(){

        var me = this;
        var Store = me.myStore();
            console.log("OnInit: ",Store.store);
        Store.requestData({proxy: 'history'});

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