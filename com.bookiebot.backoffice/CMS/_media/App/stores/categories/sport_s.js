App.store('sport',{

    dataSource: {

        transport: {

            read: {
                url: API.getUrl('data.sports','getSportsList'),
                dataType: 'json',
                type: 'POST',
                complete: function(jqXHR, textStatus) { console.log(textStatus, "read"); }
            },

            update: {
                url: API.getUrl('data.sports','edit'),
                dataType: 'json',
                type: 'POST',
                complete: function(jqXHR, status) {
                    if(status == 'success'){
                        Util.showNotification('Update completed');
                    }
                }
            },

            destroy:{
                url: API.getUrl('data.sports','delete'),
                dataType: 'json',
                type: 'POST',
                complete: function(jqXHR, status) {
                    if(status == 'success'){
                        Util.showNotification('Update completed');
                    }
                }
            },


            create: {
                url: API.getUrl('data.sports','add'),
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
                fields: App.getModel('sport').fields
            },
            errors: function (a){
                return a.code != 10;
            }
        },

        batch: false

    }//end dataSource

});