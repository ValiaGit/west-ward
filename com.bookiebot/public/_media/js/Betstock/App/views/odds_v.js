/**
 * Odds View
 */
OddsView = {

    init: function(){
        var me = this;
        me.initListeners();
    },

    /**
     * returns html of back or lay bid
     * must be called as .call(odd) or .apply(odd)
     * @params type - 'back' || 'lay'
     * @returns {string}
     */
    getHighestOddBtn: function(type){

        var ExchangeRate = 1;
        var CurrencyHTMLCode = "";
        try {
            if(Util.Cookie.get("currency_id")) {
                var core_currencies_id = parseInt(Util.Cookie.get("currency_id"));
                if(Currencies.list_with_rates) {
                    ExchangeRate = Currencies.list_with_rates[core_currencies_id]['exchange_rate'];
                    CurrencyHTMLCode = Currencies.list[core_currencies_id]['icon'];
                }
            }
        }catch(e) {
            console.log(e);
        }


        var odd = this,
            cls = type=='back'?'btn-odd-green':'btn-odd-blue',
            price = odd[type]?odd[type].highest.price:'&nbsp;',
            value = price,
            amount = odd[type]?(ExchangeRate*odd[type].highest.amount).toFixed(2)+' '+CurrencyHTMLCode:'&nbsp;';

        var title = '';

        if(amount == '&nbsp;') {
            value = odd.ov;
            cls += ' br_tooltip';
            var valb = odd.ov;

            if(!valb || valb == "") {
                valb = "N/A";
            }
            var title = "The best quota offered by Betradar: "+valb;
        }




        return '<button ' +
                    'class="oddBtn btn '+cls+'" ' +

                    'data-type="'+type+'"' +
                    'data-id="'+odd.id+'"' +
                    'data-value="'+value+'" ' +

                    'title="'+title+'"' +
                    'id="'+(type=='back'?'BackOdd':'LayOdd')+odd.id+'"'+
                '>' +
                    price + '<br>'+amount +
                '</button>'


    },//end getOddBtn();


    getOddBtnByIndex: function(index, type){

        var odd = this,
            cls = type=='back'?'btn-odd-green':'btn-odd-blue',
            price = (odd[type] && odd[type].data[index])?odd[type].data[index].price:'&nbsp;',
            value = price,
            amount = (odd[type] && odd[type].data[index])?odd[type].data[index].amount+' &#8364;':'&nbsp;';

        var title = '';

        if(amount=='&nbsp;'){
            value = odd.ov;
            cls += ' br_tooltip';
            var odd_b = odd.ov;

            if(!odd_b || odd_b == "") {
                odd_b = "N/A";
            }
            var title = "The best quota offered by Betradar: "+odd_b;
        }

        return '<button ' +
            'class="oddBtn btn '+cls+'" ' +

            'data-type="'+type+'"' +
            'data-id="'+odd.id+'" ' +
            'data-value="'+value+'" ' +

            'title="'+title+'"' +
            'id="'+(type=='back'?'BackOdd':'LayOdd')+odd.id+'"'+
            '>' +
            price + '<br>'+amount +
            '</button>'

    },//end getOddBtnByIndex();

    initListeners: function(){

        $('body').on('click','button.oddBtn',function(e){
            e.preventDefault();

            try {
                // shoot the laser!
                // sound.play('laser');
            }catch(e) {

            }


            var BetslipStore = App.getStore('betslip'),
                el = $(this),
                odd_id = el.data('id'),
                type = el.data('type'),
                value = el.data('value');

            //Toggle odd into betSlip
            BetslipStore.toggleOdd({
                id: odd_id,
                type: type,
                value: value
            });

        });

    },//end initListeners();


    /**
     * IF odd_type has "changeTeamNames" set true we need to return match pair names and 'Draw'
     */
    getOddName: function(odd){

        switch(odd.type){
            case 'regular':

                    var typeInfo = App.getStore('config').getTypeById(odd.type_id),
                        ret;

                    if(typeInfo.changeTeamName){

                        var match = App.getStore('matches').getItemById(odd.match_id);

                        ret = typeInfo.odds[odd.name_id].name
                            .replace('1',match.home)
                            .replace('2',match.away)
                            .replace('X',lang_arr.draw);

                    }else{
                        try {
                            ret = typeInfo.odds[odd.name_id].name;
                        }catch(e) {
                            ret = "";
                            console.log(e,odd.name_id,typeInfo);
                        }

                    }

                    return ret + ((odd.sb && odd.sb.length)?' ('+odd.sb+')':'');

                break;
            case 'outright':

                    return odd.name;

                break;
        }


    },//end getOddName();

    /**
     * Toggle odd selected class
     * @param id
     */
    toggleSelected: function(id){

        var selected = App.getStore('betslip').hasOdd(id);

        $('.oddBtn[data-id='+id+']').removeClass('selected');

        switch (selected){
            case 'both':
                $('.oddBtn[data-id='+id+']').addClass('selected');
            case 'back':
                $('.oddBtn[data-id='+id+'][data-type=\'back\']').addClass('selected');
                break;
            case 'lay':
                $('.oddBtn[data-id='+id+'][data-type=\'lay\']').addClass('selected');
                break;
        }



    }//end toggleSelected();


};//end {}