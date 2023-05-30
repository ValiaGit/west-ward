/**
 * Config Model
 */
ConfigModel = {

    fields: {
        'typeinfo' : {
            mapping: 'typeInfo',

            convert: function(raw){

                var info = {},
                    i=0, j, l, k;

                //loop typeInfo's
                for(j in raw){

                    //declare object
                    //noinspection JSUnfilteredForInLoop
                    info[j] = {
                        id: j,
                        name: raw[j].n,
                        priority: raw[j].pr,
                        changeTeamName: raw[j].tr,
                        odds: {}
                    };

                    k = 0; //odds priority

                    //loop odds
                    //noinspection JSUnfilteredForInLoop
                    for(l in raw[j].odds){

                        //noinspection JSUnfilteredForInLoop
                        info[j].odds[l] = {
                            name: raw[j].odds[l].n,
                            priority: k
                        };

                        k++;
                    }//end loop odds;

                    i++;
                }//end loop info's

                return info;

            }//end convert();

        },//end typeinfo;



        sports: {
            mapping: 'sports'
        }

    }//end fields;

};//end {}