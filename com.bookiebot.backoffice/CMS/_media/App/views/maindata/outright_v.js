App.view('outright',{

    /**
     * You're dummy if u need comment for Init function
     */
    init: function(){


        var me = this,
            data = me.myStore().getData(),
            model = me.myModel(),

            container = new Tab({
                id: 'matches',
                name: "Matches"
            });

        me.createFilters(container);

        var grid = me.createGrid('MatchesGrid',container);

        grid.kendoGrid({
            dataSource: {
                transport: {
                    read:function(options) {
                        options.success(data);
                    }
                },
                schema: {
                    model: {
                        fields: model.fields
                    }
                },
                pageSize: 20
            },
            height: 550,
            scrollable: true,
            sortable: true,
            filterable: true,
            editable:"inline",

            pageable: {
                input: true,
                numeric: false
            },
            columns: model.getKendoColumns()
        });


        var filter = new Filter({fields: me.myModel().fields });

        $("#default").prepend(filter.render());




    },//end init();


    initEdit: function(){

        var me = this;


        var sportsDataSource = new kendo.data.DataSource({
            transport: {
                read: {
                    url: API.getUrl('data.sports','getSportsListSelect'),
                    dataType: "json"
                }
            }
        });

        var categoriesDataSource = new kendo.data.DataSource({
            transport: {
                read: {
                    url: API.getUrl('data.categories','getCategoriesListSelect'),
                    data: function(){
                        return {sport_id: $("#SportId").val(),is_outright:true} // send "html5" as the "q" parameter
                    },
                    complete: function(){
                        var combobox = $('#CategoryId').data("kendoComboBox");
                        combobox.select(0);
                        tournamentsDataSource.read();
                    },
                    type: 'POST',
                    dataType: "json"
                }
            }
        });

        var tournamentsDataSource = new kendo.data.DataSource({
            transport: {
                read: {
                    url: API.getUrl('outright.outright','getOutrightTournamentsListSelect'),
                    data: function(){
                        return {category_id: $("#CategoryId").val()} // send "html5" as the "q" parameter
                    },
                    complete: function(){
                        var combobox = $('#TournamentId').data("kendoComboBox");
                        combobox.select(0);
                    },
                    type: 'POST',
                    dataType: "json"
                }
            }
        });

        $("#SportId").kendoComboBox({
            dataTextField: "title",
            dataValueField: "id",
            dataSource: sportsDataSource,
            placeholder: "Select Sport",
            autoBind: true,

            change: function(){
                categoriesDataSource.read();
            }
        });

        $("#CategoryId").kendoComboBox({
            dataTextField: "title",
            dataValueField: "id",
            placeholder: "Select Sport First",
            dataSource: categoriesDataSource,
            autoBind: false,
            change: function(){
                tournamentsDataSource.read();
            }
        });

        $("#TournamentId").kendoComboBox({
            dataTextField: "title",
            dataValueField: "id",
            placeholder: "Select Sport First",
            dataSource: tournamentsDataSource,
            autoBind: false
        });



        $("#ShowGrid").on('click',function(e){
            me.loadMatchesGrid();
            e.preventDefault();
        });
    },


    /**
     *
     */
    loadMatchesGrid: function(){

        var me = this;

        me.destroyGrid('MatchesGrid');

        var tournament_id = $("#TournamentId").val();
        var category_id = $("#CategoryId").val();
        var sport_id = $("#SportId").val();
        var MatchId = $("#MatchId").val();
        var filter_param = { outright_id: tournament_id };
        if(MatchId) {
            filter_param = {outright_id: MatchId}
        }


        if(!tournament_id){
            alert("Choose Tournament First");
            return;
        }

        var autocompleteEditor = function(container, options){

            var input = $('<input/>');
            input.attr('id',options.field+'_AutoComplete');
            input.appendTo(container);

            var placeholder = '';
            if(options.model[options.field]){
                switch(options.field){
                    case 'competitors1_id':
                        placeholder = options.model.home;
                        break;
                    case 'competitors2_id':
                        placeholder = options.model.away;
                        break;
                }
            }

            $(input).kendoAutoComplete({

                placeholder: placeholder,
                dataSource: {
                    serverFiltering: true,
                    transport:
                    {
                        read: {
                            url: API.getUrl('prematch.competitors','getCompetitorsListSelect'),
                            type: 'POST',
                            dataType: "json",
                            data: function(){ return {  sport_id:$("#SportId").val(),  keyWord: $('#'+options.field+'_AutoComplete').data('kendoAutoComplete').value() } }
                        }
                    }
                },

                delay: 500,
                dataTextField: 'title',
                filter: "contains",
                autobind: true,
                suggest: true,
                minLength: 4,

                select: function(e) {
                    var dataItem = this.dataItem(e.item.index());
                    $("#"+options.field+'Value').val(dataItem.id).trigger('change');
                }

            });



            var input = $('<input/>');
            input.attr('id',options.field+'Value')
            input.attr('name',options.field)
                .hide();
            input.appendTo(container);


        };

        $("#MatchesGrid").kendoGrid({

            dataSource: {

                transport: {

                    read: {
                        url: API.getUrl('outright.outright','getOutrightOdds'),
                        dataType: 'json',
                        data: { filter: filter_param },
                        type: 'POST',
                        complete: function(jqXHR, textStatus) { console.log(textStatus, "read"); }
                    },


                    destroy: {
                        url: API.getUrl('prematch.match','delete'),
                        dataType: 'json',
                        type: 'POST',
                        complete: function(jqXHR, textStatus) { console.log(textStatus, "read"); }
                    },

                    update: {
                        url: API.getUrl('prematch.match','updateMatch'),
                        dataType: 'json',
                        type: 'POST',
                        complete: function(jqXHR, status) {
                            if(status == 'success'){
                                Util.showNotification('Update completed');
                            }
                        }
                    },

                    create: {
                        url: API.getUrl('prematch.match','addMatch'),
                        dataType: 'json',
                        type: 'POST',
                        complete: function(jqXHR, status) {
                            if(status == 'success'){
                                Util.showNotification('Update completed');
                            }
                        }
                    },

                    parameterMap: function(options, type) {
                        if(type !== "read") {
                            options.tournament_id = tournament_id;
                            options.category_id = category_id;
                            options.sport_id = sport_id;
                            options.matches_starttime = moment(options.matches_starttime).format('YYYY-MM-DD HH-mm-ss');
                        }
                        return options;
                    }


                },

                schema: {
                    data: 'data',
                    model: {
                        id: 'matches_id',
                        fields: {

                            "matches_id": { type: "number", editable: false },
                            "matches_BetFairEventId": {  type: "number", nullable: true},
                            "matches_BetradarMatchId": {  type: "number", nullable: true},
                            "matches_score_data": {  type: "string", nullable: true},
                            "matches_status": {  type: "number", defaultValue: 0},
                            "matches_starttime": { type: "date" /* parse: function(v){ return kendo.parseDate(v); } */ }, //"2015-02-04T20:00:00Z"
                            "competitors1_id": { type: "number", validation: {required: true}}, //fkey
                            "competitors2_id": { type: "number", validation: {required: true}}, //fkey
                            "home": { type: "string" },
                            "away": { type: "string" }

                        }
                    },
                    errors: function (a){
                        return a.code != 10;
                    }
                },

                batch: false

            },//end dataSource,

            toolbar: ["create"],
            height: 550,
            pageable: true,
            editable: "popup",
            columns: [
                {
                    field: "matches_id", title: "Id", width: 100
                },
                {
                    field: 'matches_BetFairEventId', title: 'BF Event Id', width: 100,
//                    format: 'string'
                },
                {
                    field: 'matches_BetradarMatchId', title: 'BR Event Id', width: 100,
//                    format: 'string'
                },
                {
                    field: 'competitors1_id', title: 'Competitor 1', template: function(v){ return v.home },
                    editor: autocompleteEditor
                },
                {
                    field: 'competitors2_id', title: 'Competitor 2', template: function(v){ return v.away },
                    editor: autocompleteEditor

                },
                {
                    field: 'matches_starttime', title: 'Time',
                    format: "{0:dd-MMM-yyyy hh:mm:ss}"
                },
                {
                    field: 'matches_status', title: 'Status',
                    values: [
                        {
                            "value": 0,
                            "text": "Disabled"
                        },{
                            "value": 1,
                            "text": "Active"
                        },{
                            "value": 2,
                            "text": "Finished"
                        },{
                            "value": 3,
                            "text": "In Play"
                        }
                    ]
                },
                {
                    field: "matches_score_data", title: "ScoreData",
                    editor: function(container, options){
                        $('<textarea name="'+options.field+'"></textarea>').appendTo(container);
                    }
                },
                {
                    command: ["edit", "destroy", {text: "Odds", click: function(e){

                        var dataItem = this.dataItem($(e.currentTarget).closest("tr"));

                        App.getView('matches').oddsEditor(dataItem.id);

                    }
                    }],
                    title: "&nbsp;",
                    width: 260
                }
            ]

        });

    },


    oddsEditor: function(match_id){

        var me = this;

        me.destroyGrid('MatchesOddsGrid');


        var oddTypesDataSource = new kendo.data.DataSource({
            transport: {
                read: {
                    url: API.getUrl('data.oddtypes','getOddTypesList'),
                    data: { sport_id : $("#SportId").val() },
                    dataType: "json",
                    type: 'POST'
                }
            },
            schema: {
                data: 'data'
            }
        });

        $("#MatchesOddsGrid").kendoGrid({

            dataSource: {

                transport: {

                    read: {
                        url: API.getUrl('prematch.matchodds','getOddsByMatchId'),
                        dataType: 'json',
                        type: 'POST'
                    },


//                    destroy: {
//                        url: API.getUrl('prematch.match','delete'),
//                        dataType: 'json',
//                        type: 'POST',
//                        complete: function(jqXHR, textStatus) { console.log(textStatus, "read"); }
//                    },

                    create: {
                        url: API.getUrl('prematch.match','addOddType'),
                        dataType: 'json',
                        type: 'POST',
                        complete: function(jqXHR, status) {
                            if(status == 'success'){
                                Util.showNotification('Update completed');

                                $("#MatchesOddsGrid").data("kendoGrid").dataSource.read();
                                $("#MatchesOddsGrid").data("kendoGrid").refresh();

                            }
                        }
                    },

                    parameterMap: function(options, type) {
                        if(type == 'create'){
                            options.odd_type_id = options.title;
                        }
                        options.match_id = match_id;
                        return options;
                    }


                },

                schema: {
                    data: 'data',
                    model: {
                        id: 'id',
                        fields: {
                            id: {},
                            BetradarOddsTypeID: {},
                            odds: {},
                            priority: {},
                            title: {},
                        }
                    },
                    errors: function (a){
                        return a.code != 10;
                    }
                },

                batch: false

            },//end dataSource,

            edit: function(e){
                e.container.find(".k-edit-label").hide();
                e.container.find("input").closest('div').hide();
                e.container.find(".k-edit-label:eq(1)").show();
                e.container.find("input:eq(1)").closest('div').show();
            },
            detailInit: me.renderDetailedOdds,
            toolbar: ['create'],
            height: 550,
            editable: "popup",
            columns: [
                {
                    field: "id", title: "ID", width: 100
                },{
                    field: "title", title: "Title",
                    editor: function(container,options){

                        var input = $("<input />").attr('name',options.field);
                        container.append(input);

                        $(input).kendoComboBox({
                            dataTextField: "title",
                            dataValueField: "id",
                            dataSource: oddTypesDataSource,
                            placeholder: "Odd Type",
                            autoBind: true
                        });


                    }
                },{
                    field: "BetradarOddsTypeID", title: "Betradad TypeID"
                },
                {
                    command: ["destroy"],
                    title: "&nbsp;",
                    width: 260
                }
            ]

        });

        $('html, body').animate({
            scrollTop: $("#MatchesOddsGrid").offset().top
        }, 1000);

    },//end oddsEditor();


    renderDetailedOdds:function(e) {
        //function asArray(e.data.odds) {
        //
        //}

        var grid = $("<div/>").appendTo(e.detailCell).kendoGrid({
            dataSource:{
                data:e.data.odds,
                batch: true,
                update:function(e) {
                    console.log(e);
                    alert("ok");
                },
                schema: {
                    model: {
                        id:"id",
                        fields: {
                            id: {editable: false},
                            status: {editable: true},

                        }
                    }
                }
            },
            editable: "inline",
            columns:[
                {
                    field:"id",
                    title:"id"
                },
                {
                    field:"title",
                    title:"title"
                },
                {
                    field:"status",
                    title:"status"
                },
                {
                    field:"ov",
                    title:"odd value"
                },
                {
                    field:"sp",
                    title:"special value"
                },
                { command: ["edit", "destroy"], title: "&nbsp;", width: "250px" }
            ]
        });
        console.log(e.data.odds);
    },

    /**
     * Render grid for history data
     */
    renderData: function(){


    }//end renderData();


});//end {}