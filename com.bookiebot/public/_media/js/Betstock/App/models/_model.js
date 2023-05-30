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
        var me = this, f, indx, field, val, item = { _raw: {}}, raw,
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
                case 'int':
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
            item._raw[f] = raw;

        }//end for

        //If store exists in arguments
        //Request newItem method and pass already parsed item to it
        if(store) store.newItem(item,options);

        return item;

    },//end new();

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