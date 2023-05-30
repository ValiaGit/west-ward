var Transactions = {

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


        API.call("cashier.transactions","getTransactionsList",params,function(response) {
            if(response.code == 60) {
                $('#transactionsHistory tbody').html("<p style='padding:15px'>Transactions were not found!</p>");
                return false;
            }
            me.renderData(response);
        });
    },


    renderData:function(data) {
        var tbody = $('#transactionsHistory tbody');
        var html = "";
        var data = data.data;
        for(var index in data) {
            var current = data[index];


            var type = "";

            var status_class = "";

            if(current.type == 2) {
                type = lang_arr['withdraw'];
                current.amount = "-"+current.amount;
                status_class = "danger";
            }

            else {
                type = lang_arr['deposit'];
                status_class = "success";
            }


            if(current.transfer_type == 2) {
                current.pTitle = "(Wire Transfer)";
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
                case 10:
                    status = "Initialised";
                    break;
                case 1:
                    status = "Completed";
                    break;
                case 2:
                    status = "Rejected";
                    break;
                case 3:
                    status = "Failed Transaction";
                    break;
                case 4:
                    status = "Needs Revision";
                    break;
                case 5:
                    status = "Request accepted, Waiting Wire transfer";
                    break;
            }




            if(current.account_type == 1) {
                var pan = current.Pan?current.Pan:"Not Available";
            } else {
                var pan = current.BankAccount?current.BankAccount:"Not Available";
            }


            html +="<tr class='"+status_class+"'>" +
                "<td>"+current.dt+"</td>" +
                "<td>"+pan+"</td>" +
                "<td>"+current.pTitle+"</td>" +
                "<td>"+(current.amount/100).toFixed(2)+"</td>" +
                "<td>"+(current.commission/100).toFixed(2)+"</td>" +
                //"<td>"+(current.cut_amount/100).toFixed(2)+"</td>" +
                "<td>"+type+"</td>" +
                "<td>"+status+"</td>" +
                "</tr>";
        }
        tbody.html(html);
    }
};


$('#SubmitTransactionsSearch').click(function() {
    var from = $("#dpd1").val();
    var to = $("#dpd2").val();

    Transactions.getData(from,to);

});