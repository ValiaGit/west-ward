$(function(){

    pageContent = $('#PageContent');

    App.init();
    App.getController('dashboard').init();

    $('body').on('change',".language-editor",function(){

        var data = {};
        data[$(this).data('lang')] = $(this).val();
        $(this).siblings('.language-editor').each(function(){
           data[$(this).data('lang')]=$(this).val();
        });

        $(this).siblings('.main-input').val(JSON.stringify(data)).trigger('change');


    });

    $("body").on("click", 'a[data-controller], a[data-page]:not(.k-link)',function(e) {

        e.preventDefault();

        var me = $(this);
        var page = me.data('page');
        var bits = $(me).data('controller').split(".");
        var controller_name = bits[0];
        var method_name = bits[1]?bits[1]:'init';



        if(page){
            $.get("pages/"+page+'.html', function( data ) {

                pageContent.html( data );

                $(me).parent('li').addClass('active').siblings().removeClass('active');

                if(controller_name)
                    App.getController(controller_name)[method_name]();
            });
        }else
        if(controller_name){
            App.getController(controller_name).init();
        }

        e.preventDefault();

    });


    //Main Navigation
//    $('body').on('click',"#Navigation a",function(e){
//
//        var controller = $(this).data('controller');
//
//        console.log('Init controller:', controller);
//
//        App.getController(controller).init();
//
//        $(this).addClass('active').siblings().removeClass('active');
//
//        e.preventDefault();
//
//    });


//    $('body').on("change",'.passport_verification',function() {
//        var id = $(this).data("id");
//        if($(this).is(":checked")) {
//            App.getStore("users").requestData({proxy: 'verifyPassport', params: {'id': id}}, function(data){
//                console.log(data);
//            });
//        } else {
//            App.getStore("users").requestData({proxy: 'unVerifyPassport', params: {'id': id}}, function(data){
//                console.log(data);
//            });
//        }
//
//    });

});