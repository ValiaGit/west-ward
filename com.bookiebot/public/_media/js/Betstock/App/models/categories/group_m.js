/**
 * Group Model
 */
GroupModel = {

    fields: {
        'id' :      {   type: 'key' },
        'name':     {   mapping: 'n' },
        'code':     {   mapping: 'i', convert: function(raw,entry,key){
            if(!raw) {
                return false;
            }
            if(raw == "po") {
                raw = "pl";
            }
            if(raw == "ws") {
                raw = "se";
            }
            if(raw == "de") {
                raw = "dk";
            }
            return raw.substring(0, raw.length-1).toLowerCase();
            return raw.toLowerCase();
        }},
        'tournaments':   {   type: 'children', mapping: 't', store:'categories', model: 'tournament' },
        'type':     {   type: 'static', value: 'group' }
    }

};//end {}