App.view('outrightbets', {

    /**
     * You're dummy if u need comment for Init function
     */
    init: function (bet_id,users_id) {


        var me = this,
            model = me.myModel(),
            container = new Tab({
                id: 'outrightbets',
                name: "Outright Bets"
            });


        $('.col-sm-1').removeClass('active');
        $('.col-sm-1[data-controller=outrightbets]').addClass("active");

        var grid = me.createGrid('OutrightBetsGrid', container);




        grid.kendoGrid({
            toolbar: ["excel"],
            excel: {
                fileName: "Bets",
                proxyURL: "http://demos.telerik.com/kendo-ui/service/export",
                filterable: true
            },
            noRecords: {
                template: "<h3 style='padding:10px;'>No data available</h3>"
            },
            dataSource: {
                transport: {
                    //read: function(options) {
                    //    options.success(data);
                    //}
                    read: {
                        url: API.getUrl('betting.outrightbets','getBetList'),
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
                    data:"data",
                    total:"total",
                    model: {
                        id: 'bets__id',
                        fields: model.fields

                    }
                },
                serverPaging: true,
                pageSize: 12,
                serverFiltering: true
            },
//            height: 550,
            scrollable: true,
            sortable: true,
            filterable: {
                extra:false
            },

            detailInit: function (e) {

                var detailRow = e.detailRow;

                $.ajax({
                    url: API.getUrl('betting.outrightbets', 'getBetDetails'),
                    data: {bet_id: e.data.bets__id},
                    type: 'POST',
                    dataType: 'json',
                    success: function (response) {


                        try {
                            if(response.hasOwnProperty('logout')) {
                                window.location.href = 'index.php';
                            }
                        }catch(e) {

                        }

                        var data = response.data[e.data.bets__id];
                        var html = [];

                        if (data.matched_with && data.matched_with.length) {
                            html.push("<table class=\"table\">" +
                                "<caption>Matching Data</caption>" +
                                "<thead><tr>" +
                                "<td>Bet ID</td>" +
                                "<td>Back In Pot</td>" +
                                "<td>Lay In Pot</td>" +
                                "<td>Pot Amount</td>" +
                                "</tr></thead>");

                            html.push('<tbody>');

                            for (var i in data.matched_with) {
                                var item = data.matched_with[i];

                                html.push('<tr>')

                                html.push('<td>' + item.bet_id + '</td>')
                                html.push('<td>' + kendo.toString(item.back_amount_in_pot / 100) + ' €</td>');
                                html.push('<td>' + kendo.toString(item.lay_amount_in_pot / 100) + ' €</td>');
                                html.push('<td>' + kendo.toString(item.betting_pot_amount / 100) + ' €</td>');

                                html.push('</tr>')
                            }
                            html.push("</tbody></table>")
                        }

                        detailRow.find('.matching_data').html(html.join(''));

                        html = [];

                        if (data.cancelation_data && Object.keys(data.cancelation_data).length) {

                            html.push("<table class=\"table\">" +
                                "<caption>Cancelation Data</caption>" +
                                "<thead><tr>" +
                                "<td>Cancelation Date</td>" +
                                "<td>Canceled Amount</td>" +
                                "</tr></thead>");

                            html.push('<tr>');
                            html.push('<td>' + data.cancelation_data.cancel_time + '</td>');
                            html.push('<td>' + kendo.toString(data.cancelation_data.returned_amount / 100) + ' €</td>');
                            html.push('</tr>');
                            html.push("</tbody></table>");
                        }

                        detailRow.find('.canceled_data').html(html.join(''));
                    }
                })

                $('.tip').tooltip();

            },

            detailTemplate: $("#BetsDetailTpl").html(),

            pageable: true,
            columns: model.getKendoColumns()
        });


    },//end init();

    /**
     * Render grid for history data
     */
    renderData: function () {


    }//end renderData();


});//end {}