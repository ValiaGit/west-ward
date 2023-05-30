/**
 * Betslip store
 */
'use strict';

var BetslipStore = {

    store: {
        back: {},
        lay: {},
        opened: {
            back: {},
            lay: {}
        },
        received: {
            back: {},
            lay: {}
        }
    },

    proxy: {
        placebet: {
            service: 'betting.betting',
            method: 'placeBet'
        },
        acceptbet: {
            service: 'betting.betting',
            method: 'acceptBet'
        },
        rejectbet: {
            service: 'betting.betting',
            method: 'rejectBet'
        }
    },

    listeners: {
        oddadded: 'betslip.betSlipChanged',
        oddremoved: 'betslip.betSlipChanged',
        oddchange: 'betslip.oddChanged',
        oddupdate: 'betslip.oddUpdated',
        placed: 'betslip.handleResponse',
        openedbets: 'betslip.view.renderOpenedBets',
        receivedbets: 'betslip.view.renderReceivedBets'
    },

    /**
     * Process placement
     * Send request to backend and handle response
     */
    placeBet: function(){

        //localize
        var me = App.getStore('betslip'), i,
            json = me.buildRequestJson(),
            proxy = me.proxy.placebet;

        Util.addLoader('#betslip-1');
        $.ajax({
            url: me.getServiceUrl(proxy.service,proxy.method),
            data:json,
            method:"POST",
            dataType:"json",
            xhrFields: {
                withCredentials: true
            },
            async:true
        })
            //Tu Data wamoigo
            .done(function(response) {
                Util.removeLoader('#betslip-1');
                me.trigger('placed',[response]);
            })
            //Tu Data ver wamoigo
            .fail(function(e) {
                Util.removeLoader('#betslip-1');
                console.log(e)
            });


    },//end placeBet();,

    /**
     * Accept bet
     * @param id
     * @param callback
     */
    acceptBet: function(form,callback){
        var me = this;


        var data = Util.Form.serialize($(form));



        callback = function(response){
            if(response.code == 10){

                Util.Popup.open({
                    content:"Bet Was Accepted Successfully!"
                });

                try {
                    me.removeReceivedBet(data.bet_id,data.bet_type);
                }catch(e) {
                    console.log(e);
                }

            }
            else {

                if(response.msg) {
                    Util.Popup.open({
                        content:response.msg
                    });
                }
                else {
                    Util.Popup.open({
                        content:"Bet can not be accepted"
                    });
                }

            }
        };

        var parameters = {
            bet_id: data.bet_id,
            event_id:data.event_id,
            liability_amount:data.amount,
            user_id:Util.Cookie.get("user_id")
        };


        me.requestData({
            proxy: 'acceptbet',
            params: parameters
        },callback);
    },//end acceptBet();

    /**
     * Reject bet
     * @param id
     * @param callback
     */
    rejectBet: function(id,type,callback){
        var me = this;

        var user_id = Util.Cookie.get('user_id');

        callback = function(response){
            if(response.code == 10){
                me.removeReceivedBet(id,type);
            }
        };

        me.requestData({proxy: 'rejectbet', params: {bet_id: id,user_id:Util.Cookie.get("user_id")}},callback);
    },//end rejectBet();

    /**
     * Buld JSON for ticket betting
     * @returns {{}}
     */
    buildRequestJson: function(){

        //localize
        var me = this, i,
            data = me.getData(),
            json = {
                odds: [],

                lang: API.lang,
                token: Util.Cookie.get("token"),
                user_id: Util.Cookie.get('user_id')

            };

        if(me.isEmpty()){
            console.error("BetSlip is empty. can't place ticket");
            return false;
        }

        //Walk through back bets
        for(i in data.back){

            var odd = data.back[i];

            var bet_receivers = [];
            if(odd.bet_receivers){
                bet_receivers = odd.bet_receivers.map(function(v){return v.id});
            }

            //Add odd object into request data
            var d = {
                bet_type: 2,
                bet_amount: odd.stake,
                bet_odd: odd.value,
                odd_id: odd.id,
                bet_receivers:bet_receivers,
                type: odd.odd_type == 'outright'?2:1
            };

            if(odd.odd_type == 'outright'){
                d.outright_id = odd.match_id;
            }else{
                d.match_id = odd.match_id;
            }
            json.odds.push(d);
        }

        //Walk through lay bets
        for(i in data.lay){

            var odd = data.lay[i];

            var bet_receivers = [];
            if(odd.bet_receivers){
                bet_receivers = odd.bet_receivers.map(function(v){return v.id});
            }
            //Add odd object into request data
            var d = {
                bet_type: 1,
                bet_amount: odd.stake,
                bet_odd: odd.value,
                odd_id: odd.id,
                bet_receivers:bet_receivers,
                type: odd.odd_type == 'outright'?2:1
            };

            if(odd.odd_type == 'outright'){
                d.outright_id = odd.match_id;
            }else{
                d.match_id = odd.match_id;
            }

            json.odds.push(d);
        }

        return json;

    },//end buildRequestJson();

    /**
     * Toggle Odd into betSlip
     * @param info
     */
    toggleOdd: function(info){

        var me = this,
            //odds into betSlip
            data = me.getData(),
            //if betslip already contains specified odd by id
            hasOdd = me.getOdd(info.id,info.type),

            oddInfo = me.getOddData(info);

            if(hasOdd){

                if(hasOdd.value == oddInfo.value && hasOdd.type == oddInfo.type){
                    //if ticket already contains odd by specified id

                    me.removeOdd(hasOdd.id,hasOdd.type);

                }else{
                    //different value's in ticket must be set to default

                    me.updateOdd(oddInfo);

                }//endif

            }else{

                //If ticket has no idea about specified odd :)
                me.addOdd(oddInfo);

            }//endif



    },//end toggleOdd();

    /**
     * Add odd into betSlip
     * @param info
     */
    addOdd: function(info){
        var me = this;

        me.store[info.type][info.id] = info;

        me.trigger('oddadded',[me.store[info.type][info.id],'add']);

        App.getView('odds').toggleSelected(info.id,true);

    },//end addOdd();

    /**
     * Update odd data into betSlip
     * @param info
     */
    updateOdd: function(info){

        //take odd from ticket
        var me = this;

        //Localize
        var me = this,
            //get odd, where change has been happened
            odd = me.getOdd(info.id, info.type);

        //change value
        odd.value = info.value;

        me.trigger('oddupdate',[odd]);


    },//end updateOdd();

    /**
     * Cancel one of received bets
     * @param id
     * @param type
     */
    cancelOdd: function(id, type){

    },//end cancelOdd();

    /**
     * Remove odd from betSlip
     * @param type
     * @param id
     */
    removeOdd: function(id,type){
        var me = this;
            delete me.store[type][id];

        me.trigger('oddremoved');

        App.getView('odds').toggleSelected(id,false);

    },//end removeOdd();

    /**
     * Clears betslip data
     */
    removeAll: function(){
        var me = App.getStore('betslip'),
            data = me.getData();

            data.back = {};
            data.lay = {};

        me.trigger('oddremoved');

    },//end removeAll();

    /**
     * Build odd object structured for ticket
     * @param info
     */
    getOddData: function(info){

        var me = this,
            oddId = info.id,
            oddInfo = App.getStore('odds').getItemById(oddId),
            controller = me.myController();

        switch(oddInfo.type){
            case 'regular':

                var matchInfo = App.getStore('matches').getItemById(oddInfo.match_id),
                    typeInfo = App.getStore('config').getTypeById(oddInfo.type_id),

                    pair = App.getStore('matches').getPair(matchInfo.id),
                    type_name = typeInfo.name,
                    odd_name = App.getView('odds').getOddName(oddInfo),
                    value = controller.checkOddVal(info.value*1,true);


                return {
                    id: info.id,
                    type_name: type_name,
                    odd_name: odd_name,
                    pair: pair,
                    match_id: matchInfo.id,

                    type: info.type,
                    value: value?value:1.01,
                    profit: 0,

                    odd_type: 'regular'
                };

                break;
            case 'outright':

                var outright_name = App.getStore('categories').getTournamentById(oddInfo.tournament).name;

                return {
                    id: info.id,
                    type_name: oddInfo.name,
                    odd_name: false,
                    pair: outright_name,

                    type: info.type,
                    value: value?value:1.01,
                    profit: 0,

                    odd_type: 'outright'
                };

                break;
        }


    },

    getOutrightOddData: function(info){

    },//end getOutrightOddData;

    /**
     * Set new odd value
     * @param val
     * @param id
     * @param type
     */
    changeOdd: function(val,id,type){

      //Check if user changes it inner html.
      if(['back','lay'].indexOf(type)==-1) console.error("Wrong odd type:",type);

      //Localize
      var me = this,
          controller = me.myController(),
          //get odd, where change has been happened
          odd = me.getOdd(id,type);

          //change value
          odd.value = +val;

            if(odd.type == 'lay') {
                odd.profit = +(odd.stake * odd.value - odd.stake).toFixed(2);
                $("#LayBet" + odd.id).find('.input-profit').val(odd.profit);
            }


          me.trigger('oddchange',[odd]);

    },//end changeOdd

    /**
     * Set new stake value
     * @param val
     * @param id
     * @param type
     */
    changeStake: function(val,id,type){

        //Check if user changes it inner html.
        if(['back','lay'].indexOf(type)==-1) console.error("Wrong odd type:",type);

        //Localize
        var me = this,
        //get odd, where change has been happened
            odd = me.getOdd(id,type);

        //change value
        odd.stake = +val;


        // if(odd.stake < Config.min_stake)
        //     odd.stake = Config.min_stake;

        me.trigger('oddchange',[odd]);

        return odd.stake;

    },//end changeStake();


    changeLiability: function(val,id,type) {


        //Check if user changes it inner html.
        if(['back','lay'].indexOf(type)==-1) console.error("Wrong odd type:",type);

        //Localize
        var me = this,
            //get odd, where change has been happened
            odd = me.getOdd(id,type);



        var oddValue = odd['value'];


        odd.stake = parseFloat((parseFloat(val) / (oddValue-1)).toFixed(2));
        odd.profit = val;

        console.log(odd);
        me.trigger('oddchange',[odd]);


        return odd.profit;


    },

    /**
     * Save user's opened bets from session to store
     * @param data
     */
    setOpenedBets: function(data) {

        if(!data) return;

        var me = this, item;
        for(var i in data){
            item  = data[i];

            var type = {2:'back', 1:'lay'}[item.bt];


            item= App.getModel('history').new(item);

            me.store.opened[item.type][item.id] = item;

        }

        me.trigger('openedbets');

    },//end setOpenedBets

    /**
     * Save user's received bets from session to store
     * @param data
     */
    setReceivedBets: function(data){

        var me = this, item;


        if(!data) return;
        for(var i in data){
            item  = data[i];
            var type = {2: 'back', 1: 'lay'}[item.bt];

            item= App.getModel('History').new(item);
            me.store.received[item.type][item.id] = item;

        }

        me.trigger('receivedbets');

    },//end setReceivedBets;

    /**
     * Remove opened bet by id and type
     * @param id
     * @param type
     */
    removeOpenedBet: function(id,type){
        var me = this;
        delete me.store.opened[type][id];

        me.trigger('openedbets');
    },//end removeOpenedBet;

    /**
     * Remove received bet by id and type
     * @param id
     * @param type
     */
    removeReceivedBet: function(id,type){

        console.log(id,type);
        return false;
        var me = this;
        delete me.store.received[type.toLowerCase()][id];

        me.trigger('receivedbets');

    },//end removeReceivedBet;

    /**
     * Returns odd in betslip by id and type:back|lay
     * @param id
     * @param type
     */
    getOdd: function(id,type){
        var me = this;
        return me.store[type][id]?me.store[type][id]:null;
    },//end getOdd;

    /**
     * Returns opened odd id and type:back|lay
     * @param id
     * @param type
     */
    getOpenedOdd: function(id,type){
        var me = this;
        return me.store.opened[type][id]?me.store.opened[type][id]:null;
    },//end getOdd;

    /**
     * Check if betSlip is empty
     * @returns {boolean}
     */
    isEmpty: function(){
        var me = this,
            data = me.getData();

        return !(Object.keys(data.back).length || Object.keys(data.lay).length);

    },//end isEmpty();

    /**
     * Check if betslip has specified odd in store
     * @param id
     * @returns {string}
     */
    hasOdd: function(id){
        var me = this,
            data = me.getData();
        if(data.back[id] && data.lay[id]) return 'both';
        if(data.back[id]) return 'back';
        if(data.lay[id]) return 'lay';
        return false;

    },//end hasOdd();

    /**
     * getData by type or without
     * @param type
     */
    getData: function(type){
        if(type)
        return this.store[type];
        return this.store;
    }

};//end {}