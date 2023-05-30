App.model('outrights',{

    fields: {

        "id": {mapping: 'matches_id', type: 'number', column: {width: 100}, filter: true},
        "BetradarMatchId": {mapping: 'matches_BetradarMatchId', column: true},
        "BetFairEventId": {mapping: 'matches_BetFairEventId', column: true},
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


//away: "Cirencester Town"
//cID: 1124
//cTitle: "England Amateur"
//competitors1_id: 25393
//competitors2_id: 25407
//home: "Poole Town"
//matches_BetFairEventId: 0
//matches_BetradarMatchId: 5758678
//matches_id: 255065
//matches_score_data: null
//matches_starttime: "2015-02-03T22:45:00Z"
//matches_status: 0
//sID: 336
//sTitle: "Soccer"
//tID: 3632
//tTitle: "Southern Football League, Premier Division"