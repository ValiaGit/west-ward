/**
 * Betslip controller
 * @type {{}}
 */
BetslipController = {

    step_ranges: [

        {   from: 1.01,     to: 2.00,       step: 0.01   },
        {   from: 2.00,     to: 3.00,       step: 0.02   },
        {   from: 3.00,     to: 4.00,       step: 0.05   },
        {   from: 4.00,     to: 6.00,       step: 0.10   },
        {   from: 6.00,     to: 10.00,      step: 0.20   },
        {   from: 10.00,    to: 20.00,      step: 0.50   },
        {   from: 20.00,    to: 30.00,      step: 1.00   },
        {   from: 30.00,    to: 50.00,      step: 2.00   },
        {   from: 50.00,    to: 100.00,     step: 5.00   },
        {   from: 100.00,   to: 1000.00,    step: 10.00  }

    ],

    init: function(){

        var me = this;
        me.myView().renderEmpty();

    },//end init()


    /**
     * Handle Response
     * @param response
     */
    handleResponse: function(response){

        var me = App.getController('betslip'),
            store = me.myStore(),
            view = me.myView(),
            i, item, type,
            success = response.success,
            errors = response.errors;

        //If User Need To Confirm Email To Make Bets
        if(response.code==-11) {
            Util.Popup.open({
                content:response.msg,
                buttons:[
                    {
                        text:lang_arr["resend_email_confirmation"],
                        click:"Settings.sendEmailVerification();return false;"
                    }
                ]
            });
            return false;
        }


        if(response.code==40) {
            Util.Popup.open({
                content:lang_arr['please_login_to_make_bets']
            });
            return false;
        }


        if(response.code==-75) {
            Util.Popup.open({
                content:response['msg']+"<br/> Timeout expires on: "+response['expires']
            });
            return false;
        }

        if(response.code==-85) {
            Util.Popup.open({
                content:response['msg']
            });
            return false;
        }


        //First show message
        //Because we'll have no data at the end of this function in betslip store :)
        view.showResponse(success,errors);

        //Success || Placed odds
        if(success.length){
            for(i in success){
                item = success[i];
                type = (item.type==2)?'back':'lay';
                store.removeOdd(item.id,type);
            }

            Router.reload();
        }

        //Error || UnPlaced odds
        if(errors.length){
//            403 db fail
//            401 balance error
//            404 bad request
        }

        console.log(response);
        me.betSlipChanged();


        Session.init();
        


    },//end handleResponse();

    /**
     * Something was added or removed from BetSlip
     */
    betSlipChanged: function(){

        //localize
        var me = this,
            store = me.myStore(),
            view = me.myView();


        if(store.isEmpty()){
            //If betSlip is empty
            //Placeholder must be rendered
            view.renderEmpty();
        }else{
            //Otherwise we must render odds
            view.renderOdds();
        }//end if

    },//end betSlipChanged();

    /**
     * Something was changed into the odd
     * We must to count profit and liability
     * @param odd
     */
    oddChanged: function(odd) {

        //Localize
        var me = this,
            stake = odd.stake?odd.stake:0;



        if(odd.type == 'back') {

            //Count profit
            odd.profit = +(stake * odd.value - stake).toFixed(2);

            //Update view
            me.myView().updateProfit(odd);

        }

        else {

            //Count profit
            odd.profit = +(stake * odd.value - stake).toFixed(2);

            //Update view
            me.myView().updateStake(odd);

        }




        //Count new liability
        me.countLiability();

    },

    oddUpdated: function(odd){

        //Localize
        var me = this;

        me.oddChanged(odd);
        me.myView().updateVal(odd);

    },

    /**
     * Count liability and transfer into view :)
     */
    countLiability: function(){
        var me = this,
            store = me.myStore(),
            backBets = store.getData('back'),
            layBets = store.getData('lay'),
            liability = 0, i;

        //count stakes from back bets


        for(i in backBets){
            liability += backBets[i].stake?backBets[i].stake:0;

        }

        //count profits from lay bets
        for(i in layBets){
            liability += layBets[i].profit?layBets[i].profit:0;
        }

        //update view
        me.myView().updateLiability(liability);

    },//end countLiability();

    /**
     * Check odd value avaialability depending on ranges
     * @param val
     * @param ignoreError
     * @returns {number}
     */
    checkOddVal: function(val,ignoreError){

        var me = this,
            view = me.myView(),
            range = me.guessRange(val),
            step = +range.step,
            dif = Math.round(val*100)%Math.round(step*100)/100;

        if(val < range.from){
            return +range.from;
        }

        if(val > range.to){
            if(!ignoreError)
            view.showError('Too much odd');
            return +range.to
        }

        if(dif){
            if(!ignoreError)
            view.showError(lang_arr.betslip_m.stake_range['e'+range.to]);
            val -= dif;
        }

        return val;
    },//end checkOddVal();

    /**
     * Increase odd by one available step
     * @param id
     * @param type
     */
    increaseOdd: function(id,type){
        var me = App.getController('betslip'),
            view = me.myView(),
            store = me.myStore(),
            odd = store.getOdd(id,type),
            step = me.guessRange(odd.value).step,
            //Increase value

            value = odd.value + step;

            value = +(value<1000?value:1000).toFixed(2);

        //Set new value to odd;
        store.changeOdd(value,id,type);

        view.updateVal(odd);

    },//end increaseOdd();

    /**
     * Decrease odd by one available step
     * @param id
     * @param type
     */
    decreaseOdd: function(id,type){

        var me = App.getController('betslip'),
            view = me.myView(),
            store = me.myStore(),
            odd = store.getOdd(id,type),
            step = me.guessRange(odd.value-0.01).step,
            //Increase value
            value = +(odd.value - step);

            value = +(value>1.01?value:1.01).toFixed(2);

        //Set new value to odd;
        store.changeOdd(value,id,type);

        view.updateVal(odd);

    },//end decreaseOdd();

    guessRange: function(val){
        var me = this,
            ranges = me.step_ranges;

        //if odd  value between 1.01 and 1000
        for(var i in ranges){
            if (val<ranges[i].to) return ranges[i];
        }

        //if odd is more than 1000
        return ranges[ranges.length-1];

    }

};//end {}