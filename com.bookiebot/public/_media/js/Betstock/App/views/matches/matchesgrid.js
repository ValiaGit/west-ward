/**
 * MatchesGrid constructor
 * @param options
 * @constructor
 */
MatchesGrid = function(options) {

    //Localize
    var me = this, match;

    //Save main features
    me.id = options.id;
    me.sport_id = options.sport_id;
    me.columns = options.columns;

    me.data = options.data ? options.data : false;

    //Matches
    me.hasAdditional = false;
    me.matches = [];
    //Transform matches as array

    for(var i in options.matches){

        match = App.getStore('matches').getItemById(options.matches[i]);
        me.matches.push(match);

        //noinspection JSUnfilteredForInLoop
        if(options.matches[i].total) me.hasAdditional = true;
    }
    //Sort matches
    me.matches.sort(function(a,b){ a = new Date(a.time).getTime(); b = new Date(b.time).getTime(); return a - b; });//end sort();

    //Get main odd type must be rendered
    me.mainOddType = App.getController('odds').getMainOddTypeBySportId(me.sport_id);
    //End Matches

    //  Header
    if(options.header){
        me.header = {};

        me.header.actions = options.header.actions ? options.header.actions : [];
        me.header.title = options.header.title ? options.header.title : false;

        me.collapsable = (me.header.actions.indexOf('minimize') != -1);

    }else{
        me.header = false;
        me.collapsable = false;
    }//end header;

    //  Listeners
    me.listeners = options.listeners ? options.listeners : {};



};// end constructor

/**
 * Renders grid to provided element
 * @param renderTo
 */
MatchesGrid.prototype.renderTo = function (renderTo) {

    var me = this;

        me.render();

    var renderTo = $(renderTo);

    if((renderTo).find('#'+me.id).length){
        renderTo.find('#'+me.id).replaceWith(me.html);
    }else{
        renderTo.prepend(me.html);
    }

    this.addListeners();

};//end renderTo();

/**
 * Adds event listeners to grid dom element actions
 */
MatchesGrid.prototype.addListeners = function () {

    var me = this;
    var el = me.html;

    //minimize
    el.find('.expandable-actions > .action-minimize > a, .expandable-header > h3').on('click',function(){
        el.find('.expandable-content').toggleClass('expanded');
        el.find('.expandable-actions > .action-minimize').toggleClass('minimized');
    });//end minimize

    //close
    el.find('.expandable-actions > .action-close > a').on('click',function(){
        if(me.listeners.close) me.listeners.close();
    });

    if(me.listeners.onrowclick){
        el.find('.match-link').on('click',function(e){
            e.preventDefault();
            var match_id = $(this).parents('tr').data('match');
            me.listeners.onrowclick(match_id,e);
        });
    }

};//end addListeners();

//noinspection JSUnusedGlobalSymbols
/**
 * adds a match to the grid store
 * @param match
 */
MatchesGrid.prototype.addMatch = function(match){

    var me = this, i=0,
        aT, gT = new Date(match.time).getTime();

    //Find index of the new match to add
    while(true){
        if(i == me.matches.length) { break; }
        aT = new Date(me.matches[i].time).getTime();
        if(gT <= aT) { break; }
        i++;
    }//index found <i>

    //Add to store
    me.matches.splice(i,0,match);

    //Add to dom
    if(i == 0){
        $('#'+me.id).find('tbody').prepend(me.getMatchRow(match));
    }else{
        $('#'+me.id).find('tbody > tr.empty:eq('+(i-1)+')').after(me.getMatchRow(match));
    }

};//end addMatch();

//noinspection JSUnusedGlobalSymbols
/**
 * adds a match to the grid store
 * @param id
 */
MatchesGrid.prototype.removeMatch = function(id){

    var me = this, i= 0, jqEl;

    //Find index of the new match to add
    for(i;i<me.matches.length;i++){
        if( id == me.matches[i].id) break;
    }//index found <i>

    //Add to store
    me.matches.splice(i,1);

    //Add to dom
    jqEl = $('#'+me.id);
    jqEl.find('tbody > tr.empty:eq('+(i)+')').remove();
    jqEl.find('tbody > tr.match:eq('+(i)+')').remove();

};//end addMatch();

/**
 * Renders grid
 */
MatchesGrid.prototype.render = function () {

    var me = this, html = '', grid = this, data = '', i;

    if(grid.data) // Build data tags for grid :3
        for(i in grid.data){
            //noinspection JSUnfilteredForInLoop
            data += ' data-'+i+'="'+grid.data[i]+'"';
        }//end data loop

    html += '<div class="panel panel-grid grid-top" id="'+grid.id+'" '+data+'>';

    //Build headline
    html += MatchesGrid.getHeader(grid.header);

    //CONTENT
    html += '<div class="panel-content leagues">';

    html += grid.getContent();

    html += '</div>'; //close .panel-content

    html += '</div>'; //close grid tag

    me.html = $(html);

};//end;


/**
 * build header HTML
 * @param header
 * @returns {string}
 */
