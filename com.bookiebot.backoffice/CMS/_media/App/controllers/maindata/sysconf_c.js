App.controller('sysconf',{

    init: function(){

        var me = this;
        $("#default").html('');
        $('.col-sm-1').removeClass('active');
        $('.col-sm-1[data-controller=sysconf]').addClass("active");


        //me.myStore().requestData();

        me.myView().init();
    },//end init();

    afterDataLoad: function(){

        var me = this;


        me.myView().init();

    }//end afterDataLoad();

});//end {}