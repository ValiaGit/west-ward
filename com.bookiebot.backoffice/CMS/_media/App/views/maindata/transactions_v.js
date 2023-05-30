App.view('transactions',{

    /**
     * You're dummy if u need comment for Init function
     */
    init: function(transaction_id,users_id) {

        var me = this,
            data = me.myStore().getData(),
            model = me.myModel(),
            container = new Tab({
                id: 'transactions',
                name: "Deposit/Withdrawals"
            });

        //me.createFilters(container);
        
        var grid = me.createGrid('TransactionsGrid',container);

        $('.col-sm-1').removeClass('active');
        $('.col-sm-1[data-controller=transactions]').addClass("active");

        grid.kendoGrid({
            toolbar: ["excel"],
            excel: {
                fileName: "Bets",
                proxyURL: "http://demos.telerik.com/kendo-ui/service/export",
                filterable: true,
                allPages: true
            },
            dataSource: {
                transport: {
                    //read:function(options) {
                    //    options.success(data);
                    //},
                    read: {
                        url: API.getUrl('financial.transactions','getTransactionsList'),
                        dataType: 'json',
                        type: 'POST'
                    }
                },
                requestEnd:function(e) {
                    try {
                        var response = e.response;
                        if(response['logout'] == true) {
                            window.location.href = 'index.php';
                        }
                    }catch(e) {

                    }

                },
                schema: {
                    data: 'data',
                    total:"total",
                    model: {
                        id: 'id',
                        fields: model.fields
                    }
                },
                pageSize: 10,
                serverPaging: true,
                serverFiltering: true,
                serverSorting: true
            },
            scrollable: true,
            sortable: true,
            resizable: true,
            filterable: true,

            pageable: true,
            columns: model.getKendoColumns()
        });


        $('.datepicker').datepicker({ dateFormat: 'yy-mm-dd' });




    },//end init();

    /**
     * Render grid for history data
     */
    renderData: function(){


    }//end renderData();


});//end {}