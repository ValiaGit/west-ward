/**
 * Match Model
 */
MatchesModel = {

    fields: {
        'id' :    {  type: 'int' },
        'home':   {  mapping: 'h' },
        'away':   {  mapping: 'a' },
        'sport':  {  mapping: 'sId' },
        'sport_code':  {  mapping: 'sCode' },
        'time':   {  mapping: 't' },
        'tournament_id': {  type: 'int', mapping: 'tId' },
        'status': {  type: 'case', values: {0: 'disabled', 1:'active',2:'inplay',3:'finished'}, mapping: 's'},
        'oddTypes': {
            mapping: 'odds',

            convert: function(raw,entry,key){
                //localize
                var me = MatchesModel,
                    i, j, raw_odds, odd,
                    oddModel = App.getModel('odds'),
                    oddStore = App.getStore('odds'),
                    types= {}; //to return

                for(i in raw){

                    //declare type object for match
                    types[i] = {
                        id: i,
                        matched: (raw[i].matched/100).toFixed(2),
                        status: raw[i].status,
                        odds: []
                    };

                    raw_odds = raw[i].odds;
                    for(j in raw_odds){

                        odd = raw_odds[j];

                        $.extend(odd, { type_id: i, match_id: entry.id });
                        odd = oddModel.new(odd,j,{type: 'regular'},oddStore);

                        types[i].odds.push(odd.id);
                    }

                };

                return types;
            }//end convert();

        }//end oddtypes;

    }

};//end {}