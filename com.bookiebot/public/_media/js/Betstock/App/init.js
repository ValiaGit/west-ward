/**
 * Initialize Application class
 */
AppInit = function(){

    //Init controllers, models, stores, views
    App.initComponents();

    var bits = window.location.pathname.split('/').reverse();



    try{
        switch(whereami){
            case 'bookmakers':

                App.getStore('config').listeners.afterdataload = function(){

                    Currencies.getList(function() {
                        App.getView('odds').init();
                        App.getView('matches').init();
                        App.getStore('categories').init();
                        App.getController('betslip').init();
                        App.getView('betslip').init();

                        App.getController('matches').init();
                    });

                };

                App.getStore('config').init();


                break;
            case 'history':

                App.getStore('config').listeners.afterdataload = function(){

                    App.getStore('history').init();
                    App.getController('history').init();
                    App.getView('history').init();

                };

                App.getStore('config').init();

                break;
            case 'transactions':
                    App.getStore('transactions').init();
                    App.getController('transactions').init();
                    App.getView('transactions').init();
                break;

        }
    } catch(e) {
        //console.log(e);
    }

};