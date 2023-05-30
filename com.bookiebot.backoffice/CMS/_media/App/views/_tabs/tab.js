Tab = function(options){

    var me = this;

    me.id = 'Tab'+options.id;
    me.name = options.name;

    me.newTab();

    return me.getContainer();
};

Tab.prototype.getContainer = function(){

    var me = this;

    $('#TabsList a[href="#'+me.id+'"]').tab('show');

    return $("#TabsContent").find('#'+me.id);

};

Tab.prototype.newTab = function(){

    var me = this;

    if($('#TabsContent').find('#'+me.id).length) return;

    $("#TabsList").append('<li><a href="#'+me.id+'">'+me.name+'</a></li>');
    $("#TabsContent").append('<div class="panel-body tab-pane fade in" id="'+me.id+'"></div>');

}


$(function(){

    pageContent.on('click','#TabsList a',function (e) {
        $(this).tab('show');
        e.preventDefault();
    });

});
