App.view('commission',{

    init: function(){



        $('.col-sm-1').removeClass('active');
        $('.col-sm-1[data-controller=commission]').addClass("active");

        var me = this,
            container = new Tab({
                id: 'commission',
                name: "Commissions"
            });

        //var html = '';
        //html += '<div class="panel panel-default filter-container">' +
        //    '<div class="panel-heading">' +
        //    '<h6 class="panel-title"><i class="icon-search3"></i> Filter</h6>' +
        //    '</div>'+
        //    '<div class="panel-body">' +
        //    '' +
        //    '<div class="clearfix form-group">';
        //
        //html += '<div class="col-md-6 row">' +
        //    '<input width="50%" id="commission_from" class="form-control datepicker"  placeholder="From">' +
        //    '</div>' +
        //    '<div class="col-md-6 row">' +
        //    '<input id="commission_to" class="form-control datepicker" placeholder="To">' +
        //    '</div>';
        //
        ////add submit button
        //html += '</div><div class="col-md-12 row form-actions">' +
        //    '<input type="submit" id="SubmitCommissionsFilter" value="Submit" class="btn btn-primary">' +
        //    '</div>';
        //
        //html+=  '</div></div>';

        $('#Tabcommission').html('');
        //$('#Tabcommission').prepend(html);



        container.append("<h2>Profits from Betting Exchange</h2>");
        var grid = me.createGrid('CommissionsGrid', container);
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
                    read: {
                        url: API.getUrl('financial.commission','getCommissions'),
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
                    total: "total",

                    model: {
                        id: 'id',
                        fields: {
                            id:{type:"number"},
                            amount:{type:"number"},
                            commissions__create_date:{type:"date"}
                        }
                    }
                },

                aggregate:[{ field: "amount", aggregate: "sum" }],

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
            pageable:true,
            columns:[
                {
                    title:"Commission Cut (Euro)" ,
                    field:"amount",
                    template:function(data) {
                        return (data.amount/100);
                    },
                    filterable:false,
                    aggregates: ["sum"],
                    footerTemplate: "<div>Total Amounts: #= (sum/100) #</div><div>5% Commission: #= (sum*5/100)/100 #</div>"
                },
                {
                    title:"WinnerBetId",
                    field:"commissions__winner_bet_id",
                    template:function(row) {
                        var BetTypeText = "";
                        switch(row['winner_bet_bet_type']) {
                            case 1:
                            case "1":
                                BetTypeText = "Lay";
                                break;
                            case 2:
                            case "2":
                                BetTypeText = "Back";
                                break;
                        }

                        var Amount = row['winner_bet_bet_amount'];
                        return "Id: "+row['commissions__winner_bet_id']+";<br/> Amount: "+parseFloat(Amount).trunc(2)+";<br/> Type: "+BetTypeText;

                    }
                },
                {
                    title:"LoserBetId",
                    field:"commissions__loser_bet_id",
                    template:function(row) {
                        var BetTypeText = "";
                        switch(row['loser_bet_bet_type']) {
                            case 1:
                            case "1":
                                BetTypeText = "Lay";
                                break;
                            case 2:
                            case "2":
                                BetTypeText = "Back";
                                break;
                        }

                        var Amount = row['loser_bet_bet_amount'];
                        console.log(Amount);
                        return "Id: "+row['commissions__loser_bet_id']+";<br/> Amount: "+parseFloat(Amount).trunc(2)+"€; <br/>Type: "+BetTypeText;

                    }
                },
                {
                    title:"Win User",
                    field:"winner_bet__core_users_id",
                    template:function(row) {
                        return row['winner_username']+" (id:"+row['winner_bet__core_users_id']+")"
                    }
                },
                {
                    title:"Lose User",
                    field:"loser_bet__core_users_id",
                    template:function(row) {
                        return row['loser_username']+" (id:"+row['loser_bet__core_users_id']+")"
                    }
                },
                {
                    title:"Pot Amount",
                    field:"betting_pot_amount",
                    template:function(row) {
                        return (row['betting_pot_amount']/100).trunc(2)+" €";
                    }
                },
                {
                    title:"Back in POT",
                    field:"back_amount_in_pot",
                    template:function(row) {
                        return (row['back_amount_in_pot']/100).trunc(2) +" €";
                    }
                },
                {
                    title:"Lay in POT",
                    field:"lay_amount_in_pot",
                    template:function(row) {
                        return (row['lay_amount_in_pot']/100).trunc(2)+" €";
                    }
                },
                {
                    title:"Date",
                    field:"commissions__create_date",
                    type:"date",
                    filterable:{
                        extra:true,
                        operators: {
                            date: {
                                lt: "Is before",
                                gt: "Is after"
                            }
                        }
                    },

                    template: "#= kendo.toString(kendo.parseDate(commissions__create_date, 'yyyy-MM-dd'), 'dd/MM/yyyy HH:mm:ss') #"
                }

            ]
        });


        container.append('<br/><h2></h2>' +
            '<div class="panel panel-default">' +
                '<div class="panel-heading">' +
                    '<h6 class="panel-title">' +
                        '<i class="icon-html5"></i> Profits By License' +
                    '</h6>' +
                '</div>' +

                '<div class="panel-body">' +

                        '<form class="form-inline" style="margin-bottom:20px">' +
                                    '<div class="form-group"><label>FromDate:</label> <input id="profitFrom" type="" class="form-control datepicker"/> </div>' +
                                    '<div class="form-group"><label> &nbsp;ToDate:</label> <input id="profitTo" type="" class="form-control datepicker"/></div>' +
                                    '<div class="form-group">&nbsp; <input type="button" class="btn btn-primary" id="filterProfitsRange" value="Filter"/></div>' +
                        '</form>' +

                    '<table class="table table-bordered" id="profits_by_license">' +
                    '<thead>' +
                    '<tr><th>LICENSE</th><th>PROFIT</th><th>PERIOD</th></tr>' +
                    '</thead>' +
                    '<tbody></tbody>' +
                    '</table>' +
                '</div>' +
            '</div>');



        $('#filterProfitsRange').click(function() {
            var profitFrom = $('#profitFrom').val();
            var profitTo = $('#profitTo').val();

            if(!profitFrom || !profitTo) {
                alert("Please specify dates");
                return false;
            }


            API.call("financial.profits",'getProfitsByLicense',{from:profitFrom,to:profitTo},function(response) {
                if(response.data.length) {


                    var data = response.data;
                    var html = '';
                    for(var i in data) {
                        var licensee = data[i];
                        html+='<tr><td>'+licensee['License']+'</td><td>'+licensee['profit']+'</td><td>'+response['period']+'</td></tr>';
                    }


                    $('#profits_by_license tbody').html(html)
                } else {
                    $('#profits_by_license').html('<h3 style="padding:20px;">Transactions were not found in this period</h3>');
                }
                console.log(response);
            });

            console.log(profitFrom,profitTo);

        });

        API.call("financial.profits",'getProfitsByLicense',{from:'',to:''},function(response) {
            if(response.data.length) {


                var data = response.data;
                var html = '';
                for(var i in data) {
                    var licensee = data[i];
                    html+='<tr><td>'+licensee['License']+'</td><td>'+licensee['profit']+'</td><td>'+response['period']+'</td></tr>';
                }


                $('#profits_by_license tbody').html(html)
            } else {
                $('#profits_by_license').html('<h3>Profits were not found in this period</h3>');
            }
            console.log(response);
        });

        $('.datepicker').datepicker({ dateFormat: 'yy-mm-dd' });

    }




});//end {}

