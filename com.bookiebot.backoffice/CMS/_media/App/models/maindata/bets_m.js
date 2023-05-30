App.model('bets', {

    fields: {

        bets__id: {mapping: 'bets__id', title: "id", type: 'number', column: {width: 100}, filter: true},
        betradar_event_id: {mapping: 'betradar_event_id', title: "BetradarEvent", type: 'number', column: false},
        matches__id: {mapping: 'matches__id', title: "matchID", type: 'number', column: {width: 100}, filter: true},
        users__username: {mapping: 'users__username', filterable:true, title: "username", type: 'string', column: true},
        users_fullname: {mapping: 'users_fullname', type: 'string', column: false},
        users___id: {mapping: 'users__id', column: true, title: "userID", filter: true},
        bets_bet_amount: {
            mapping: 'bets_bet_amount', title: 'Bet amount',
            column: true,
            filterable:false,
            template: function (data) {
                try {
                    return parseFloat(data.bets_bet_amount/100).trunc(2) + " €";
                } catch (e) {
                    console.log(e);
                    return false;
                }
            }
        },
        balance_before_bet: {
            mapping: 'balance_before_bet', title: 'Balance Before Bet',
            column: true,
            filterable:false,
            template: function (data) {
                try {
                    return parseFloat(data.balance_before_bet/100).trunc(2) + " €";
                } catch (e) {
                    console.log(e);
                    return false;
                }
            }
        },

        balance_after_settlement: {
            mapping: 'balance_after_settlement', title: 'Balance After Sttlement',
            column: true,
            filterable:false,
            template: function (data) {
                try {
                    if(data.balance_after_settlement) {
                        return parseFloat(data.balance_after_settlement/100).trunc(2) + " €";
                    } else {
                        return "N/A";
                    }

                } catch (e) {
                    console.log(e);
                    return false;
                }
            }
        },




        bets_unmatched_amount: {
            mapping: 'bets_unmatched_amount',filterable:false, title: "Unmatched", column: true,
            template: function (data) {
                try {
                    return parseFloat(data.bets_unmatched_amount/100).trunc(2) + " €";
                } catch (e) {
                    console.log(e);
                    return false;
                }

            }


        },


        bet_liability: {
            mapping: "bet_liability",
            title:"Liability",
            column: true,
            filterable:false,
            template: function (data) {
                return parseFloat(data.bet_liability/100).trunc(2) + "€";
            }
        },

        bets_bet_odd: {mapping: 'bets_bet_odd',title:"Odd", column: true, filterable:false},
        match__odds_id: {mapping: 'match__odds_id', filter: true},

        away: {mapping: 'away', type: 'string'},
        home: {mapping: 'home', type: 'string'},

        bets_bet_receiver: {mapping: 'bets_bet_receiver', type: 'number'},
        bets__status: {
            title:"Status",
            filterable:true,
            mapping: 'bets__status', type: 'string',
            template: function (data) {
                var values = {
                    0: 'Bet Made',
                    1: 'Fully Matched',
                    2: 'Partly Matched',
                    3: 'Won',
                    4: 'Lose',
                    5: 'Canceled Received Money Back',
                    6: 'Partly Canceled',
                    7: 'Partly Canceled Lost',
                    9: 'Partly Canceled Won',
                    10: 'Not Matched Returned Money'
                };

                if (values.hasOwnProperty(parseInt(data['bets__status']))) {
                    return values[parseInt(data['bets__status'])]+" ("+parseInt(data['bets__status'])+")";
                }
            },
            column: {width: 100}
        },

        is_private: {
            filterable:true,
            mapping: 'is_private', title:"Scope", column: true, type: 'string',
            template: function (data) {
                var values = {
                    0: "Public (0)",
                    1: "Private (1)"
                };

                if (values.hasOwnProperty(parseInt(data['is_private']))) {
                    return values[parseInt(data['is_private'])];
                }

            }

        },

        matches_status: {
            mapping: 'event_status', type: 'case',
            template: function (data) {
                var values = {
                    0: 'Disabled',
                    1: 'Active',
                    2: 'Finished',
                    3: 'In Play'
                };

                if (values.hasOwnProperty(parseInt(data['event_status']))) {
                    return values[parseInt(data['event_status'])];
                }

            }
        },

        score_data: {mapping: 'score_data'},
        type_title: {mapping: 'type_title'},
        odd_title: {
            mapping: 'odd_title', convert: function (val) {
                console.log(arguments);
                return val;
            }
        },

        bets__bet_type: {
            column:true,
            filterable:true,
            title:"Type",
            mapping: 'bets__bet_type',
            template:function(data) {
                    switch(data['bets__bet_type']) {
                        case "1":
                        case 1:
                            return "Lay (1)";
                            break;
                        case "2":
                        case 2:
                            return "Back (2)";
                            break;
                    }
            }
        },


        bets__bets_date: {
            title:"Datetime",
            mapping: 'bets__bets_date',
            column: {width: 100},
            type:"date",
            filterable:{
                extra:true,
                operators: {
                    date: {
                        lt: "Is before",
                        gt: "Is after"
                    }
                }
            },
            template:"#= kendo.toString(kendo.parseDate(bets__bets_date, 'yyyy-MM-dd'), 'dd/MM/yyyy HH:mm:ss') #",

            //template: function(row) {
            //    //console.log(row['bets__bets_date']);
            //    //return row['bets__bets_date'];
            //    //return false;
            //    //return row['bets__bets_date'];
            //    return moment(row['bets__bets_date']).format('DD/MM/YYYY HH:mm:ss');
            //}

        },




        profit_lose: {
            mapping: "profit_lose",
            title:"Profit/Lost",
            column: true,
            filterable:false,
            template: function (data) {
                return parseFloat(data.profit_lose/100).trunc(2) + "€";
            }
        },

        deducted_commission: {
            mapping: "deducted_commission",
            title:"Deducted Commission",
            column: true,
            filterable:false,
            template: function (data) {
                return parseFloat(data.deducted_commission/100).trunc(2) + "€";
            }
        },

        returned_unmatched_amount: {
            mapping: "returned_unmatched_amount",
            title:"Returned Unmatched Part",
            column: {width: 110},
            filterable:false,
            template: function (data) {
                return parseFloat(data.returned_unmatched_amount/100).trunc(2) + "€";
            }
        },


        odd_outcome: {mapping: 'odd_outcome', type: 'string'},
        odd_status: {
            mapping: 'mos', type: 'case',
            template: function (data) {
                var values = {
                    0: 'Disabled',
                    1: 'Open For Bets',
                    2: 'Lose',
                    3: 'Win'
                };

                if (values.hasOwnProperty(parseInt(data['mos']))) {
                    return values[parseInt(data['mos'])];
                }

            }
        },
        sports_title: {mapping: 'sports_title', type: 'string'},
        private_data: {mapping: 'private_data'},
        category_title: {mapping: 'category_title', type: 'string'},
        tournament_title: {mapping: 'tournament_title', type: 'string'},

        row_last_update:{
            title:"Update date",
            mapping: 'row_last_update',
            column: {width: 100},
            type:"date",
            filterable:false,
            template:"#= kendo.toString(kendo.parseDate(row_last_update, 'yyyy-MM-dd'), 'dd/MM/yyyy HH:mm:ss') #",
        }

    }//end fields

});//end {}