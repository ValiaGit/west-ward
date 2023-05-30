App.view('laundring',{

    init: function(){

        var me = this,
            container = new Tab({
                id: 'laundring',
                name: "Player Loss/Wins"
            });

        $('.col-sm-1').removeClass('active');
        $('.col-sm-1[data-controller=laundring]').addClass("active");
        $('#Tablaundring').html("");
        $('#Tablaundring').prepend("<h1>Player Loss/Wins</h1>");

        var grid = me.createGrid('LaundringGrid', container);

        grid.kendoGrid({
            toolbar: ["excel"],
            excel: {
                fileName: "Player Loss/Wins",
                proxyURL: "http://demos.telerik.com/kendo-ui/service/export",
                filterable: true
            },
            dataSource: {
                transport: {
                    read: {
                        url: API.getUrl('financial.laundring','getLaundringData'),
                        dataType: 'json',
                        type: 'POST'
                    },
                    requestEnd:function(e) {
                        try {
                            var response = e.response;
                            if(response['logout'] == true) {
                                window.location.href = 'index.php';
                            }
                        }catch(e) {

                        }

                    }
                },
                schema: {
                    data: 'data',
                    total: "total",

                    model: {
                        id: 'id',
                        fields: {
                            id:{type:"number"},
                            laundring__transfer_date:{type:"date"}
                        }
                    }
                },
                pageSize:10,
                serverPaging: true,
                serverFiltering: true,
                serverSorting: true
            },
            scrollable: true,
            sortable: true,
            resizable: true,
            filterable: {
                extra: false,
                operators: {
                    string: {eq: "Is equal to"},
                    number: {eq: "Is equal to"}
                }
            },
            noRecords: {
                template: "<h3 style='padding:10px;'>No data available</h3>"
            },
            pageable:true,
            columns:[
                {
                    title:"Amount",
                    field:"amount",
                    template:function(data) {
                        return (data.amount/100)+" €";
                    }
                },
                {
                    title:"Date",
                    field:"laundring__transfer_date",
                    filterable:{
                        extra:true,
                        operators: {
                            date: {
                                lt: "Is before",
                                gt: "Is after"
                            }
                        }
                    },
                    template: "#= kendo.toString(kendo.parseDate(laundring__transfer_date, 'yyyy-MM-dd'), 'dd/MM/yyyy HH:mm:ss') #",
                },
                {
                    title:"Loser User ID",
                    field:"loser__id",
                    template:function(row) {
                        return row['loser__username'] +" (id:"+row['loser__id']+")"
                    }
                },
                {
                    title:"Winner User ID",
                    field:"winner__id",
                    template:function(row) {
                        return row['winner__username'] +" (id:"+row['loser__id']+")"
                    }
                },
                {
                    title:"Is Suspect",
                    field:"laundring__is_suspect",
                    template:function(row) {
                        return row['laundring__is_suspect'];
                    }
                }



            ]
        });
        $('.datepicker').datepicker({ dateFormat: 'yy-mm-dd' });

    }




});//end {}

