App.controller('bets',{

    init: function(){

        var me = this;
        $("#default").html('');



        //me.myStore().requestData();

        me.myView().init();
    },//end init();

    afterDataLoad: function(){

        var me = this;


        me.myView().init();

    }//end afterDataLoad();

});//end {}