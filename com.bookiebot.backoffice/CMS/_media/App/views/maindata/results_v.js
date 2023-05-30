App.view('results',{

    /**
     * You're dummy if u need comment for Init function
     */
    init: function(){


        $('.col-sm-1').removeClass('active');
        $('.col-sm-1[data-controller=results]').addClass("active");
        var me = this,
            data = me.myStore().getData(),
            model = me.myModel(),

            container = new Tab({
                id: 'results',
                name: "Results"
            });

        //me.createFilters(container);

        var grid = me.createGrid('ResultsGrid',container);

        if(!data) {
            grid.html("<h2>There are no newely resulted matches in system.</h2>");
            return false;
        }
        grid.kendoGrid({
            dataSource: {
                data: data,
                schema: {
                    model: {
                        fields: model.fields
                    }
                },
                pageSize: 20
            },
            height: 550,
            scrollable: true,
            sortable: true,
            filterable: true,

//            detailInit: function(e){
//
//                var detailRow = e.detailRow, //get row
//                    tpl = e.detailRow.html(), //get tpl
//                    model = me.myModel().fields, //get model
//                    extend = {};
//
//
//                e.detailRow.html(tpl);//update tpl
//
//            },

//            detailTemplate: $("#BetsDetailTpl").html(),

            pageable: {
                input: true,
                numeric: false
            },
            columns: model.getKendoColumns()
        });


        var filter = new Filter({fields: me.myModel().fields });

        $("#default").prepend(filter.render());




    },//end init();

    /**
     * Render grid for history data
     */
    renderData: function(){


    }//end renderData();


});//end {}