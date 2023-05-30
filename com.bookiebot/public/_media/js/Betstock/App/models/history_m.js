/**
 * History Model
 */
HistoryModel = {

    fields: {

        id: {type: 'int'},
        event_id: {type: 'int'},
        event_status: {type: 'int'},
        stake: {mapping: 'ba'},
        odd: {mapping: 'bo'},
        unmatched: {mapping: 'ua'},
        sports_title: {mapping: 'sports_title'},
        starttime: {mapping: 'starttime'},
        sports_code: {mapping: 'sports_code'},
        category_title: {mapping: 'category_title'},


        profit_lose: {mapping: 'profit_lose'},
        deducted_commission: {mapping: "deducted_commission"},
        bet_liability: {mapping: "bet_liability"},
        returned_unmatched_amount: {mapping: "returned_unmatched_amount"},

        tournament_title: {mapping: 'tournament_title'},
        bet_type: {mapping: 'bt', type: 'case', values: {2: 'back', 1: 'lay'}},
        type: {mapping: 'bt', type: 'case', values: {2: 'back', 1: 'lay'}},//1 - Match; 2 - Outright; 3 - Superlive
        oddType: {
            mapping: 'otId', convert: function (val) {
                return App.getStore('config').getTypeById(val);
            }
        },
        time: {mapping: 't', type: 'time'},
        pair: {
            type: 'string',
            convert: function (val, entry) {

                switch (entry.tp) {
                    case "2":
                    case 2:
                        return entry.tournament_title;
                    default:
                        return entry.h + (entry.a ? ' - ' + entry.a : '')
                }

            }//end convert();
        },
        sc: {mapping: 'sc', type: 'string'},
        sp: {mapping: 'sp', type: 'string'},
        sender: {mapping: 'sender_name', type: 'string'},
        sent_to: {mapping: 'receivers_data'},
        sent_from: {mapping: 'senders_data'},
        canceled_bet_data: {mapping: 'canceled_bet_data'},
        is_private: {mapping: 'is_private',type: 'case', values: {0: 'public', 1: 'private'}},
        selection: {
            mapping: 'odn', type: 'string',
            convert: function (odd_name, entry) {

                //Return if we have odd name from db.
                //For example goal scorer name
                if (odd_name) return odd_name;
                //Otherwise we need to get it from config
                var typeInfo = App.getStore('config').getTypeById(entry.otId);
                var odd_name = typeInfo.odds ? typeInfo.odds[entry.oId].name : '';
                if (!typeInfo.changeTeamName) return odd_name;

                return odd_name.replace('1', entry.h)
                    .replace('2', entry.a)
                    .replace('X', lang_arr.draw);


            }//convert();
        },
        status: {
            mapping: 's',
            type: 'case',
            values: {
                0: 'Bet Made',
                1: 'Fully Matched',
                2: 'Partly Matched',
                3: 'Won',
                4: 'Lose',
                5: 'Canceled Received Money Back',
                6: 'Partly Canceled',
                7: 'Partly Canceled Lost',
                9: 'Partly Canceled Won',
                10: 'Not Matched Returned Money',
                11: 'Private Rejected',
                12: 'Private Accepted'
            }
        },

        real_status:{
            mapping: 's'
        },

        type_of_event: {
            mapping: 'tp',
            type: 'case',
            values: {
                1: 'prematch',
                2: 'outright',
                3: 'live'
            }
        }

    }//end fields

};//end {}