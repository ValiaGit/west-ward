var TransactionsClass = {
    viewDetails:function(transactionDetails) {

        try {
            var transaction_account_type = transactionDetails['account_account_type'];



            //Card
            if(transaction_account_type == 1) {



                var html = "<p><label>PaymentCard Mask</label>: "+transactionDetails['account_pan']+"</p>";
                Popup.open(html);
            }

            //Bank Account
            else {
                var html = "<p><label>BankName</label>: "+transactionDetails['account_bankname']+"</p>";
                html += "<p><label>BankCode</label>: "+transactionDetails['account_bankcode']+"</p>";
                html += "<p><label>BankAccount</label>: "+transactionDetails['account_bankaccount']+"</p>";
                html += "<p><label>Payee</label>: "+transactionDetails['account_payee']+"</p>";
                html += "<p><label>SwiftCode</label>: "+transactionDetails['account_swiftcode']+"</p>";
                Popup.open(html);
            }



        }catch(e) {

        }




    },
    markAsCompleted:function(transactionDetails) {

        if(transactionDetails.account_account_type != 2) {
            Popup.open("You can mark only 'WIRE TRANSFERS' as completed manually!");
            return false;
        }

        var transaction_id = transactionDetails['transactions__id'];

        var confirmmsg = confirm("Are you sure? Do you really want to mark this transaction as completed?");
        if(confirmmsg) {
            //API.call = function(service,method,params,callback,errorCallback,async,scope) {
            API.call("financial.transactions","updateTransactionAsCompleted",{transaction_id:transaction_id},function(response) {
                try {
                    Popup.open(response['msg']);
                }catch(e) {
                    Popup.open(e);
                }
            },function() {
                alert(1111);
            });
        }

    },

    markAsCanceled:function(transactionDetails) {

        if(transactionDetails.account_account_type != 2) {
            Popup.open("You can mark only 'WIRE TRANSFERS' as canceled manually!");
            return false;
        }

        var transaction_id = transactionDetails['transactions__id'];

        var confirmmsg = confirm("Are you sure? Do you really want to mark this transaction as canceled? Money will be returned on users account!");
        if(confirmmsg) {
            //API.call = function(service,method,params,callback,errorCallback,async,scope) {
            API.call("financial.transactions","cancelTransaction",{transaction_id:transaction_id},function(response) {
                try {
                    Popup.open(response['msg']);
                }catch(e) {
                    Popup.open(e);
                }
            },function() {
                alert(1111);
            });
        }

    }
};