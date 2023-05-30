var Filter = function(options){

    var me = this;

    me.fields = options.fields?options.fields:[];
    me.store = options.store?options.store:false;
    me.proxy = options.proxy?options.proxy:false;

    //console.log(options);

};

Filter.prototype.renderTo = function(to){
    var me = this;
    $(to).html(me.render());
}

Filter.prototype.render = function(){

    var me = this,
        fields = me.fields,
        html = '';

    //Open Tags
    html += '<div class="panel panel-default filter-container">' +
                '<div class="panel-heading">' +
                    '<h6 class="panel-title"><i class="icon-search3"></i> Filter</h6>' +
                '</div>'+
                '<div class="panel-body">' +
                    '<form class="filter-form" data-store="'+me.store+'" data-proxy="'+me.proxy+'">' +
                    '<div class="clearfix form-group">';


    for(var i in fields){

        if(!fields[i].filter) continue;

        var field = fields[i],
            options = field.filter!==true?field.filter:{},
            index = fields[i].mapping?fields[i].mapping: i,
            name = fields[i].name?fields[i].name:index,
            //Capitalize first letter of label name
            name = name.charAt(0).toUpperCase() + name.slice(1);
            index = 'filter['+index+']';



        var filter_type = (options.type)?options.type:field.type;
        var is_date_picker = (options.is_date_picker)?options.is_date_picker:false;
        var datePickerClass = "";
        if(is_date_picker) {
            datePickerClass = "datepicker";
        }


        html += '<div class="col-md-3 row">' +
                    '<div class="col-md-12 row"><label>'+name+':</label></div>';

        switch(filter_type){
            case 'number':

                html+=  '<div class="col-md-12 row">' +
                            '<input name="'+index+'" type="number" class="form-control ui-spinner-input '+datePickerClass+'" autocomplete="off">' +
                        '</div>';

                break;

            case 'range':
                html += '<div class="col-md-6 row">' +
                            '<input width="50%" name="'+index+'[range][from]" class="form-control '+datePickerClass+'"  placeholder="From">' +
                        '</div>' +
                        '<div class="col-md-6 row">' +
                            '<input name="'+index+'[range][to]" class="form-control '+datePickerClass+'" placeholder="To">' +
                        '</div>';
                break;

            default:
                html += '<div class="col-md-12 row">' +
                            '<input name="'+index+'" placeholder="'+(options.placeholder?options.placeholder:'')+'" class="form-control '+datePickerClass+'" type="text">' +
                        '</div>';

        }

        html += '</div>';



    }

    //add submit button
    html += '</div><div class="col-md-12 row form-actions">' +
                '<input type="submit" value="Submit" class="btn btn-primary">' +
            '</div>';

    //close tags
    html+=  '</form></div></div>';

    return html;

}

$(function(){

    $('body').on('submit','.filter-form', function(e){

        var storeName = $(this).data('store'),
            store = App.getStore(storeName),
            proxy = $(this).data('proxy');

        var filterQuery = $(this).serialize();

        if(!store) {
            var view = App.getView(storeName);
            view.init();
        }
        else {
            store.filterData({ query: filterQuery, proxy: proxy, resetData: true});
        }

        e.preventDefault();


    });
});