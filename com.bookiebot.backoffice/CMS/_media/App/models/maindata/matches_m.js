App.model('matches',{

    fields: {

        "matches__id": {mapping: 'matches__id', type: 'number', column: {width: 100}, filter: true},
        "matches__BetradarMatchId": {mapping: 'matches__BetradarMatchId', column: true},
        "matches__BetFairEventId": {mapping: 'matches__BetFairEventId', column: true},
        "startTime": {
            mapping: 'matches_starttime', type: 'time', column: true,
            convert: function (value) {
                return moment(value, moment.ISO_8601).format("DD-MM-YYYY HH:mm");

            }
        },
        "home": {mapping: 'home', column: true},
        "competitors1_id": {mapping: 'competitors1_id', column: false, filter: true},


        "away": {mapping: 'away', column: true},
        "competitors2_id": {mapping: 'competitors2_id', column: false, filter: true},


        "Sport": {mapping: 'sTitle', column: true},
        "Category": {mapping: 'cTitle', column: true},
        "Tournament": {mapping: 'tTitle', column: true},
        "score": {mapping: 'matches_score_data', column: true}


    }//end fields

});//end {}

