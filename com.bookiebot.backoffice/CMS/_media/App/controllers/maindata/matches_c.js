App.controller('matches',{

    init: function(){

        var me = this;

        me.myStore().requestData();

    },//end init();

    initEdit: function(){


        var me= this;
        me.myView().initEdit();

    },

    /**
     * Handler of the store data load event
     * We need to run view from here :) Woohoo!!!
     */
    afterDataLoad: function(){

        var me = this;

        me.myView().init();

    }//end afterDataLoad();

});//end {}