var Util = {

    showNotification:function (text,type) {

        if(!text) {
            text = "Success";
        }

        if(!type) {
            type = "success";
        }

        var header = type.charAt(0).toUpperCase() + type.slice(1);

        $.jGrowl(text, { sticky: true, theme: 'growl-'+type, header: header });

        setTimeout(function() {
            $('div.jGrowl').find('.jGrowl-close').trigger('jGrowl.close');
        },2500);

    }
};