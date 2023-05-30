/**
 *
 1	EUR	1	1.00	978	EUR	2016-11-06 18:24:21
 2	USD	0	1.11	840	USD	2016-11-06 18:36:26
 3	GEL	0	2.71	981	GEL	2016-11-06 18:36:26
 4	RUB	0	71.85	643	RUB	2016-11-06 18:36:26
 5	GBP	0	1.00	826	GBP	2016-11-06 19:31:41
 6	AZN	0	1.00	944	AZN	2016-11-06 19:31:42
 7	CNY	0	1.00	156	CNY	2016-11-06 19:31:42
 8	UAH	0	1.00	980	UAH	2016-11-06 19:31:42
 9	JPY	0	1.00	392	JPY	2016-11-06 19:31:42
 10	KZT	0	1.00	398	KZT	2016-11-06 19:31:43
 11	SEK	0	1.00	752	SEK	2016-11-06 19:31:43
 12	TRY	0	1.00	949	TRY	2016-11-06 19:31:43
 13	AUD	0	1.00	036	AUD	2016-11-06 19:31:43
 14	AED	0	1.00	784	AED	2016-11-06 19:31:43
 15	AMD	0	1.00	051	AMD	2016-11-06 19:31:44
 16	PLN	0	1.00	985	PLN	2016-11-06 19:34:05
 */


var Currencies = {


    list:{
        1:{'code':978,'iso_name':'EUR','icon':'€','name':'Euro'}
        // 2:{'code':840,'iso_name':'USD','icon':'$','name':'US Dollar'},
        // 3:{'code':981,'iso_name':'GEL','icon':'ლ','name':'Georgian Lari'},
        // 4:{'code':643,'iso_name':'RUB','icon':'руб','name':'Russian Ruble'},
        // 5:{'code':826,'iso_name':'GBP','icon':'£','name':'Great Britain Pound'},
        // 6:{'code':944,'iso_name':'AZN','icon':'AZN','name':'Azer Manat'},
        // 7:{'code':156,'iso_name':'CNY','icon':'CNY','name':'Chinese Yuan'},
        // 8:{'code':980,'iso_name':'UAH','icon':'UAH','name':' Ukrainian Hryvnia'},
        // 9:{'code':392,'iso_name':'JPY','icon':'JPY','name':'Japanese Yen'}
    },

    list_with_rates:null,



    getList:function(callback) {

        if(!callback) callback = function(){};

        API.call("cashier.currencies","getList",{},function(response){
            if(response.code == 10) {
                Currencies.list_with_rates = response['data'];
                callback();
            } else {
                callback();
            }

        });
    },




    /**
     *
     * @param from - Currnecy Id
     * @param to - Currency Id
     * @param amount
     */
    exchange:function(from,to,amount,callback) {
        if(!callback) callback = function(){};
        API.call("cashier.currencies","exchange",{fromCurrency:from,toCurrency:to,amount:amount},function(response){
            if(response.code == 10) {
                callback(response['data']);
            } else {
                callback(response);
            }
        });
    }


};
