/**
 * Ticket Model
 */
OddsModel = {

    fields: {

        regular: {
            'id' : {  type: 'key' },
            'name_id' : {  type: 'int', mapping: 'id' },
            'type_id' : { },
            'match_id' : { },
            'sb': { },
            'ov': { },
            'back': {
                mapping: 'b',
                convert: function(raw){
                    return OddsModel.convertBackAndLayBids('back',raw);
                }//end convert();
             },
            'lay': {
                mapping: 'l',
                convert: function(raw){
                    return OddsModel.convertBackAndLayBids('lay',raw);
                }//end convert();
            },

            type: { type: 'static', value: 'regular' }
        },

        outright: {
            'id' : {  mapping: 'id', type: 'int' },
            'name': { type: 'string', mapping: 'n'},
            'priority': { type: 'int', mapping: 'p'},
            'icon' : {type: 'string', mapping: 'i'},
            'tournament': {type: 'int', convert: function(){
                return arguments[3].params.outright_id;
            }},
            'back': {
                mapping: 'b',
                convert: function(raw){
                    return OddsModel.convertBackAndLayBids('back',raw);
                }//end convert();
            },
            'lay': {
                mapping: 'l',
                convert: function(raw){
                    return OddsModel.convertBackAndLayBids('lay',raw);
                }//end convert();
            },

            type: { type: 'static', value: 'outright' }
        },

        choose: function(entry,key,options,store){
            var me = App.getModel('odds');
            if(!options) return me.fields.regular;
            switch(options.type){
                case 'outright':
                    return me.fields.outright;
                    break;
                default:
                    return me.fields.regular;
                    break;
            }

        }
    },

    convertBackAndLayBids: function(type,raw){

        //localize
        var info = {highest: false, data: []}, // to return;
            i;

        if(raw && raw.length){//if data exists

            for(i in raw){//loop it!

                info.data.push({
                    type: type, // back || lay
                    price: raw[i].price,
                    amount: raw[i].amount
                });

            }//end for;

            //sort data high to low
            switch(type){
                case 'back':
                    info.data.sort(function(a,b){
                        return b.price - a.price;
                    });
                    break;
                case 'lay':
                    info.data.sort(function(a,b){
                        return a.price - b.price;
                    });
                    break;
            }

            //save highest separated
            info.highest = info.data[0];

            return info;
        }
        return null;

    }//end convertBackAndLayBids();

};//end {}