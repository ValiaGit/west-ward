/**
 * Categories View
 */
MatchesView = {

    active_grid: false,

    container: $("#MiddleContainer"),

    /**
     * You're dummy if u need comment for Init function
     */
    init: function(){

        var me = this;
            me.addListeners();

    },//end init();

    /**
     * Renderes data in grid by tournament id
     * @param matches
     * @param tournament_id
     */
    renderTournamentContent: function(matches, tournament_id){
        //$('.home-slider').hide();
        $("#MiddleContainer").removeAttr('class').addClass('col-md-12 home-middle').html('<div id="odds-panel"></div>');

        var me = this,
            //Get data about league;
            cats = App.getStore('categories').getNestedByTournament(tournament_id),
            //Matches controller
            matchesStore = me.myStore();

        if(me.active_grid){
            me.active_grid.destroy();
        }

        if(!matches.length) {
            return false;
        }

        //Creating grid
        var grid = new MatchesGrid({
            id: 'TournamentGrid'+tournament_id,
            matches: matches,
            columns: ['pairs','odds'],
            sport_id: cats.sport.id,

            data: {id: tournament_id},

            header: {
                title: {
                    main: cats.tournament.name
                }
            },

            listeners: {
                /**
                 * After destroy of league
                 */
                afterdestroy: function(){

                    me.active_grid = false;
                },//end afterdestroy()

                /**
                 * Match click event
                 * @param match_id
                 * @param e
                 */
                onrowclick: function(match_id,e){
                    me.myController().initMatchById(match_id);
                }//end onrowclick();
            }
        });

        grid.renderTo('#odds-panel');

        me.active_grid = grid;

        $('button.oddBtn.br_tooltip' ).tooltip();

    }, //end renderTournamentContent();

    /**
     * Renders match odds into center panel
     * @param match
     */
    renderMatchContent: function(match){

        //localize
        var me = this,

            configStore = App.getStore('config'),

            //clear main container and save as reference
            container = $("#MiddleContainer").removeAttr('class').addClass('col-md-12 match-container').html(''),
            catInfo = App.getStore('categories').getNestedByTournament(match.tournament_id),
            o;
        $('.home-slider').hide();
        //clear grid object
        me.active_grid = false;

        var header = new MatchHeader({
            home: match.home,
            away: match.away,
            time: match.time,
            sport_code: match.sport_code,
            group: catInfo.group.name,
            tournament: catInfo.tournament.name
        });

        container.append(header.getHtml());


        var oddsHTML = $('<div class="match-details"></div>');


        //Take oddtypes and sort from config them lika a boss
        var oddTypes = Object.keys(match.oddTypes).sort(function(a,b){
            return configStore.getTypeById(a).priority - configStore.getTypeById(b).priority;
        });

        //Odds rendering
        for(o in oddTypes){

            var oddType = match.oddTypes[oddTypes[o]],
                type_id = oddTypes[o];

            var oddsRenderer = new OddsRenderer({
                id: match.id+'_'+oddTypes[o],
                type_id: oddTypes[o],
                odds: oddType.odds,
                matched: oddType.matched,
                data: {match_id: match.id, type_id: type_id},

                listeners: {
                    refresh: function(e){

                        var target = $(e.target).parents('.match-odds'),
                            match_id = target.data('match_id'),
                            type_id = target.data('type_id');

                        App.getStore('odds').updateType({ type_id: type_id, match_id: match_id});
                    }
                }

            })

            oddsHTML.append(oddsRenderer.render());

        }//end loop


        container.append(oddsHTML);
        $('button.oddBtn.br_tooltip' ).tooltip();


    },//end renderMatchContent();

    renderOutrightContent: function(odds, tournament_id){


        //localize
        var me = this,

        //clear main container and save as reference
            container = $("#MiddleContainer").removeAttr('class').addClass('col-md-12 match-container').html(''),
            catInfo = App.getStore('categories').getNestedByTournament(tournament_id),
            o;

        //clear grid object
        me.active_grid = false;

//        var header = new MatchHeader({
//            home: match.home,
//            away: match.away,
//            time: match.time,
//            group: catInfo.group.name,
//            tournament: catInfo.tournament.name
//        });

//        container.append(header.getHtml());


        var oddsHTML = $('<div class="match-details"></div>');

        //Odds rendering
        var oddsRenderer = new OddsRenderer({

            id: tournament_id,
            actions: [ 'collapse', 'refresh' ],
            listeners: {
                refresh: function(){
                    var  oddsStore = App.getStore('odds');
                    oddsStore.getOutrightOdds(tournament_id);
                }
            },
//            matched: 0,
            name: catInfo.tournament.name,
            odds: odds

        });


        oddsHTML.append(oddsRenderer.render());
        container.append(oddsHTML);

        $('button.oddBtn.br_tooltip' ).tooltip();

    },//end renderOutrightContent();

    renderTopBetsContent: function(data){

        //localize
        var me = this,

            container = $("#MiddleContainer").removeAttr('class').addClass('col-md-12 home-middle').html('<div id="odds-panel"></div>'),
            html = '', i,
            sport, matches,
            sports = Object.keys(data);
        $('.home-slider').show();
        //Save as refer
        me.referrer = {
            type: 'topbets'
        };

        //Open main html tag
        html = '<div class="panel panel-grid grid-top">';

        //Header
        html += '<div class="panel-heading clearfix">' +
                    '<h2 class="grid-title">'+lang_arr['topmatches']+'</h2>' +
                    '<ul class="nav nav-tabs" id="top_matches_tabs">';

                for(i in sports){
                    sport = App.getStore('categories').getSportById(sports[i]);

                    try {
                        html += '<li class="{{class}}"><a href="#sport-{{id}}" data-toggle="tab">{{name}}</a></li>'
                            .replace(/{{class}}/g, i==0?'active':'')
                            .replace(/{{name}}/g, sport.name)
                            .replace(/{{id}}/g, sport.id);
                    }catch(e) {
                        console.log(e);
                    }


                }
        html +=     '</ul>'+
                '</div>';//.panel-heading

        //Tab content
        html += '<div class="tab-content" id="top_matches_content">';

            for(i in sports){
                html += '<div class="tab-pane {{class}}" id="sport-{{id}}"></div>'
                    .replace(/{{class}}/g, i==0?'active':'')
                    .replace(/{{id}}/g, sports[i]);
            }//end for

        //end tags
        html += '</div>';//.tab-content
        html += '</div>'; //.panel.panel-grid.grid-top

        container.append(html);

        $('tr.MatchRowTr td.odd:nth-child(odd)').hide();$('th[colspan=2]').attr("colspan",1);$('td.odd').css({"padding-right":"5px"});

        for(i in sports){//loop sports and get games
            sport = App.getStore('categories').getSportById(sports[i]);

            try {

                matches = data[sport.id];

                //Creating grid
                new MatchesGrid({
                    id: 'TournamentGrid'+sport.id,
                    matches: matches,
                    columns: ['pairs','odds'],
                    sport_id: sport.id,



                    listeners: {

                        /**
                         * Match click event
                         * @param match_id
                         * @param e
                         */
                        onrowclick: function(match_id,e){

                            App.getController('matches').initMatchById(match_id);
                            e.preventDefault();

                        }//end onrowclick();
                    }
                }).renderTo('#sport-'+sport.id);
            }
            catch(e) {
                console.log(e);
            }

        }//end loop

        $('button.oddBtn.br_tooltip').tooltip();

    },//end renderTopBetsContent();

    /**
     * Changes old one with new rendered type html
     * @param info
     */
    reRenderType: function(info){

        var me = this,
            oddType = me.myStore().getTypeByMatchAndTypeId(info.match_id, info.type_id),
            id = info.match_id + '_' + info.type_id,

            oddsRenderer = new OddsRenderer({
                id: id,
                type_id: info.type_id,
                odds: oddType.odds,
                matched: oddType.matched,
                data: {match_id: info.match_id, type_id: info.type_id},

                listeners: {
                    refresh: function(e){

                        var target = $(e.target).parents('.match-odds'),
                            match_id = target.data('match_id'),
                            type_id = target.data('type_id');



                        App.getStore('odds').updateType({ type_id: type_id, match_id: match_id});
                    }
                }

            });

        $("#OddsContainer"+id).replaceWith(oddsRenderer.render());

    },//end reRenderType();

    /**
     * Add listeners to dom objects
     */
    addListeners: function(){
        var me = this;

        $(me.container).on('click','#GoToReferrer',function(e){
            history.back();
            e.preventDefault();
        });

    }//end addListeners();
};//end {}