App.model('tournament',{

    fields: {

        "id": { type: 'number', column: true, editable: false, filter: true},
        "title": {  type: 'object',

            column: {

                template: Model.kendo.lang.template,
                editor: Model.kendo.lang.editor

            }//end column

        },

        "category_title": { type: 'string' },
        "betting_category_id": {
            type: 'number',
            column: {
                template: function(dataItem){
                    return dataItem.category_title;
                },
                editor: Model.kendo.select.editor({
                    url: API.getUrl('data.categories','getCategoriesListSelect')
                })
            }
        },
        "status":{type:"number",column: true,editable:true},
        "sport_title": { type: 'string' },
        "betting_sport_id": {
            type: 'number',
            column: {
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