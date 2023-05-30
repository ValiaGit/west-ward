/**
 * Tournament Model
 */
TournamentModel = {

    fields: {

        t: {
            'id' :      {   type: 'key' },
            'name':     {   mapping: 'n' },
            'popular':     {   mapping: 'f', type: 'bool' },
            'fav':     {   mapping: 'uf', type: 'bool' },
            'outright':  { mapping: 'o', type: 'bool' },
            'type':     {   type: 'static', value: 'tournament' }
        },

        //If tournament type is outright
        //add .odds into fields
        choose: function(entry){

            var fields = App.getModel('tournament').fields.t
            if(entry.o){
                fields.odds = { type: 'array' };
            }else{
                fields.matches = {type: 'array' };
            }
            return fields;

        }//end choose();
    }

};//end {}