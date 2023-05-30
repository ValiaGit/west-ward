Number.prototype.trunc = function(digits) {
    var re = new RegExp("(\\d+\\.\\d{" + digits + "})(\\d)"),
        m = this.toString().match(re);
    m = m ? parseFloat(m[1]) : this.valueOf();
    return (+m).toFixed(digits);

}

App.view('dashboard',{

    init: function(){






        //Render Total Statistics
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: API.getUrl('general.statistics', 'getStatistics'),
            data: {
                to: moment().format('YYYY-MM-DD'),
                from: moment().subtract(10, 'days').format('YYYY-MM-DD'),
                by: 'DAYS'
            },
            success:function(response) {

                try {
                    if(response.hasOwnProperty('logout')) {
                        window.location.href = 'index.php';
                    }
                }catch(e) {

                }



                var data = response.total_data;
                for(var index in data) {
                    var value = data[index];
                    if(value == null)value=0;

                    console.log(index);

                    if(index == "users" || index.indexOf('count')!=-1) {
                        $('#'+index).find(".value").text(parseFloat(value).trunc(2));
                    } else {
                        $('#'+index).find(".value").text(parseFloat(value).trunc(2) +" €");
                    }

                }


                try {
                    if(response.hasOwnProperty('logout')) {
                        window.location.href = 'index.php?logout=true';
                    }
                }catch(e) {

                }

                $.ajax({
                    type: 'post',
                    dataType: 'json',
                    url: API.getUrl('financial.liabilities', 'getLiabilities'),
                    data: {
                    },
                    success:function(response) {

                        try {
                            $('#users_liabilities').find(".value").text(parseFloat(response.total).trunc(2) + " €");
                        }catch(e) {
                            console.log(e);
                        }

                    }


                });

            }


        });




    }
});