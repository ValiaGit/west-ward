App.model('category',{

    fields: {

        "id": { type: 'number', column: true, editable: false, filter: true},
        "title": {  type: 'object',

            column: {

                template: Model.kendo.lang.template,
                editor: Model.kendo.lang.editor

            }//end column

        },

        "sport_title": { type: 'string' },
        "betting_sport_id": {  type: 'number', column: {
                template: function(dataItem){
                    return dataItem.sport_title;
                },
                editor: Model.kendo.select.editor({
                    url: API.getUrl('data.sports','getSportsListSelect')
                })
            }
        }
//        "code": {  type: 'string', column: true }

    }//end fields

});//end {}