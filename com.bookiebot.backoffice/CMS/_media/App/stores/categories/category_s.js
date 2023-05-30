App.store('category',{

    dataSource: {

        transport: {

            read: {
                url: API.getUrl('data.categories','getCategoriesList'),
                dataType: 'json',
                type: 'POST',
                complete: function(jqXHR, textStatus) { }
            },

            update: {
                url: API.getUrl('data.categories','edit'),
                dataType: 'json',
                type: 'POST',
                complete: function(jqXHR, status) {
                    if(status == 'success'){
                        Util.showNotification('Update completed');
                    }
                }
            },

            

            create: {
                url: API.getUrl('data.categories','add'),
                dataType: 'json',
                type: 'POST',
                complete: function(jqXHR, status) {
                    if(status == 'success'){
                        Util.showNotification('Create Completed');
                    }
                }
            }

        },

        schema: {
            data: 'data',
            model: {
                id: 'id',
                fields: App.getModel('category').fields
            },
            errors: function (a){
                return a.code != 10;
            }
        },

        batch: false

    }//end dataSource

});