var History = {

    getData:function(from,to) {
        var me = this;
        var params = {
            user_id:Util.Cookie.get("user_id")
        };

        if(!from && !to) {

            params['from'] = moment().subtract(7, 'days').format("YYYY-MM-DD");
            params['to'] = moment().add(1,"days").format("YYYY-MM-DD");
        } else {
            params['from'] = from;
            params['to'] = to;
        }
        $("#dpd1").val(params['from']);
        $("#dpd2").val(params['to']);


        API.call("betting.history","getHistoryList",params,function(response) {
            if(response.code == 60) {
                $('#transactionsHistory tbody').html("<p style='padding:15px'>Transactions were not found!</p>");
                return false;
            }
            me.renderData(response);
        });
    },


    renderData:function(data) {
        var tbody = $('#bets_history_table tbody');
        var html = "";
        var data = data.data;
        for(var index in data) {
            var current = data[index];

            var pair = current.pair;
            var type_of_event = current.type_of_event;
            var sports_code = current.sports_code;
            var starttime = current.starttime;
            console.log(current);



        }
        tbody.html(html);
    }
};


$('#SubmitHistorySearch').click(function() {
    var from = $("#dpd1").val();
    var to = $("#dpd2").val();
    var type = $('').val();

    Transactions.getData(from,to);

});