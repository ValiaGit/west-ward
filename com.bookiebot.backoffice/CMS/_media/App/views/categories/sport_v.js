App.view('sport',{

    init: function(){

        var me = this,
            model = me.myModel();
        $('.nav.nav-pills a[data-controller=sport]').parent('li').addClass('active').siblings().removeClass('active');

        me.destroyGrid('grid');

        $("#grid").kendoGrid({

            dataSource: me.myStore().dataSource,

            toolbar: ["create"],
            height: 880,
            pageable: false,
            filterable:true,
            editable: "inline",
            columns: model.getKendoColumns({command: ["edit", "destroy"], title: "&nbsp;", width: "260px"})

        });

    }//end init();

});