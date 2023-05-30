/**
 * Betslip View
 */
'use strict';

var BetslipView = {

    container: $("#BetSlip"),
    betslip: $("#betslip-1 > .panel-body"),
    backBetsContainer: $("#BackBets"),
    layBetsContainer: $("#LayBets"),

    html: {

        oddTpl: '<div class="ticket_wrapper" id="{{type_index}}{{id}}" data-id="{{id}}" data-type="{{type}}">' +
        '<div class="ticket_header row">' +
        '<div class="ticket_title col-md-10">{{pair}}</div>' +
        '<div class="ticket_buttons col-md-2">' +
        '<a href="#" class="select-friends-icon btn-icon"><i class="glyphicon glyphicon-user" data-count="{{receivers_count}}"></i></a>' +
        '<a href="#" class="btn-icon remove-icon"><i class="glyphicon glyphicon-remove"></i></a>' +
        '</div>' +
        '</div><!--end ticket_header -->' +


        '<div class="ticket_item row">' +

        '<div class="col-md-6 div-team text-hidden">' +
        '<em>{{type_name}}</em> <em>{{odd_name}}</em> ' +
        '</div>' +
        '<div class="col-md-2 betslip-spinner-col">' +
        '<div class="betslip-spinner">' +
        '<input type="text" class="input-bs input-xs input-odd" value="{{value}}" />' +
        '<span class="num-btn up">&nbsp;</span>' +
        '<span class="num-btn down">&nbsp;</span>' +
        '</div>' +
        '</div>' +
        '<div class="col-md-2 betslip-stake-col">' +
        '<input type="text" class="input-bs input-stake" value="{{stake}}" />' +
        '</div>' +
        '<div class="col-bs col-md-2 profit">' +
        '{{profit}}' +
        // '<input type="text" class="input-bs input-stake" value="{{stake}}" />' +
        '</div>' +
        '</div>' +
        '</div>',

        oddTplLay: '<div class="ticket_wrapper" id="{{type_index}}{{id}}" data-id="{{id}}" data-type="{{type}}">' +
        '<div class="ticket_header row">' +
        '<div class="ticket_title col-md-10">{{pair}}</div>' +
        '<div class="ticket_buttons col-md-2">' +
        '<a href="#" class="select-friends-icon btn-icon"><i class="glyphicon glyphicon-user" data-count="{{receivers_count}}"></i></a>' +
        '<a href="#" class="btn-icon remove-icon"><i class="glyphicon glyphicon-remove"></i></a>' +
        '</div>' +
        '</div><!--end ticket_header -->' +


        '<div class="ticket_item row">' +

        '<div class="col-md-6 div-team text-hidden">' +
        '<em>{{type_name}}</em> <em>{{odd_name}}</em> ' +
        '</div>' +
        '<div class="col-md-2 betslip-spinner-col">' +
        '<div class="betslip-spinner">' +
        '<input type="text" class="input-bs input-xs input-odd" value="{{value}}" />' +
        '<span class="num-btn up">&nbsp;</span>' +
        '<span class="num-btn down">&nbsp;</span>' +
        '</div>' +
        '</div>' +
        '<div class="col-md-2 betslip-stake-col">' +
        '<input type="text" class="input-bs input-stake" value="{{stake}}" />' +
        '</div>' +
        '<div class="col-bs col-md-2 profit">' +
        // '{{profit}}' +
        '<input type="text" class="input-bs input-profit profit" value="{{profit}}" />' +
        '</div>' +
        '</div>' +
        '</div>',

        openedOddTpl: '<div class="ticket_wrapper" id="BackBet{{id}}" data-id="{{id}}" data-type="{{type}}">' +
        '<div class="ticket_header row">' +
        '<div class="ticket_title col-md-11">{{pair}}</div>' +
        '<div class="ticket_buttons col-md-1">' +
        '<a href="#" class="btn-icon cancel-icon"><i class="glyphicon glyphicon-remove"></i></a>' +
        '</div>' +
        '</div>' +
        '<div class="ticket_item row">' +
        '<div class="col-md-6 div-team text-hidden">' +
        '<em>{{type_name}}</em>' +
        '<em>{{selection}}</em>' +
        '</div>' +
        '<div class="col-bs col-md-2 profit">{{odd}}</div>' +
        '<div class="col-bs col-md-2 profit">{{stake}}&#8364;</div>' +
        '<div class="col-bs col-md-2 profit">{{unmatched}}&#8364;</div>' +
        '</div>' +
        '<div class="ticket_item row text-right">' +

        '</div>' +
        '</div>',

        receivedOddTpl: '<div class="ticket_wrapper" id="BackBet{{id}}" data-id="{{id}}" ' +
        'data-sport="{{sports_title}}" ' +
        'data-pair="{{pair}}" ' +
        'data-odd="{{odd}}" ' +
        'data-type="{{type}}" ' +
        'data-sport="{{sports_title}}" ' +
        'data-category="{{category_title}}" ' +
        'data-tournament="{{tournament_title}}" ' +
        'data-stake="{{stake}}" ' +
        'data-eventid="{{event_id}}" ' +
        'data-selection="{{selection}} {{sp}}" ' +
        'data-unmatched="{{unmatched}}" ' +
        'data-oddtype="{{oddtype}}">' +


        '<div class="ticket_header row">' +
        '<div class="ticket_title col-md-10">{{pair}}</div>' +
        '<div class="ticket_buttons col-md-2">' +
        '<a href="#" class="btn-icon accept-icon"><i class="glyphicon glyphicon-ok"></i></a>' +
        '<a href="#" class="btn-icon decline-icon"><i class="glyphicon glyphicon-remove"></i></a>' +
        '</div>' +
        '</div>' +
        '<div class="ticket_item row">' +
        '<div class="col-md-6 div-team text-hidden">' +
        '<em>{{oddtype}}</em>' +
        '<em>{{selection}} {{sp}}</em>' +
        '</div>' +


        '<div class="col-bs col-md-2 profit">{{odd}}</div>' +
        '<div class="col-bs col-md-2 profit">{{stake}}&#8364;</div>' +
        '<div class="col-bs col-md-2 profit">{{unmatched}}&#8364;</div>' +
        '</div>' +
        '<div class="ticket_item row"></div>' +
        '<div class="ticket_item row text-center" style="color: white">' +
        'Sender: {{sender}}' +
        '</div>' +
        '</div>'


    },

    currency: '&#8364;',


    /**
     * This function doesn't needs a comment
     * If u cant understand what Init means
     * GTFO
     */
    init: function () {

        var me = this;

        me.addListeners();

    },//end init();

    /**
     * Render empy Betslip
     */
    renderEmpty: function () {

        //localize
        var me = this;

        //Add back flip empty class
        //It will show placeholder automatically
        //Thanks to Landish
        me.betslip.removeClass('has-lay has-back').addClass('empty');
        me.betslip.find('#betlip_placeholder').show();

    },//end renderEmpty();

    /**
     * Rendering odds happens here
     */
    renderOdds: function () {

        //localize
        var me = this,
            store = me.myStore(),
            data = store.getData(),
            back_odds = data.back,
            lay_odds = data.lay,
            html = '',

            /**
             * Render back odds
             * @param odds
             * @returns {string}
             */
            back_bets_html = me.getOddsHtml(back_odds),

            /**
             * Render Lay odds
             * @param odds
             * @returns {string}
             */
            lay_bets_html = me.getOddsHtml(lay_odds);

        me.betslip.find('#betlip_placeholder').hide();

        if (back_bets_html) {
            me.betslip.addClass('has-back');
        } else {
            me.betslip.removeClass('has-back');
        }

        if (lay_bets_html) {
            me.betslip.addClass('has-lay');
        } else {
            me.betslip.removeClass('has-lay');
        }


        $("#BackBets").html(back_bets_html);
        $("#LayBets").html(lay_bets_html);

        $("#betslip-1-clicker").trigger('click');

        me.betslip.removeClass('empty');

    },//end renderOdds();

    /**
     * Updates odd value into html
     * @param odd
     */
    updateVal: function (odd) {

        var me = this,
            val = odd.value.toFixed(2);

        $("#" + (odd.type == 'back' ? 'BackBet' : 'LayBet') + odd.id).find('.input-odd').val(val);
    },

    /**
     * Updates stake into dom
     * @param odd
     */
    updateStake: function (odd) {

        var me = this, val = odd.value.toFixed(2);

        $("#" + (odd.type == 'back' ? 'BackBet' : 'LayBet') + odd.id).find('.input-stake').val(odd.stake);
        if(odd.type == 'lay') {
            //odd.profit = +(odd.stake * odd.value - odd.stake).toFixed(2);
            // $("#LayBet" + odd.id).find('.input-profit').val(odd.profit);
        }
    },

    /**
     * Update profit into dom
     * @param odd
     */
    updateProfit: function (odd) {

        var me = this , profit = odd.profit.toFixed(2);


        if(odd.type == 'back') {
            $("#" + (odd.type == 'back' ? 'BackBet' : 'LayBet') + odd.id).find('.profit').html(me.currency + profit);
        }
        else {
            $("#LayBet" + odd.id).find('.input-profit').val(profit);
        }


    },//end updateProfit();

    /**
     * Updates liability into html
     * @param val
     */
    updateLiability: function (val) {

        var me = this,
            liability = val.toFixed(2) + me.currency;

        $("#Liability").html(liability);

    },//end updateLiability();

    /**
     * Parse and show response after placement
     * @param success
     * @param error
     */
    showResponse: function (success, errors) {

        var me = this,
            item, type, odd,
            html = '',
            store = me.myStore(),
            tr_cls;

        //Success
        if (success.length) {

            html += '<table class="table">';
            html += '<thead><th>Pair</th><th>Type</th><th>Selection</th><th>Status</th></thead>';
            for (var i in success) {//loop success

                item = success[i];
                type = (item.type == 2) ? 'back' : 'lay',
                    odd = store.getOdd(item.id, type);


                tr_cls = {10: 'success', 11: 'success', 411: 'warning'}[item.matched.code];
                html += '<tbody>';
                html += '<tr class="' + tr_cls + '">';


                if (odd.odd_type == 'regular') {
                    html += '<td>' + odd.pair + '</td><td>' + odd.type_name + '</td><td>' + odd.odd_name + '</td>';
                } else {
                    html += '<td>' + odd.pair + '</td><td>Outright</td><td>' + odd.type_name + '</td>';
                }


                switch (item.matched.code) {
                    case 10:
                        html += '<td>Fully Matched</td>';
                        break;
                    case 11:
                        html += '<td>Partly Matched</td>';
                        break;
                    case 411:
                        html += '<td>Not Matched</td>';
                        break;
                }

                html += '</tr>'
                html += '</tbody>'


            }//end loop success
            html += '</table>'
        }//end if success

        if (errors.length) {
            for (var index in errors) {
                try {
                    var cur = errors[index];
                    html += cur['msg'] + "<br/>";
                } catch (e) {

                }
            }
        }

        Util.Popup.open({content: html});
    },//end showResponse();

    /**
     * Returns HTML of odds
     * @param odds
     * @returns {string}
     */
    getOddsHtml: function (odds) {

        //return false if odds are empty
        if (Object.keys(odds).length == 0) return false;

        //localize
        var me = this,
            html = '',
            o,
            odd,
            profit, stake, receivers_cnt = '';


        //build html
        for (o in odds) {
            odd = odds[o];
            profit = odd.profit.toFixed(2);
            stake = odd.stake ? odd.stake.toFixed(2) : '';

            receivers_cnt = '';
            if (odd.bet_receivers)
                receivers_cnt = odd.bet_receivers.length;
            receivers_cnt = receivers_cnt ? receivers_cnt : '';

            if(cur_lang == 'ja') {
                if(odd.type_name == 'Who Wins?') {
                    odd.type_name = 'どちらが勝つ？';
                }
            }

            if (odd.type == 'back') {

                html += me.html.oddTpl
                    .replace(/{{id}}/g, odd.id)
                    .replace(/{{pair}}/g, odd.pair)
                    .replace(/{{type}}/g, odd.type)
                    .replace(/{{type_index}}/g, odd.type == 'back' ? 'BackBet' : 'LayBet')
                    .replace(/{{type_name}}/g, odd.type_name)
                    .replace(/{{odd_name}}/g, odd.odd_name ? odd.odd_name : '')
                    .replace(/{{stake}}/g, stake)
                    .replace(/{{profit}}/g, profit)
                    .replace(/{{receivers_count}}/g, receivers_cnt)
                    .replace(/{{value}}/g, odd.value.toFixed(2));
            }
            else {

                html += me.html.oddTplLay
                    .replace(/{{id}}/g, odd.id)
                    .replace(/{{pair}}/g, odd.pair)
                    .replace(/{{type}}/g, odd.type)
                    .replace(/{{type_index}}/g, odd.type == 'back' ? 'BackBet' : 'LayBet')
                    .replace(/{{type_name}}/g, odd.type_name)
                    .replace(/{{odd_name}}/g, odd.odd_name ? odd.odd_name : '')
                    .replace(/{{stake}}/g, stake)
                    .replace(/{{profit}}/g, profit)
                    .replace(/{{receivers_count}}/g, receivers_cnt)
                    .replace(/{{value}}/g, odd.value.toFixed(2));
            }

        }
        return html;

    },//end getOddsHtml();

    /**
     * Returns odd tag reference
     * @param id
     * @param type
     */
    getOddEl: function (id, type) {
        return $("#" + (type == 'back' ? 'BackBet' : 'LayBet') + id);
    },//end getOddEl();

    /**
     * Show Error Message
     * @param msg
     * @param options
     */
    showError: function (msg, options) {

        $("#BetSlip").prepend('<div class="betslip-message error">' + msg + '</div>');

    },//end showError();

    /**
     * Opens friends dialog
     * Where user can select friends for private bet
     * Friend's ids will be attached to odd object
     * That's why we need odd_id and odd_type for identification in betslip
     * Here we go
     * @param bet_id
     * @param type
     */
    openFriendsDialog: function (bet_id, type) {

        var me = this;
        var odd = me.myStore().getOdd(bet_id, type),
            receivers_html = '';

        if (odd.bet_receivers && odd.bet_receivers.length) {

            for (var i in odd.bet_receivers) {
                receivers_html += me.parseTpl('<span class="data-item" data-id="{{id}}" style="font-size: 16px; margin-right:5px;">' +
                    '<span class="label label-default">' +
                    '{{name}}' +
                    '<span class="glyphicon glyphicon-remove"></span> ' +
                    '</span>' +
                    '</span>', odd.bet_receivers[i]);
            }
        }
        var content = $('<div>' +
            '<div class="form-group">' +
            '<span role="status" aria-live="polite" class="ui-helper-hidden-accessible">Use up and down arrow keys to navigate.</span>' +
            '<input type="text" class="form-control input-search ui-autocomplete-input ui-autocomplete-loading ui-corner-all" id="FriendsSearch" placeholder="Search Friends" autocomplete="off">' +
            '</div>' +
            '<div class="well" id="ChosenList">' +
            receivers_html +
            '</div>' +
            '</div>'
        );

        content.on('click', '.glyphicon-remove', function (e) {
            var id = $(this).closest('span.data-item').data('id');
            $(this).closest('span.data-item').remove();

            var index = -1;
            for (var i in odd.bet_receivers) {
                if (odd.bet_receivers[i].id == id) {
                    index = i;
                    break;
                }
            }
            if (index !== -1) {
                odd.bet_receivers.splice(index, 1);
            }

            me.setBetReceiversCount(odd);

        });

        $(content).find('#FriendsSearch').autocomplete({
            source: function (request, response) {

                var term = request.term;
                API.call("social.friends", "searchFriends", {term: term}, function (data) {

                    if (data.code == 10) {
                        var renderData = [];
                        var data = data.data;
                        for (var index in data) {
                            var current = data[index];
                            renderData.push({
                                id: current.id,
                                value: current.fullname,
                                label: current.fullname
                            });
                        }
                        response(renderData);
                    } else {

                    }

                });

            },
            minLength: 2,
            select: function (event, ui) {

                var item = ui.item;


                if (!odd.bet_receivers) odd.bet_receivers = [];

                $('#FriendsSearch').val("");

                if (odd.bet_receivers.indexOf(item.id) != -1) return false;

                odd.bet_receivers.push({id: item.id, name: item.value});

                var el = me.parseTpl('<span class="data-item" data-id="{{id}}" style="font-size: 16px; margin-right:5px;">' +
                    '<span class="label label-default">' +
                    '{{label}}' +
                    '<span class="glyphicon glyphicon-remove"></span> ' +
                    '</span>' +
                    '</span>', item);

                el = $(el);

                $('#ChosenList').append(el);

                me.setBetReceiversCount(odd);

                return false;

            },
            open: function () {
                $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
            },
            close: function () {
                $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
            }
        });

        Util.Popup.open({
            content: content,
            buttons: [
                {
                    text: 'Ok',
                    click: "5+5;"
                }
            ]
        });

    },

    /**
     *
     * @param bet_id
     * @param type
     */
    showSelectedFriends: function (bet_id, type) {

        var me = this;
        var odd = me.myStore().getOpenedOdd(bet_id, type),
            receivers_html = '';

        if (odd.sent_to && odd.sent_to.length) {

            for (var i in odd.sent_to) {
                receivers_html += me.parseTpl('<span class="data-item" data-id="{{receiver_id}}" style="font-size: 16px; margin-right:5px;">' +
                    '<span class="label label-default">' +
                    '{{full_name}}' +
                    '</span>' +
                    '</span>', odd.sent_to[i]);
            }
        }

        var content = $('<div>' +
            '<div class="well" id="ChosenList">' +
            receivers_html +
            '</div>' +
            '</div>'
        );


        Util.Popup.open({
            content: content,
            buttons: [
                {
                    text: 'Ok',
                    click: "5+5;"
                }
            ]
        });

    },


    /**
     * Show bet receivers count in dom html
     * @param odd
     */
    setBetReceiversCount: function (odd) {


        var me = this,
            el = me.getOddEl(odd.id, odd.type).find('.glyphicon-user');

        var count = odd.bet_receivers.length;

        //console.log(count);

        el.attr('data-count', (count ? count : ''));

    },//end setBetReceiversCount;

    /**
     * Renders opened bets if avaliable.
     * Otherwise shows placeholder
     * @returns {boolean}
     */
    renderOpenedBets: function () {

        var me = this,
            data = me.myStore().getData()['opened'],
            item,
            total = 0,
            el,
            container = $("#betslip-2");


        if (!Object.keys(data.back).length && !Object.keys(data.lay).length) {
            container.find('.betslip_lay').hide();
            container.find('.betslip_back').hide();
            container.find('.empty-placeholder').show();

            $("#opened_bets_num").html('');

            return false;
        }

        container.find('.empty-placeholder').hide();


        var types = ['back', 'lay'];

        for (var tp in types) {

            var wrapper = container.find('.betslip_' + types[tp] + ' .odds_holder');
            wrapper.html('');

            if (Object.keys(data[types[tp]]).length) {

                container.find('.betslip_' + types[tp]).show();

                for (var i in data[types[tp]]) {
                    item = data[types[tp]][i];

                    item.stake = (item.stake / 100).toFixed(2);
                    item.unmatched = (item.unmatched / 100).toFixed(2);

                    item.type_name = item.oddType.name;

                    el = $(me.parseTpl(me.html.openedOddTpl, item));

                    if (item.sent_to) {
                        el.find('.ticket_title').removeClass('col-md-11').addClass('col-md-10');
                        el.find('.ticket_buttons').removeClass('col-md-1').addClass('col-md-2').prepend(
                            '<a href="#" class="show-friends-icon btn-icon"><i class="glyphicon glyphicon-user" data-count="' + item.sent_to.length + '"></i></a>'
                        );

                    }

                    wrapper.append(el);
                    total++;
                }

            } else {

                container.find('.betslip_' + types[tp]).hide();

            }
        }//end for


        $("#opened_bets_num").html('(' + total + ')');


    },

    /**
     * Renders received bets if available.
     * Otherwise shows placeholder
     * @returns {boolean}
     */
    renderReceivedBets: function () {

        var me = this,
            data = me.myStore().getData()['received'],
            item,
            total = 0,
            container = $("#betslip-3");


        if (!Object.keys(data.back).length && !Object.keys(data.lay).length) {
            container.find('.betslip_lay').hide();
            container.find('.betslip_back').hide();
            container.find('.empty-placeholder').show();

            $("#received_bets_num").html('');

            return false;
        }

        container.find('.empty-placeholder').hide();

        var types = ['back', 'lay'];
        for (var tp in types) {

            var el = container.find('.betslip_' + types[tp] + ' .odds_holder');
            el.html('');

            if (Object.keys(data[types[tp]]).length) {

                container.find('.betslip_' + types[tp]).show();

                for (var i in data[types[tp]]) {
                    item = data[types[tp]][i];

                    item.stake = (item.stake / 100).trunc(2);
                    item.unmatched = (item.unmatched / 100).trunc(2);

                    item.oddtype = item.oddType.name;

                    //console.log(item);
                    el.append(me.parseTpl(me.html.receivedOddTpl, item));
                    total++;
                }


            }
            else {
                container.find('.betslip_' + types[tp]).hide();
            }

        }

        $("#received_bets_num").html('(' + total + ')');

    },

    /**
     * Add listeners to dom objects
     */
    addListeners: function () {

        //localize
        var me = this,
            controller = me.myController(),
            store = me.myStore();

        //Place Bet
        $('#PlaceBetBtn').click(store.placeBet);

        //Remove all bets
        $('#ClearBetSlipBtn').click(store.removeAll);


        //Filtering input
        me.container.on('change keyup', '.input-bs', UX.filterNumericInput);
        //Formatting value
        me.container.on('blur', '.input-bs', UX.correctNumericFormatting);


        //Up/down buttons
        me.container.on('click', '.num-btn.up', function (e) {


            try {
                //cashier_sound.play();
            }catch(e) {

            }


            var wrapper = $(this).parents('.ticket_wrapper'),
                id = wrapper.data('id'),
                type = wrapper.data('type'),
                input = wrapper.find('.input-odd');

            controller.increaseOdd(id, type);

            e.preventDefault();

        });

        //Up/Down buttons
        me.container.on('click', '.num-btn.down', function (e) {

            try {
                // cashier_sound.play();
            }catch(e) {

            }


            var wrapper = $(this).parents('.ticket_wrapper'),
                id = wrapper.data('id'),
                type = wrapper.data('type'),
                input = wrapper.find('.input-odd');

            controller.decreaseOdd(id, type);

            e.preventDefault();

        });


        //Change odd value
        me.container.on('change keyup', '.input-odd', function (e) {

            try {
                // cashier_sound.play();
            }catch(e) {

            }


            if (e.keyCode == 38) {
                $(this).nextAll('.num-btn.up').trigger('click');
                return false;
            }
            var wrapper = $(this).parents('.ticket_wrapper'),
                id = wrapper.data('id'),
                type = wrapper.data('type'),
                val = $(this).val();

            store.changeOdd(val, id, type);
        });

        //Remove button
        me.container.on('click', '.remove-icon', function (e) {

            var wrapper = $(this).parents('.ticket_wrapper'),
                id = wrapper.data('id'),
                type = wrapper.data('type');

            store.removeOdd(id, type);

            e.preventDefault();

        });

        //Cancel icon in opened bets
        me.container.on('click', '.cancel-icon', function (e) {

            var wrapper = $(this).parents('.ticket_wrapper'),
                id = wrapper.data('id'),
                type = wrapper.data('type');


            if (confirm('Are you sure you want to cancel this bet?')) {
                App.getStore('history').cancelBet(id, function () {
                    me.myStore().removeOpenedBet(id, type);
                    try {
                        Session.init();
                    } catch (e) {
                        console.log(e);
                    }
                });
            }

            e.preventDefault();

        });


        //Accept icon in received bets
        me.container.on('click', '.accept-icon', function (e) {

            var wrapper = $(this).parents('.ticket_wrapper'),
                id = wrapper.data('id'),
                type = wrapper.data('type'),
                stake = wrapper.data("stake"),
                selection = wrapper.data("selection"),
                unmatched = wrapper.data("unmatched"),
                oddtype = wrapper.data("oddtype"),

                sport = wrapper.data("sport"),
                category = wrapper.data("category"),
                tournament = wrapper.data("tournament"),
                event_id = wrapper.data("eventid"),

                pair = wrapper.data("pair"),
                odd = wrapper.data("odd");


            //Tu Gamogzavnili Iyo Back Chveni Aria Lay
            if (type == "back") {
                var MyBetType = "lay";
                var MyLiability = (unmatched * odd) - unmatched;
            }

            //Tu Gamogzavnili Iyo Lay Chveni Aris Back
            else {
                var MyBetType = "back";
                var MyLiability = unmatched;
            }

            Util.Popup.openForm({
                fields: [
                    {
                        label: "Sport",
                        text_field: sport,
                        type: "info_input"
                    },
                    {
                        label: "Category",
                        text_field: category,
                        type: "info_input"
                    },
                    {
                        label: "Tournament",
                        text_field: tournament,
                        type: "info_input"
                    },
                    {
                        label: "Event",
                        text_field: pair,
                        type: "info_input"
                    },
                    {
                        label: "Market",
                        text_field: oddtype,
                        type: "info_input"
                    },
                    {
                        label: "Selection",
                        text_field: selection,
                        type: "info_input"
                    },
                    {
                        label: "Odd",
                        text_field: odd,
                        type: "info_input"
                    },
                    {
                        label: "Your Bet Type",
                        text_field: MyBetType,
                        type: "info_input"
                    },
                    {
                        label: "Your Liability",
                        value: MyLiability.trunc(2),
                        name: "amount",
                        type: "text"
                    },
                    {
                        name: "bet_id",
                        type: "hidden",
                        value: id
                    },
                    {
                        name: "event_id",
                        type: "hidden",
                        value: event_id
                    },
                    {
                        name: "bet_type",
                        type: "hidden",
                        value: type
                    }
                ],
                onSubmit: "App.getStore('betslip').acceptBet",
                buttons: [
                    {
                        click: "submit",
                        text: "Accept Bet"
                    },
                    {
                        click: "close",
                        text: "Close"
                    }
                ]
            });


            e.preventDefault();

        });

        //Decline icon in received bets
        me.container.on('click', '.decline-icon', function (e) {

            var wrapper = $(this).parents('.ticket_wrapper'),
                id = wrapper.data('id'),
                type = wrapper.data('type');

            if (confirm('Are you sure you want to reject this bet?'))
                App.getStore('betslip').rejectBet(id, type);

            e.preventDefault();

        });

        //Open selected friends from opened bets
        me.container.on('click', '.show-friends-icon ', function (e) {

            var wrapper = $(this).parents('.ticket_wrapper'),
                id = wrapper.data('id'),
                type = wrapper.data('type');

            me.showSelectedFriends(id, type);

            e.preventDefault();

        });

        me.container.on('click', '.select-friends-icon ', function (e) {

            var wrapper = $(this).parents('.ticket_wrapper'),
                id = wrapper.data('id'),
                type = wrapper.data('type');

            me.openFriendsDialog(id, type);

            e.preventDefault();

        });

        //Change stake value
        me.container.on('change keyup', '.input-stake', function () {
            var wrapper = $(this).parents('.ticket_wrapper'),
                id = wrapper.data('id'),
                type = wrapper.data('type'),
                val = $(this).val();

            try {
                // cashier_sound.play();
            }catch(e) {

            }


            store.changeStake(val, id, type);




            try {
                var odd = App.getStore('betslip').getOdd(id,type);
                console.log(odd);
                $("#LayBet" + odd.id).find('.input-profit').val(odd.profit);
            }catch(e) {
                console.log(e);
            }

        });


        me.container.on('change keyup', '.input-profit', function () {

            try {
                // cashier_sound.play();
            }catch(e) {

            }


            var wrapper = $(this).parents('.ticket_wrapper'),
                id = wrapper.data('id'),
                type = wrapper.data('type'),
                val = $(this).val();

            store.changeLiability(val, id, type);

        });

        //Change stake value
        me.container.on('blur', '.input-stake', function () {
            var val = $(this).val();
            // if (+val < Config.min_stake) {
            //     //TODO Promt about stake change
            //     // $(this).val(Config.min_stake.toFixed(2));
            // }

        });

        //Change odd value
        me.container.on('blur', '.input-odd', function () {
            var wrapper = $(this).parents('.ticket_wrapper'),
                id = wrapper.data('id'),
                type = wrapper.data('type'),
                val = $(this).val();

            val = controller.checkOddVal(+val).toFixed(2);
            store.changeOdd(val, id, type);

            $(this).val(val);
        });

    }//end addListeners();

};//end {}