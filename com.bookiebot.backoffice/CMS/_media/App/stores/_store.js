/**
 * Main class for all Stores
 * @type Object
 */
Store = {

    //Possible types
    //multi - when we have array in json structure
    //single - when json is a root of an object must be stored
    dataType: 'multi',

    listeners: {
//        beforedataload > options, scope
//        afterdataload  > data, options, scope
    },

    /**
     * Empty init method
     */
    init: function(){},

    /**
     * Gets data from the server and returns to callback
     * @param options
     * @param callback
     */
    requestData: function(options,callback){
        //consle.log("reset");
        this.resetData();

        //Localize
        var options  = options?options:{},
            me = this,
            proxy = options.proxy?me.proxy[options.proxy]:me.proxy,
            callback = callback ? callback : me.parse;

            //Merge params with proxy.params if available
            if(proxy.params) options.params = $.extend(options.params,proxy.params,options.filter?{filter:options.filter}:{});

        //If getData method is called exactly from Store class, it cant be executed
        //Due to we haven't any proxy details on it
        if(me == Store) { console.error('getData cant be called from Store class'); };

        //Launch listener about data load if it exists
        me.trigger('beforedataload',[me.getData(),options,me]);

        //Clear data if its needed
        if(options.resetData){
            me.resetData();
        }

        //Calls server for data
        //Service, Method, options for request, onSuccess method, onError method, async, scope
        me.call(proxy,options,callback,me.onRequestDataError,false,me);

    },//end getData();


    /**
     * Request data by filter
     * @param options
     */
    filterData: function(options){

        var me = this,
            query = options.query,
            proxy = options.proxy?options.proxy:false,
            resetData = options.resetData?options.resetData:false;

            me.requestData({proxy: proxy, resetData: resetData, query: query });

    },//end filterData();


    /**
     * Calls server for request data
     * @param proxy
     * @param options
     * @param callback
     * @param errorCallback
     * @param async
     * @param scope
     */
    call: function(proxy,options,callback,errorCallback,async,scope){

            var me = this;

            var params = options.params?options.params:{}


            params.lang = API.lang;
            params.hash = API.generateHash(proxy.service, proxy.method, params);

            if(!async == undefined) {
                async = true;
            }

            var url = me.getServiceUrl(proxy.service,proxy.method);

            if(options.query){
                params = options.query +'&'+ $.param(params);
            }

            $.ajax({
                url: url,
                data:params,
                method:"POST",
                dataType:"json",
                async:async
            })
                //Tu Data wamoigo
                .done(function(response) {

                    try {
                        if(response.hasOwnProperty('logout')) {
                            window.location.href = 'index.php';
                        }
                    }catch(e) {

                    }

                    if(callback && typeof (callback) === "function") {
                        callback(response,options,proxy,scope);
                    }
                })
                //Tu Data ver wamoigo
                .fail(function() {
                    if(errorCallback && typeof (errorCallback) === "function") {
                        errorCallback();
                    }
                });

    },//end call();

    /**
     * Build service url and return that
     * @param service
     * @param method
     * @returns {string}
     */
    getServiceUrl: function(service,method){
        return API.url+service+"/"+method+"";
    },//end getServiceUrl();

    /**
     * When error occurs while retrieving data from server
     */
    onRequestDataError: function(){
        console.error('Cant retrieve data from server');
    },//end onGetDataError();

    /**
     * Parses data retrieved from the server
     * by model rule, that is specified in store config
     * @param data
     * @param options
     * @param scope
     */
    parse: function(data,options,proxy,scope){

        //Localize
        var me=scope, _model = App.getModel(me.model),
            dataType = options.dataType?options.dataType:me.dataType,
            data = proxy.root?data[proxy.root]:data;


        switch(dataType){
            case 'multi':
                //Loop data got from server
                for(var key in data){
                    //Parse data item with model rules
                    _model.new(data[key],key,options,me);
                }//end for
                break;
            case 'single':
                _model.new(data,false,options,me);
                break;
        };


        //Inform controller about finishing loading store
        me.trigger('afterdataload',[me.getData(),options,scope]);

    },//end parse();

    /**
     * Clears all data from store
     */
    resetData: function(){

        var me = this;

            switch(Object.prototype.toString.call(me.store)){
                case '[object Object]':
                    me.store = {};
                    break;
                case '[object Array]':
                    me.store = [];
                    break;
            }


    },//end resetData();

    /**
     * Save new created instance in store
     * After model parses data and creates normalized object
     * It goes here.
     * @param item
     * @param options
     */
    newItem: function(item,options){

        var me = this,
            dataType = options.dataType?options.dataType:me.dataType;

        switch(dataType){
            case 'multi':

                switch(Object.prototype.toString.call(me.store)){
                    case '[object Object]':
                        me.store[item.id] = item;
                        break;
                    case '[object Array]':
                        me.store.push(item);
                        break;
                }

                break;
            case 'single':
                me.store = item;
                break;
        };

    },//end newItem();

    /**
     * Triggers event if it exists
     * @param e
     * @param args
     */
    trigger: function(e, args){

        //if listener exists
        if(this.listeners[e]){
            //localize listener
            var listener = this.listeners[e];

            //switch listener types
            switch(typeof listener){
                case 'function': //Lauch function if it exists
                    listener.apply(window, arguments);
                    break;
                case 'string': //Launch my controllers method
                    //localize
                    var splitted = listener.split('.'), c = App.getController(splitted[0]), f = c[splitted[1]];
                    //call to listener
                    f.apply(c,args);
                    break;
            };//end switch;
        }
    },//end trigger

    /**
     * Returns store if exists and false if store is empty
     * @return store
     */
    getData: function(){
        return Object.keys(this.store).length ? this.store:false;
    },//end getData();
    /**
     * Returns store item by id
     * @param item
     * @return {*}
     */
    getItemById: function(id){
       return this.store[id];
    },

    /**
     * Returns controller of current store
     */
    myController: function(){
        return App.getController(this.controller?this.controller:this.index);
    },//end myController();

    /**
     * Returns model of current store
     */
    myView: function(){
        return App.getView(this.view?this.view:this.index);
    },//end myView;

    /**
     * Returns model of current store
     */
    myModel: function(){
        return App.getModel(this.model?this.model:this.index);
    }//end myModel();

}; //end {}