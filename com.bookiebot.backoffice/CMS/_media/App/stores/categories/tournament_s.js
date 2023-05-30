App.store('tournament',{

    dataSource: {

        transport: {

            read: {
                url: API.getUrl('prematch.tournaments','getTournamentsList'),
                dataType: 'json',
                type: 'POST',
                complete: function(jqXHR, textStatus) { }
            },

            update: {
                url: API.getUrl('prematch.tournaments','edit'),
                dataType: 'json',
                type: 'POST',
                complete: function(jqXHR, status) {
                    if(status == 'success'){
                        Util.showNotification('Update completed');
                    }
                }
            },



            create: {
                url: API.getUrl('prematch.tournaments','add'),
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
                fields: App.getModel('tournament').fields
            },
            errors: function (a){
                return a.code != 10;
            }
        },

        batch: false

    }//end dataSource

});