/**
 * Model class
 * @type Object
 */
Model = {

    /**
     * Empty init method
     */
    init: function(){},

    /**
     * Create new instance of data
     * @param entry
     * @param key
     * @param options
     * @return item
     */
    new: function(entry, key, options, store){

        //Localize
        var me = this, f, indx, field, val, item = {}, raw,
            fields = me.fields;
        if(fields.choose){
            fields = fields.choose(entry,key,options,store);
        }

        for(f in fields){

            //Field info
            field = fields[f];

            //Mapping index
            indx = field.mapping ? field.mapping : f;

            //Raw data
            raw = entry[indx];


            switch(field.type){
                case 'key':
                    // ID must be taken from an object key of json element
                    val = key*1;
                    break;
                case 'number':
                    // ID must be taken from an object key of json element
                    val = raw*1;
                    break;
                case 'bool':
                    //Boolean type true||false
                    val = !!raw;
                    break;
                case 'case':
                    //When raw matches some predefined cases
                    val = field.values[raw];
                    break;
                case 'static':
                    //Static type
                    //must be specified in field
                    val = field.value;
                    break;
                case 'children':
                    //Data will be created with specified model rules
                    //Will be stored in specified store
                    //Data will hold parent attribute
                    //Current item (which one has "children" type field) will store an array with id's of new created data store
                    val = [];
                    var child;
                    for(var key in raw){//Loop data
                        child = App.getModel(field.model).new(raw[key],key,options,App.getStore(field.store));
                        val.push(child.id);
                        child.parent = item.id;
                    }
                    break;
                case 'array':
                    val = [];
                    break;
                case 'time':
                    //Convert ISO 8601 to date object
//                    val = new Date(Date.parse(raw));
                    val = raw;
                    break;
                default:
                    //Simply take value from json
                    val = raw;
                    break;
            }//end switch;

            if(field.convert){
                val = field.convert(val,entry,key,options,store);
            };

            item[f] = val;

        }//end for

        //If store exists in arguments
        //Request newItem method and pass already parsed item to it
        if(store) store.newItem(item,options);

        return item;

    },//end new();

    /**
     * Returns kendo columns
     */
    getKendoColumns: function(extend){
        var me = this, i,
            columns = [];


        for(i in me.fields){


            if(!me.fields[i].column) continue;

            var field = me.fields[i];

            var index = field .mapping?field.mapping: i,

                //Set title if exists, otherwise set index uppercased
                title = field.title?field.title:(i.charAt(0).toUpperCase() + i.slice(1)),
                //Create kendo column object
                template = field.template?field.template:false,
                filterable = field.filterable?field.filterable:null,
                filter = field.filter?field.filter:null,
                type = field.type?field.type:false,
                values = me.fields[i].values?me.fields[i].values:false;


           var toExtend = {title: title, field: index};



                if(template) {
                    toExtend['template'] = template;
                }


                if(filterable) {
                    toExtend['filterable'] = filterable;
                }

                if(filter && !filterable) {
                    toExtend['filterable'] = {
                        extra:false
                    };
                }

                if(!filter && !filterable) {
                    toExtend['filterable'] = false;
                }

                if(type) {
                    toExtend['type'] = type;
                }

                var column = $.extend(toExtend,((me.fields[i].column!==true)?me.fields[i].column:{}));

                columns.push(column);
        }


        try {
            if(me.commands) {
                for(k in me.commands) {
                    columns.push(me.commands[k]);
                }
            }

        } catch(e) {

        }






            if(extend)
        columns.push(extend);

        return columns;
    },//end getKendoColumns();


    /**
     * Returns kendo columns
     */
    getKendoModel: function(extend){
        var me = this, i,
            fields = {};


        for(i in me.fields){
            var index = me.fields[i].mapping?me.fields[i].mapping:i;
            fields[index] = $.extend({},me.fields[i]);
        }

        return fields;
    },//end getKendoColumns();

    kendo: {

        /**
         * Kendo model predefined functions for columns, that contain select tag in editor
         */
        select: {

            init: function(info,options){

                var me = Model.kendo.select;

                return $.extend(options,{
                    template: me.template(info),
                    editor: me.editor(info)
                });
            },

            template: function(info){

                return function(dataItem){
                    return info.data[dataItem[info.field]];
                }

            },

            editor: function(info){

                var dataSource = {};
                if(info.data){
                    var data_ = [];
                    for(var i in info.data){
                        data_.push({id: i, title: info.data[i]});
                    }

                    dataSource.data = data_;
                }

                if(info.url){

                    dataSource.transport = {
                        read: {
                            url: info.url,
                            dataType: "json"
                        }
                    }
                }

                return function(container,options){
                    var input = $('<input/>');
                    input.attr('name',options.field);
                    input.appendTo(container);

                    input.kendoDropDownList({

                        autoBind: false,
                        dataTextField: "title",
                        dataValueField: "id",
                        dataSource: dataSource

                    });
                }
            }
        },

        /**
         * Kendo Model predefined functuins for columns, that are language realted
         */
        lang: {
            /**
             * Template functuin for kendo ui model
             * @param dataItem
             */
            template: function(dataItem){

                data = {};

                if(dataItem)
                if(dataItem.hasOwnProperty("title"))
                try {
                    if(dataItem){
                        var data = JSON.parse(dataItem.title);
                    }
                    return data.BET?data.BET:'';
                }catch(e) {
                    console.log(dataItem.title);
                    console.log(e);
                }

                return "";



            },//end template();

            /**
             * Editing for for kendo ui model
             * @param dataItem
             */
            editor: function(container, options) {


                data = false;

                // create an input element
                if(options.model.title)
                var data = JSON.parse(options.model.title);

                var field = $('<div></div>');

                for(var i in Conf.langs){

                    var lang = Conf.langs[i];
                    var tag = $('<input />');

                    tag.attr('placeholder',lang)
                        .attr('data-lang',lang)
                        .attr('class','k-textbox k-input language-editor');

                    if(data)
                        tag.attr('value',data[lang]?data[lang]:'');

                    field.append(tag);
                    field.append($('<span class="label label-success">'+lang+'</span>').css({marginLeft:3, width:25, padding: '6px 3px', textAlign: 'center', textTransform: 'uppercase'}));
                    field.append('<br />');
                }

                var input = $('<input/>');
                input.attr('class','main-input')
                input.attr('style','display: none')
                input.attr('name',options.field);

                input.appendTo(field);

                // append it to the container
                field.appendTo(container);
                // initialize a Kendo UI AutoComplete

            }//end editor();

        }//end lang{};

    },//end kendo{};

    /**
     * Returns store of current controller
     */
    myStore: function(){
        return App.getStore(this.store?this.store:this.index);
    },//end myController();

    /**
     * Returns model of current controller
     */
    myView: function(){
        return App.getView(this.view?this.view:this.index);
    },//end myView;

    /**
     * Returns controller of current store
     */
    myController: function(){
        return App.getController(this.controller?this.controller:this.index);
    }//end myController();
};//end {}