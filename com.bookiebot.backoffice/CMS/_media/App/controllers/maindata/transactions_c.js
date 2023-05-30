App.controller('transactions',{

    init: function(){

        console.log('Init Transaction Controller');
        var me = this;
            //me.myView().init();
        me.myStore().requestData();

    },//end init();

//    /**
//     * Handler of the store data load event
//     * We need to run view from here :) Woohoo!!!
//     */
    afterDataLoad: function(){

        var me = this;

        me.myView().init();

    }//end afterDataLoad();

});//end {}