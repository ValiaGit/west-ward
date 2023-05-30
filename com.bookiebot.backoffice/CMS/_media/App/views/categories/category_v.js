App.view('category',{

    init: function(){

        var me = this,
            model = me.myModel();

        $('.nav.nav-pills a[data-controller=category]').parent('li').addClass('active').siblings().removeClass('active');


        me.destroyGrid('grid');


        //noinspection JSUnresolvedFunction
        $("#grid").kendoGrid({

            dataSource: me.myStore().dataSource,

            toolbar: ["create"],
            height: 550,
            filterable:true,
            pageable: true,
            editable: "inline",
            sortable: true,
            columns: model.getKendoColumns({command: ["edit", "destroy"], title: "&nbsp;", width: "160px"})

        });

    }//end init();

});