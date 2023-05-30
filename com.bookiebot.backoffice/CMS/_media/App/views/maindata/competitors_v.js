App.view('competitors',{

    init: function(){

        var me = this;

        var sportsDataSource = new kendo.data.DataSource({
            transport: {
                read: {
                    url: API.getUrl('data.sports','getSportsListSelect'),
                    dataType: "json"
                }
            }
        });

        $("#CompetitorsSportId").kendoComboBox({
            dataTextField: "title",
            dataValueField: "id",
            dataSource: sportsDataSource,
            placeholder: "Select Sport",
            autoBind: true
        });

        $("#ShowCompetitorsGrid").on('click',function(e){
            me.loadCompetitorsGrid();
            e.preventDefault();
        });

        $("#CompetitorsSportId").val(336);
        me.loadCompetitorsGrid();
    },


    /**
     *
     */
    loadCompetitorsGrid: function(){

        var me = this;

        me.destroyGrid('CompetitorsGrid');

        var sport_id = $("#CompetitorsSportId").val();

        if(!sport_id){
            alert("Choose Sport First");
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
                            data: function(){ return {  keyWord: $('#'+options.field+'_AutoComplete').data('kendoAutoComplete').value() } }
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

        $("#CompetitorsGrid").kendoGrid({

            dataSource: {

                transport: {

                    read: {
                        url: API.getUrl('prematch.competitors','getCompetitorsList'),
                        dataType: 'json',
                        type: 'POST',

                        complete: function(jqXHR, textStatus) { console.log(textStatus, "read"); }
                    },

                    destroy: {
                        url: API.getUrl('prematch.competitors','delete'),
                        dataType: 'json',
                        type: 'POST',
                        complete: function(jqXHR, textStatus) {
                            console.log(arguments);

                            var Response = jqXHR['responseJSON'];
                            if(Response['code'] == 10) {
                                Util.showNotification('Delete completed');
                            }
                            else {
                                alert("Delete was not successful");
                            }


                        }

                    },

                    update: {
                        url: API.getUrl('prematch.competitors','edit'),
                        dataType: 'json',
                        type: 'POST',
                        complete: function(jqXHR, status) {
                            if(status == 'success'){
                                Util.showNotification('Update completed');
                            }
                        }
                    },

                    create: {
                        url: API.getUrl('prematch.competitors','add'),
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
                            options.betting_sport_id = sport_id;
                        }

                        var filters;
                        if(options.filter){ filters = options.filter.filters }
                        else {
                            options.filter = { filters: []};
                            filters = options.filter.filters;
                        }

                        filters.push({
                            field: 'sport_id',
                            operator: 'equals',
                            value: sport_id
                        });

                        return options;
                    }


                },

                serverPaging: true,
                pageSize: 30,
                serverFiltering: true,


                schema: {
                    data: 'data',
                    total: "total", // total number of records is in the "total" field of the response
                    model: {
                        id: 'id',
                        fields: {

                            "id": { type: "number", editable: false },
                            "betting_sport_id": { type: "number", editable: true },
                            "sport_title": { type: "string", editable: false },
                            "BetradarCompetitorId": {  type: "string", nullable: true},
                            "title": { nullable: true },
                            "competitor_image": { type: "string" },

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

            filterable: {
                extra: false,
                operators: {
                    string: {contains: "Contains"},
                    number: {contains: "Contains", eq: "Is equal to"}
                }
            },

            columns: [
                {
                    field: "id", title: "Id", width: 100
                },
                {
                    field: "betting_sport_id", title: "Sport Id", width: 100
                },

                {
                    field: 'BetradarCompetitorId', title: 'BR Id', width: 100,
                },
                {
                    field: 'title', title: 'Title', template: Model.kendo.lang.template, editor: Model.kendo.lang.editor
                },
                {command: ["edit", "destroy"], title: "&nbsp;", width: "200px"}
            ]

        });

    },

    /**
     * Render grid for history data
     */
    renderData: function(){


    }//end renderData();


});//end {}