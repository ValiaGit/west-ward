/**
 * Categories View
 */
CategoriesView = {


    init: function(){

        this.render();
        this.renderFeatured();
        this.renderFav();

        this.addListeners();

    },//end init();

    /**
     * Render categories tree
     */
    render: function(){

        //Localize
        var me = this,
            data = me.myStore().store,
            categoriesController = App.getController('categories');


        new TreeRenderer({
            type: 'list',
            renderTo: '#categoriesTree',
            tree: [
                {
                    store: data.sports,
                    index: 'sports',
                    sub: 'groups',
                    tpl: '<a title="{{name}}" href="#" class="expand collapsed"><i class="sport-{{code}}"></i>{{name}}</a>',
                    cls: 'navigation level-1',
                    item_cls: 'list-group-item collapsed'
                },
                {
                    store: data.groups,
                    index: 'groups',
                    sub: 'tournaments',
                    tpl: '<a title="{{name}}" href="#" class="expand collapsed"><i class="flag flag-{{code}}"></i> {{name}}</a>',
                    cls: 'level-2',
                    item_cls: 'list-group-item collapsed'
                },
                {
                    store: data.tournaments,
                    index: 'tournaments',
                    tpl: '<a title="{{name}}" href="#"> {{name}}</a>',
                    cls: 'level-3',
                    item_cls: 'list-group-item',
                    listeners: {
                        click: function(id,e){

                            try {
                                // sumo_enter_sound.stop();
                                // sumo_enter_sound.pause();

                                if(CategoriesStore.store.groups[CategoriesStore.store.tournaments['14787'].parent].parent == 405) {
                                    // sumo_enter_sound.play();
                                    $('.wrapper').css({
                                        "background":"url(https://s-media-cache-ak0.pinimg.com/originals/e1/a2/93/e1a293e57854747ee435c0246cf78746.jpg?1403077911)"
                                    });
                                }
                                else {
                                    sumo_enter_sound.pause();
                                    $('.wrapper').css({
                                        "background":"url('../images/bg.jpg?1431481784')"
                                    });
                                }
                            }catch(e) {

                            }
                            categoriesController.initTournamentById(id);
                            e.preventDefault();
                        }
                    }
                }
            ]
        }).render();

        $('#categoriesTree ul').eq(0).prepend('<li class="popular sports list-group-item collapsed"><a href="" style="font-size:14px;" onclick="WhereismoneyView.initContent();return false;">'+lang_arr['where_is_the_money']+'?</a></li>');



    },//render();

    /**
     * Render favorite categories tree
     */
    renderFeatured: function(){

        //Localize
        var me = this,
            data = me.myStore().store,
            categoriesController = App.getController('categories');

        if(!Object.keys(data.popular).length){
            $("#FavCategories").prev('h2').hide();
            return;
        };

        new TreeRenderer({
            type: 'list',
            renderTo: '#FavCategories',
            tree: [
                {
                    store: data.popular,
                    index: 'popular',
                    tpl: '<a title="{{name}}" href="#">{{name}}</a>',
                    cls: 'navigation level-1',
                    item_cls: 'sports list-group-item collapsed',
                    listeners: {
                        click: function(id,e){
                            categoriesController.initTournamentById(id);
                            e.preventDefault();
                        }
                    }
                }
            ]
        }).render();



    },//end renderFav();


    /**
     * Render favorite categories tree
     */
    renderFav: function(){

        //Localize
        var me = this,
            data = me.myStore().store,
            categoriesController = App.getController('categories');


        if(!Object.keys(data.favorites).length){
            $("#UserCategories").prev('h2').hide();
            return;
        };

        new TreeRenderer({
            type: 'list',
            renderTo: '#UserCategories',
            tree: [
                {
                    store: data.favorites,
                    index: 'popular',
                    tpl: '<a title="{{name}}" href="#">{{name}}</a>',
                    cls: 'navigation level-1',
                    item_cls: 'sports list-group-item collapsed',
                    listeners: {
                        click: function(id,e){
                            categoriesController.initTournamentById(id);
                            e.preventDefault();
                        }
                    }
                }
            ]
        }).render();



    },//end renderFav();

    /**
     * Add tournament as favorite callback
     * @param id
     */
    addFavCallback: function(id){
        Util.Popup.open({content: 'You chose tournament as favorite'});
    },//end addFavCallback();

    /**
     * Add listeners to dom objects
     */
    addListeners: function(){

        var me = this;

        $("#MiddleContainer").on('click','.fav_tournament',function(e){

            var tournament_id = $(e.target).closest('div.panel-grid').data('id');

            me.myStore().addFav(tournament_id);

            e.preventDefault();
        })


    },//end addListeners();

};//end {}