MatchesGrid.getHeader = function(header){
    var html, i=0;

    if(!header) return ''; //return empty string if no title exists

    html = '<div class="panel-heading soccer">';

    /*    TITLE     */
    if(header.title){
        html += '<h2 class="grid-title">';

        //icon
        if(header.title.flag) html += '<span class="flag flag-'+header.title.flag.toLowerCase()+'"></span>';
        else
        if(header.title.sport) html += '<span class="icon-sport '+header.title.sport.toLowerCase()+'"></span>';
        //end icon

        //headline
        html += header.title.main;
        if(header.title.secondary) html += '<span> - '+header.title.secondary+'</span>';
        //end headline

        html += '</h2>';
        html += '<span class="pull-right tournament-close glyphicon glyphicon-remove close_tournament" title="Close" onclick="App.getController(\'matches\').initTopBets();"></span>';
        if($.cookie("user_id")) {
            html += '<span class="pull-right tournament-close glyphicon glyphicon-star fav_tournament" title="Add Favorite" onclick=""></span>';

        }
    }//end if_title

    /*    ACTIONS     */
    if(header.actions.length){
        html += '<ul class="expandable-actions">';
        for(i; i<header.actions.length; i++){
            switch(header.actions[i]){
                case 'minimize':

                    html += '<li class="action-minimize">' +
                        '    <a title="Hide" class="minimize" href="#">' +
                        '        <span class="icon icon-minus"><\/span>' +
                        '    <\/a>' +
                        '    <a class="maximize" href="#">' +
                        '        <span class="icon icon-plus"><\/span>' +
                        '    <\/a>' +
                        '<\/li>';//.action-minimize
                    break;

                case 'close':

                    html += '<li class="action-close">' +
                        '<a title="Close" href="#">' +
                        '<span class="icon icon-close"></span>' +
                        '</a>' +
                        '</li>';//.action-close
                    break;

            }//end switch
        }//end for

        html += '</ul>'; //.expandable-actions

    }//end if_actions

    html += '</div>'; //.panel-heading

    return html;

};//end getHeader();


/**
 * Gets table html by matches
 * @returns {string}
 */
MatchesGrid.prototype.getContent = function(){

    //Localize
    var c = 0, g=0,
        me = this;
    //Empty placeholder
    if(!Object.keys(me.matches).length){
        return '<div class="placeholder-medium"><span class="icon icon-info"></span><p>'+lang_arr._noMatches+' </p></div>';
    }

    //Build content
    var html = '<table class="table table-responsive">';

    html += '<thead>';

    /* TABLE HEAD */
    for(c; c<me.columns.length; c++){
        switch(me.columns[c]){
            case 'pairs':

                    html += '<th class="half">'+lang_arr['pair']+'</th>';
                break;
            case 'odds':
                var i,
                    odd; //odd name reference
                for(i in me.mainOddType.odds){ //loop odds in oddtype
                    odd = me.mainOddType.odds[i];
                    html += '<th class="text-center" colspan="2">'+ odd.name+'</th>';
                }//end loop
                break;
        }//end switch;
    }//end for;
    html += '</thead>';

    /* TABLE CONTENT */
    html += '<tbody>';

    for(g; g<me.matches.length; g++){
        html += me.getMatchRow(me.matches[g]);
    }//end for matches

    html += '</tbody>';


    html += '</table>';//.matches-table;


    return html;

};//end getContent();

MatchesGrid.prototype.getMatchRow = function(match){


    var html='', hash = [],
        c, me = this;

    for(c = 0; c<me.columns.length; c++){
        switch(me.columns[c]){
            case 'time':
                var time = me.isLive ? match.time : UX.format_date(match.time);
                html += '<td class="date">'+time+'</td>';
                break;
            case 'pairs':
                html += '<td class="match_name">' +
                        '<a class="match-link" href="#">'+match.home+ ' - '+ match.away +'</a>' +
                        '<span class="date">'+moment(match.time).format('dddd HH:mm')+'</span>'
                    '</td>';
                break;
            case 'odds':

                //Localize
                var mainOddType = me.mainOddType,
                    //Choose match odd type from match types data
                    matchType = match.oddTypes[mainOddType.id]?match.oddTypes[mainOddType.id]:false,
                    oddsStore = App.getStore('odds'),
                    oddsController = App.getController('odds'),
                    oddView = App.getView('odds'),
                    back, lay,
                    i, odd;


                //If match contains oddType data we need
                if(matchType){

                    //Loop match odds for a main type
                    for(i in matchType.odds){
                        odd = oddsStore.getItemById(matchType.odds[i]);

                        hash.push(odd);

                        //If we have back bid render it
                        html += '<td class="odd">'+OddsView.getHighestOddBtn.call(odd,'back')+'</td>';
                        html += '<td class="odd">'+OddsView.getHighestOddBtn.call(odd,'lay')+'</td>';

                    }//end loop odds;

                }//end if


                break;
        }//end switch;

    }//end for cols

    //hash = md5(match.id+JSON.stringify(hash));

//    console.log(hash);

    html = '<tr id="MatchRow'+match.id+'" class="MatchRowTr" data-match="'+match.id+'" title="'+match.time+'" hash="'+hash+'">' +
                html +
            '</tr>';

    return html;

};//end getMatchRow();

/**
 * Destroy grid html element
 * if "afterdestroy" listener exists, runs it
 */
MatchesGrid.prototype.destroy = function(){

    //localize
    var me = this;

    //Remove element
    $("#"+me.id).remove();

    //Run after destroy event if exists
    if(me.listeners.afterdestroy){
        me.listeners.afterdestroy(me);
    }


};//end destroy();