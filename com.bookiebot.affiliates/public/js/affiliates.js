var affiliates = {

    renderEasyStats : function(lvl = false){
        var body = {
            lvl : lvl
        };

        $.post( "/user/easy_stats", body, function( data ) {
            if ( data.code == 10 ) {
                $('.min_stat_item #d').html( data.stats.d );
                $('.min_stat_item #m').html( data.stats.m );
                $('.min_stat_item #t').html( data.stats.t );
            }
        });
    },


    rendDashboardChilds : function(page=false){
        var body = {
            from_date : $('#from_date').val(),
            to_date : $('#to_date').val(),
            level : $('.min_stat_item #select_level').val(),
            page: page
        };

        var returnHtml = '';

        $.post( "/user/get_children", body, function( data ) {
            if ( data.code == 10 ) {
                $.each(data.childs, function( i, item ) {
                    if(item.country == 111 || item.country == "111") {
                        item.country = 'Japan';
                    }

                    //Affiliate Type
                    var affiliate_type = item['affiliate_type'];
                    var affiliate_type_name = "";
                    switch(affiliate_type) {
                        case 1:
                            affiliate_type_name = "Governing Partner";
                            break;
                        case 2:
                            affiliate_type_name = "Instructor";
                            break;
                        case 3:
                            affiliate_type_name = "Top Affiliate";
                            break;
                    }


                    returnHtml += '<tr><!--<th scope="row"><code>'+item.user_id+'</code></th>--><td>'+item.email+'</td><td>'+item.country+'</td><td>'+item.profit*1+'</td><td>'+data.level+'</td><td>'+affiliate_type_name+'</td></tr>';
                });

                $('tbody#childs').html(returnHtml);


                if ( data.total_pages > 1 ) {
                    var pagesHtml = '<ul class="pagination">';
                    var cur_class = '';

                    for ( var i=1; i <= data.total_pages; i++ ) {

                        if ( i == data.current_page ){
                            cur_class = 'class ="active"';
                        } else {
                            cur_class = '';
                        }

                        pagesHtml += '<li '+cur_class+' data-page="'+i+'"><a href="#">'+i+'</a></li>';
                    }

                    pagesHtml += '</ul>';

                    $('#pagination').html(pagesHtml);

                } else {
                    $('#pagination').html('');
                }


            }
        });
    },

    rendDashboardGraph : function(user_id = false){

        var from = $('#from_date').val();
        var to = $('#to_date').val();

        var body = {
            from_date : $('#from_date').val(),
            to_date : $('#to_date').val(),
            level : $('.min_stat_item #select_level').val(),
            user_id : user_id
        };

        if(cur_lang == 'ja') {
            var DiagramText = "利益ダイアグラム";
        }
        else {
            var DiagramText = "Profit Diagram";
        }

        $.post( "/user/get_chart", body, function( data ) {
            if ( data.code == 10 ) {


                if(data.graph.length) {
                    Highcharts.chart('graph_container', {
                        chart: {
                            type: 'line',
                            backgroundColor:'rgba(255, 255, 255, 0.1)'
                        },
                        title: {
                            // text: 'Diagram: Profit'+data.tit_lvl,
                            text: DiagramText,
                            style : {
                                color: '#0e5496',
                            },
                        },
                        xAxis: {
                            type: 'datetime',
                        },
                        yAxis: {
                            title: {
                                text: 'Profit in EUR'
                            }
                        },
                        plotOptions: {
                            line: {
                                dataLabels: {
                                    enabled: true
                                },
                                enableMouseTracking: true
                            }
                        },
                        tooltip: {
                            valueSuffix: ' €'
                        },
                        series: data.graph
                    });
                }
                else {
                    $('#graph_container').html("<h4 style='margin-top: 75px;text-align:center;'>Your children have not generated profits for you in period: "+from+"; "+to+"</h4>");
                }

            }
        });
    },

    searchUser : function(user_id) {

        var body = {
            user_id : user_id,
            from_date : $('#from_date').val(),
            to_date : $('#to_date').val()
        };

        console.log('class: '+user_id);

        $.post( "/user/search_user", body, function( data ) {
            var returnHtml = '';

            if ( data.code == 10 ) {
                returnHtml += '<tr><th scope="row"><code>'+data.user.user_id+'</code></th><td>'+data.user.email+'</td><td>'+data.user.country+'</td><td>'+data.user.profit*1+'</td><td>'+data.level+'</td></tr>';
                $('tbody#childs').html(returnHtml);
            }

        });
    },
}
