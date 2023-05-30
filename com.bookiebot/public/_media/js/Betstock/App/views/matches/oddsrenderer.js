/**
 * Odds renderer object constructor
 * @param options
 * @return {OddsRenderer}
 */
function OddsRenderer(options){
    var me = this;

    //Required options

    if(options.type_id){
        var typeInfo = configStore = App.getStore('config').getTypeById(options.type_id);
        me.name = typeInfo.name;
    }
    if(options.name){
        me.name = options.name;
    }

    me.id = options.id;
    me.actions = options.actions?options.actions:[];
    me.listeners = options.listeners?options.listeners:false;
    me.matched = options.matched?options.matched:false;
    me.data = options.data?options.data:false;

    me.odds = options.odds;

    return me;
};


OddsRenderer.prototype.renderHeader = function() {

    //localize
    var me = this;

    //Open tags
    var html = '<div class="odds-header">' +
                '<div class="odds-header-inner">';


    if(me.actions.indexOf('collapse') != -1)
    html += '<a class="action trigger action-expand no-shadow" href="#">' +
                '<i class="icon-collapse"></i>' +
            '</a>';

    html += '<h3 class="odds-title trigger">' + me.name

    if(me.matched!==false)
    html +=  '<span style="float:right">Matched: &#8364; '+me.matched+'</span>';
    html += '</h3>';

    if(me.actions.indexOf('refresh')!=-1);
    html += '<a class="action"><i class="icon-refresh"></i></a>';

    //Closer tags
    html += '</div></div>';

    return html;
};//end renderHeader();

OddsRenderer.prototype.render = function(){

    //localize
    var me = this,
        i, odd, b, l, dataHtml = '',

        oddsStore   = App.getStore('odds'),
        oddsView    = App.getView('odds');


    if(me.data){
        for( i in me.data)
        dataHtml += ' data-'+i+'="'+me.data[i]+'"';
    }
    //Open container tag
    var html = '<div class="match-odds expanded" data-id="'+me.id+'" '+dataHtml+' id="OddsContainer'+me.id+'">';

    html += me.renderHeader();

    html += '<div class="odds-content panel-grid grid-match"><table class="table table-responsive"><tbody>';

    for(i in me.odds){

        odd = oddsStore.getItemById(me.odds[i]);


        html += '<tr><td><span class="match-link">{{name}}</span></td>'
                    .replace(/{{name}}/g, oddsView.getOddName(odd));

        for(b = 2; b>=0; b--){
            html += '<td class="odd back_odd">'
            html += oddsView.getOddBtnByIndex.call(odd,b,'back');
            html += '</td>'
        }

        for(l = 0; l<=2; l++){
            html += '<td class="odd lay_odd">'
            html += oddsView.getOddBtnByIndex.call(odd,l,'lay');
            html += '</td>'
        }

        html += '</tr>'

    }
    html += '</tbody></table></div>';

        //Close tags
    html += '</div>';//.match-dds .expanded
    me.html = $(html);

    if(me.listeners)
        me.addListeners();

    return me.html;

};

OddsRenderer.prototype.addListeners = function(){

    var me = this;

    for(var action in me.listeners){

        switch(action){
            case 'refresh':
                me.html.on('click','.icon-refresh', function(e){
                   me.listeners[action](e);
                });
                break;
        }
    }

}

//$(function() {
//    $('body').on('click','.icon-refresh', function(e){
//        Router.reload(); //TODO This must reload only one oddtype
//    });
//});
