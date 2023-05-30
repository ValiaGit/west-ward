App.model('sport',{

    fields: {

        "id": { type: 'number', column: true, editable: false, filter: true},
        "title": {  type: 'object',

                column: {

                    template: Model.kendo.lang.template,
                    editor: Model.kendo.lang.editor

                }//end column
        },
        "code": {  type: 'string', column: true },
        "status": {  type: 'Number',

            column: Model.kendo.select.init(
                {
                    field: 'status',
                    data: {0: 'Hidden', 1: 'Active'}
                },{
                    width: 100
                }
            )
        }

    }//end fields

});//end {}