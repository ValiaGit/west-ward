/**
 * Sport Model
 */
SportModel = {

    fields: {
        'id' :      {   type: 'key' },
        'name':     {   mapping: 'n' },
        'code':     {   mapping: 'i' },
        'groups':   {   type: 'children', mapping: 'c', store:'categories', model: 'group' },
        'type':     {   type: 'static', value: 'sport'}
    }

};//end {}