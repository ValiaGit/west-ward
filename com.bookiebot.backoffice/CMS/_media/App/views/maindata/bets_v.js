App.view('bets', {

    /**
     * You're dummy if u need comment for InitPrivatelyn
     */
    init: function (bet_id,users_id) {

        $('.col-sm-1').removeClass('active');
        $('.col-sm-1[data-controller=bets]').addClass("active");

        var me = this,
            model = me.myModel(),
            container = new Tab({
                id: 'bets',
                name: "Bets"
            });



        var grid = me.createGrid('BetsGrid', container);


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
                    //read: function(options) {
                    //        options.success(data);
                    //}
                    read: {
                        url: API.getUrl('betting.bets','getBetList'),
                        dataType: 'json',
                        type: 'POST'
                    }
                },
                requestEnd:function(e) {
                    try {
                        var response = e.response;

                        if(response.hasOwnProperty('data')) {
                            if(!response['data'].length) {

                            }
                        }

                        if(response['logout'] == true) {
                            window.location.href = 'index.php';
                        }
                    }catch(e) {

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
                pageSize: 10,
                serverFiltering: true,
                serverPaging:true
            },
            noRecords: {
                template: "<h3 style='padding:10px;'>No data available</h3>"
            },
            detailInit: function (e) {

                var detailRow = e.detailRow;


                try {
                    e.data.odd_status = {
                        0: 'Disabled',
                        1: 'Open For Bets',
                        2: 'Lose',
                        3: 'Win'
                    }[parseInt(e.data.mos)];

                    console.log(e.data.odd_status);
                }catch(e) {
                    console.log(e);
                }


                $.ajax({
                    url: API.getUrl('betting.bets', 'getBetDetails'),
                    data: {bet_id: e.data.bets__id},
                    type: 'POST',
                    dataType: 'json',
                    success: function (response) {

                        try {

                            var data = response.data[e.data.bets__id];



                            var PrivateData = e.data['private_data'];
                            console.log(e.data);
                            try {
                                if(PrivateData[0]) {
                                    var PrData = PrivateData[0];

                                    var Sender =PrData['sender_name'];
                                    var SenderId =PrData['sender_user_id'];

                                    var Receiver =PrData['receiver_user'];
                                    var ReceiverId =PrData['receiver_user_id'];


                                    $('.private_data').html('<hr/><table class="table">' +
                                        '<caption>Private Matching Data</caption>' +
                                            '<thead>' +
                                                '<tr>' +
                                                    '<td>ReceiverId</td>' +
                                                    '<td>ReceiverName</td>' +
                                                    '<td>SenderId</td>' +
                                                    '<td>SenderName</td>' +
                                                '</tr>' +
                                            '</thead>' +
                                            '<tbody>' +
                                                '<tr>' +
                                                        '<td>'+ReceiverId+'</td>' +
                                                        '<td>'+Receiver+'</td>' +
                                                        '<td>'+SenderId+'</td>' +
                                                        '<td>'+Sender+'</td>' +
                                                '</tr>' +
                                            '</tbody>' +
                                        '</table>');

                                }
                            }catch(e) {
                                alert(e);
                            }






                            var html = [];
                            //console.log(data);

                            if (data.matched_with && data.matched_with.length) {
                                html.push("<hr/><table class=\"table\">" +
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
                                    console.log(item);
                                    html.push('<tr>');

                                    html.push('<td>' + item.bet_id + '</td>')
                                    html.push('<td>' + kendo.toString(item.back_amount_in_pot/100) + ' €</td>');
                                    html.push('<td>' + kendo.toString(item.lay_amount_in_pot/100) + ' €</td>');
                                    html.push('<td>' + kendo.toString(item.betting_pot_amount/100) + ' €</td>');

                                    html.push('</tr>');
                                }
                                html.push("</tbody></table>");
                            }

                            detailRow.find('.matching_data').html(html.join(''));

                            html = [];

                            if (data.cancelation_data && Object.keys(data.cancelation_data).length) {

                                html.push("<hr/><table class=\"table\">" +
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
                        }catch(e) {

                        }

                    }
                });


                console.log(e.data);
                if(e.data['is_private'] == "1" || e.data['is_private'] == 1) {
                    $.ajax({
                        url: API.getUrl('betting.bets', 'getBetReceiversInPrivateBetWhichCurrentUserMade2'),
                        data: {private_bet_id: parseInt(e.data.bets__id), users_id: parseInt(e.data['users__id'])},
                        type: 'POST',
                        dataType: 'json',
                        success: function (response) {
                            if(response.code == 10) {
                                var data = response.data;
                                var html = "<hr/><table class=\"table\">" +
                                    "<caption>Privatly Sent To Users</caption>" +
                                    "<thead><tr>" +
                                    "<td>Username</td>" +
                                    "<td>User Id</td>" +
                                    "</tr></thead><tbody>";

                                for(var i in data) {
                                    var cur = data[i];
                                    html+='<tr><td>'+cur['full_name']+'</td><td>'+cur['receiver_id']+'</td></tr>';


                                }

                                html+='</tbody>';
                                html+='</table>';

                                $('.private_data_sent').html(html);
                            }
                        }
                    });
                }



                $('.tip').tooltip();

            },

            detailTemplate: $("#BetsDetailTpl").html(),

            resizable: true,
            filterable: {
                extra:false
            },

            scrollable: true,
            sortable: true,
            pageable: true,



            columns: model.getKendoColumns()
        });




        $('.datepicker').datepicker({ dateFormat: 'yy-mm-dd' });

    },//end init();

    /**
     * Render grid for history data
     */
    renderData: function () {


    }//end renderData();


});//end {}