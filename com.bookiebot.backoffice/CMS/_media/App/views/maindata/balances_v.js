App.view('balances',{

    /**
     * You're dummy if u need comment for Init function
     */

    init: function(){



        $('.col-sm-1').removeClass('active');
        $('.col-sm-1[data-controller=balances]').addClass("active");

        var me = this,

            extend = {},

            container = new Tab({
                id: 'balances',
                name: "Balances"
            });


        var grid = me.createGrid('BalancesGrid',container);


        $("#BalancesGrid").kendoGrid({
            toolbar: ["excel"],
            excel: {
                fileName: "Bets",
                proxyURL: "http://demos.telerik.com/kendo-ui/service/export",
                filterable: true,
                allPages: true
            },
            dataSource: {
                transport: {
                    read: {
                        url: API.getUrl('user.user','getBalanceHistory'),
                        type: 'post',
                        dataType: 'json'
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
                    id: 'core_daily_balance_snapshots__core_users_id',
                    model: {
                        fields: {
                            core_daily_balance_snapshots__core_users_id: {},
                            balance: {parse: function(v){ return v/100; } },
                            balance_date: {},
                            datestring: {}
                        }
                    }
                },
                pageSize: 30,
                serverFiltering: true,
                serverPaging:true
            },
            scrollable: true,
            sortable: true,
            pageable: true,

            filterable: {
                extra: false,
                operators: {
                    string: {eq: "Is equal to"},
                    number: {eq: "Is equal to"}
                }
            },

            columns: [
                { field:'core_daily_balance_snapshots__core_users_id', title: 'ID', width: 100},
                {
                    field:'balance',
                    title: 'Balance (€)'
                },{
                    field:'balance_date',
                    title: 'balance_date',
                    filterable:false
                },{
                    field:'core_daily_balance_snapshots__datestring',
                    title: 'Day'
                }
            ]
        });






    },//end init();

    /**
     * Render grid for history data
     */
    renderData: function(){


    }//end renderData();


});//end {}