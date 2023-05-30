var GameTransactions = {


    /**
     *
     * @param from
     * @param to
     */
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


        API.call("cashier.gametransactions","getTransactionsList",params,function(response) {
            if(response.code == 60) {
                $('#gameTransactionsHistory tbody').html("<p style='padding:15px'>Transactions were not found!</p>");
                return false;
            }
            me.renderData(response);
        });
    },

    /**
     *
     * @param data
     */
    renderData:function(data) {

        var tbody = $('#gameTransactionsHistory tbody');
        var html = "";
        var data = data.data;
        for(var index in data) {
            var current = data[index];


            var type = "";

            var status_class = "";


            var providerName = current['provider_name'];

            if(current.type == 1) {
                type = lang_arr['withdraw'];
                current.amount = "-"+current.amount;
                status_class = "danger";

                providerName = "Main Balance > "+providerName;

            }

            else if(current.type == 2) {
                type = lang_arr['deposit'];
                status_class = "success";

                providerName = providerName+" > Main Balance";
            }
            else if(current.type == 3) {
                type = lang_arr['deposit'];
                status_class = "success";
            }

            else if(current.type == 4) {
                type = lang_arr['withdraw'];
                current.amount = "-"+current.amount;
                status_class = "danger";

                providerName = providerName+" > Main Balance";
            }



            /**
             0 - Initialisation
             1 - Confirmation
             2 - Rejection
             3 - Filed Transaction
             4 - Needs Revision
             5 - Waiting Wire
             */
            var status = "";
            switch(current.status) {
                case 1:
                    status = "Completed";
                    break;
                case 0:
                    status = "Rejected";
                    break;
            }

            if(current.type == 3) {
                status+=' (Rollback)';
            }

            if(current.type == 4) {
                status+=' (Rollback)';
            }




            html +="<tr class='"+status_class+"'>" +
                "<td>"+current['transaction_time']+"</td>" +
                "<td>"+providerName+"</td>" +
                "<td>"+(current.amount/100).toFixed(2)+"</td>" +
                "<td>"+type+"</td>" +
                "<td>"+status+"</td>" +
                "<td>"+current['ip']+"</td>" +
                "</tr>";
        }

        tbody.html(html);


    }
};

/**
 *
 */
$('#SubmitGameTransactionsSearch').click(function() {
    var from = $("#dpd1").val();
    var to = $("#dpd2").val();

    GameTransactions.getData(from,to);

});