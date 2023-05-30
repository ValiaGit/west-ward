/**
 * Categories View
 */
HistoryView = {

    /**
     * You're dummy if u need comment for Init function
     */
    init: function(){
        var me = this;
        $("#SubmitHistorySearch").click(function(e){


            var from = $('#dpd1').val();
            var to = $("#dpd2").val();
            var bet_type = $('#bet_type').val();
            var bet_status = $('#bet_status').val();

            if(from&&to){
                from = moment(from,'MM/DD/YYYY').format('YYYY-MM-DD');
                to   = moment(to,'MM/DD/YYYY').format('YYYY-MM-DD');

                var params = {proxy: 'history', filter: {from: from, to: to, bet_type:bet_type, bet_status:bet_status}};


                Util.addLoader($('#bets_history_table'));


                me.myStore().store = {};
                me.myStore().requestData(params);
            } else {
                alert("Please specify dates!");
            }

            e.preventDefault();
        });
    },//end init();



    /**
     * Render grid for history data
     */
    renderData: function(){

        var me = this,
            data = me.myStore().getData();

        try {
            var proxy_params = me.myStore().proxy.history.params;
            var from = proxy_params['from'];
            var to = proxy_params['to'];
            if(from && to) {
                from = moment(from,'YYYY-MM-DD').format('MM/DD/YYYY');
                to   = moment(to,'YYYY-MM-DD').format('MM/DD/YYYY');

                $('#dpd1').val(from);
                $('#dpd2').val(to);
            }



        }catch(e) {
            console.log(e);
        }


        try {
            me.myStore().proxy.history.params = {user_id:Util.Cookie.get('user_id')};
        }catch(e) {

        }






        var grid = new Grid({

            renderTo: '#bets_history_table',//Todo

            cls: 'table table-custom',

            data: data,

            no_data_text:"No Data to Render",

            footer: '<tr>' +
                        '<td colspan="10" class="text-right large-space">' +
                            'All matched bets are displayed in aggregated format. Select a Bet ID for a detailed breakdown (for Matched unsettled bets only).' +
                        '</td>' +
                    '</tr>',

            columns: [
                {
                    title: 'Markets',
                    mapping: 'pair',
                    renderer: function(entry,row){

                        var market_title = "";

                        //If Prematch Get Data About oDD tyPE tITLE
                        if(row.type_of_event == "prematch") {
                            try {
                                var market_title = "<br/>"+row.oddType.name;
                            }catch(e) {
                                console.log(e);
                            }

                            var Tooltip = row.sports_title+" / "+row.category_title+" / "+row.tournament_title;

                        }



                        return '<i class="sport-'+row.sports_code+'"></i> <span class="tooltipchika" data-original-title="'+Tooltip+'">'+entry+'</span>'+market_title+"<br/>Event date: "+moment(row.starttime).format('HH:mm DD/MM/YYYY');
                    }
                },
                {
                    title: 'Type',
                    mapping: 'type',
                    renderer:function(entry,row) {

                        var description = row.bet_type=="lay"?"Against":"For";

                        entry = entry.substring(0,1).toLocaleUpperCase() + entry.substring(1);

                        return entry+"<br/>("+description+")";
                    }
                },
                {
                    title: 'Selection',
                    mapping: 'selection',
                    renderer: function(entry,row){
                        if(!row.sp || row.sp == "null") {
                            row.sp = "";
                        }
                        return entry + " " + row.sp;
                    }
                },
                {
                    title: 'Bet Id',
                    mapping: 'id'
                },
                {
                    title: 'Bet Placed',
                    mapping: 'time',
                    type: 'time',
                    format: "YYYY-MM-DD HH:mm:ss"
                },
                {
                    title: 'Odds Req.',
                    type: 'numfixed',
                    mapping: 'odd'
                },
                {
                    title: 'Your Liability (&#8364;)',
                    mapping: 'stake',
                    type: 'numfixed',
                    renderer: function(val,row){
                        return (parseFloat(row['bet_liability'])/100).toFixed(2);
                    }
                },
                {
                    title: 'Unmatched (&#8364;)',
                    mapping: 'unmatched',
                    type: 'numfixed',
                    renderer: function(val,row){
                        var returnVal = (val/100).toFixed(2);
                        if(row['returned_unmatched_amount']) {
                            if(row['returned_unmatched_amount']!='0.00') {
                                returnVal += '<br/><strong>Returned:</strong> '+(row['returned_unmatched_amount']/100).toFixed(2);
                            }
                        }
                        return returnVal;
                    }

                },
                {
                    title: 'Pos. Profit',
                    mapping: 'unmatched',
                    type: 'numfixed',
                    renderer: function(val,model){

                        var stake = model['stake'];
                        var odd = model['odd'];


                        if(model['type'] == 'lay') {
                            var possible_win = model['bet_liability']/(parseFloat(odd)-1);
                            return (possible_win/100).toFixed(2);

                        }

                        else {

                            var possible_win = (stake*odd) - stake;

                            return (possible_win/100).toFixed(2);
                        }

                    }

                },
                {
                    title: 'Status',
                    mapping: 'status',
                    renderer: function(val,model) {

                        if (model.hasOwnProperty("canceled_bet_data") && model['canceled_bet_data']) {
                            var canceled_bet_data = model['canceled_bet_data'];
                            var tooltip_text = "Returned money: "+(canceled_bet_data['returned_amount']/100)+"$; Cancel Time: " +canceled_bet_data['cancel_time'];
                            return '<span data-original-title="'+tooltip_text+'" class="tip" style="cursor: pointer">'+val+'</span>';
                        }

                        else {
                            return val;
                        }
                    }

                },
                {
                    title: 'Profit/Loss (&#8364;)',
                    mapping: 'profit_loss',
                    renderer:function(val,model) {

                        var stake = model['stake'];

                        console.log(model);

                        //Lost
                        if(model['real_status'] == 4) {
                            return (parseFloat(model['profit_lose']))/100+"<br>(Commission:"+model['deducted_commission']/100+")";
                        }

                        //Won
                        else if(model['real_status'] == 3) {
                            return (parseFloat(model['profit_lose']) - parseFloat(model['bet_liability']))/100+"<br>(Commission:"+model['deducted_commission']/100+")";
                        }


                        return (parseFloat(model['profit_lose']))/100+"<br>(Commission:"+model['deducted_commission']/100+")";


                    }
                },
                {
                    title: 'Private',
                    mapping: 'is_private',
                    renderer:function(val,model) {

                        if(model['is_private'] == "private" ) {
                            if(model['sent_to']) {
                                return '<button onclick="App.getView(\'history\').OpenBetReceiversPopup('+model.id+')" class="btn btn-primary btn-xs">Private</button>';
                            }
                            if(model['sent_from']) {
                                return '<button onclick="App.getView(\'history\').OpenBetSenderPopup('+model.id+')" class="btn btn-primary btn-xs">Private</button>';
                            }
                        }

                        return val;
                    }
                },
                {
                    title: 'Cancel',
                    mapping: '',
                    type: 'numfixed',
                    renderer: function(val,row){

                        //onclick="App.getView(\'history\').cancelBet('+model.id+',event)"
                        //If Bet Can Be Canceled
                        if(row._raw.status == "0" || row._raw.status == "2") {
                            return '<button onclick="App.getView(\'history\').cancelBet('+row.id+',Session.init)"' +
                            'class="btn history_cancel btn-danger btn-xs" ' +
                            'data-original-title="'+lang_arr['if_you_cancel']+' '+parseInt(row.unmatched)/100+'&#8364;">' +
                            'Cancel' +
                            '</button>';
                        } else {
                            return '';
                        }

                    }

                }

            ]

        }).render();




        $('button.history_cancel,.tip' ).tooltip();
        $('.tooltipchika').tooltip();
        $("#bets_history_table").removeClass('hidden');

    },//end renderData();

    OpenBetReceiversPopup:function(bet_id) {
        try {
            var popup_html = "";
            var receivers = App.getStore("history").store[bet_id].sent_to;
            if(receivers.length) {
                popup_html+='<div class="row">';

                    for(var index in receivers) {

                        var receiver = receivers[index];
                        var avatar = receiver['avatar'];
                        var receiver_id = receiver['receiver_id'];
                        var full_name = receiver['full_name'];

                        popup_html+='<div class="col-sm-6 col-md-4" id="bet_receiver_thumb_'+receiver_id+'_'+bet_id+'">';
                            popup_html+='<div class="thumbnail">';
                                popup_html+='<img height="120" style="height:120px" src="'+avatar+'" >';
                                popup_html+='<div class="caption">';
                                popup_html+='<h3>'+full_name+'</h3><br/>';
                                popup_html+='<p>' +
                                                '<a href="#" class="btn btn-danger btn-xs" onclick="App.getView(\'history\').cancelBetRequest('+receiver_id+','+bet_id+');return false;">' +
                                                'Cancel Bet Request' +
                                                '</a>' +
                                            '</p>';
                                popup_html+='</div>';
                            popup_html+='</div>';
                        popup_html+='</div>';

                    }
                popup_html+='</div>';
            }
            Util.Popup.open({
                title:"Bet Receivers",
                content:popup_html,
                noButton:true
            });
        }catch(e) {

        }

    },

    OpenBetSenderPopup:function(bet_id) {
        try {
            var popup_html = "";
            var Sender = App.getStore("history").store[bet_id].sent_from;
            console.log(Sender);
            Sender = Sender[0];

            var avatar = Sender['avatar'];
            var receiver_id = Sender['receiver_id'];
            var full_name = Sender['full_name'];

            popup_html+='<div class="col-sm-6 col-md-4" id="bet_receiver_thumb_'+receiver_id+'_'+bet_id+'">';
                popup_html+='<div class="thumbnail">';
                popup_html+='<img height="120" style="height:120px" src="'+avatar+'" />';
                            popup_html+='<div class="caption">';
                                popup_html+='<h3>'+full_name+'</h3><br/>';
                            popup_html+='</div>';
                popup_html+='</div>';
            popup_html+='</div>';

            Util.Popup.open({
                title:"Bet Sender",
                content:popup_html,
                noButton:true
            });
        }catch(e) {

        }

    },

    cancelBetRequest:function(receiver_id,bet_id) {
        API.call("betting.bets","deleteSentPrivateBetRequest",{receiver_user_id:receiver_id,bet_id:bet_id},function(response) {
            if(response.code == 10) {
                $('#bet_receiver_thumb_'+receiver_id+"_"+bet_id).fadeout();
            } else {
                if(response.msg) {
                    Util.Popup.open({
                        content:response.msg
                    });
                }
            }
        });
    },

    cancelBet: function(id,e){
        var store = App.getStore('history');
            store.cancelBet(~~id);
        e.preventDefault();
    }


};//end {}