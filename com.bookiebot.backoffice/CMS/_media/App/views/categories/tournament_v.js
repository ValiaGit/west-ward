App.view('tournament',{

    init: function(){

        var me = this,
            model = me.myModel();

        $('.nav.nav-pills a[data-controller=tournament]').parent('li').addClass('active').siblings().removeClass('active');


        me.destroyGrid('grid');


        //noinspection JSUnresolvedFunction
        $("#grid").kendoGrid({

            dataSource: me.myStore().dataSource,

            toolbar: ["create"],
            height: 550,
            pageable: true,
            filterable:true,
            editable: "inline",
            columns: model.getKendoColumns({command: ["edit", "destroy"], title: "&nbsp;", width: "160px"})

        });

    }//end init();

});