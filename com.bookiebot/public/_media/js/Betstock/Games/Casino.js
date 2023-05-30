var Casino = {

    slotItemTeplate: '' +
    '<div class="col-sm-3 col-md-3" style="height:234px;"> ' +

    '<div class="thumbnail"> ' +
    '<img src="{{icon}}" alt="..."> ' +
    '<div class="caption" style="text-align:center"> ' +
    '<h3 style="font-size:12px;">{{name}}</h3> ' +
    '<p> ' +
     '<a href="' + base_href + '/' + cur_lang + '/casino/game/{{game_id}}" class="btn btn-xs btn-blue" style="color:white;text-align:center;padding:5px;min-width:150px" role="button">'+lang_arr['play']+'</a> ' +
    //'<a onclick="Casino.openBCGame({{game_id}})" class="btn btn-xs btn-blue" style="color:white" role="button">Play</a> ' +
    '</p> ' +
    '</div> ' +
    '</div> ' +

    '</div>',

    getCategories: function(){
        $.getJSON('/games.json', function (data) {

            var Providers = {};
            var GameCats = {};
            var MasterCats = {};
            var Ratios = {};

            var GamesCount = 0;
            var MobileGames = 0;
            var DesktopGames = 0;

            for (var i in data) {
                if (data.hasOwnProperty(i)) {
                    var cur = data[i];

                    GamesCount++;

                    if ( cur.isMobile == 'Y' ) {
                        MobileGames++;
                    } else {
                        DesktopGames++;
                    }

                    if ( Providers.hasOwnProperty(cur.providerFilter) ) {
                        Providers[cur.providerFilter]++;
                    } else {
                        Providers[cur.providerFilter] = 1;
                    }

                    if ( GameCats.hasOwnProperty(cur.gameCategory) ) {
                        GameCats[cur.gameCategory]++;
                    } else {
                        GameCats[cur.gameCategory] = 1;
                    }

                    if ( MasterCats.hasOwnProperty(cur.masterCategory) ) {
                        MasterCats[cur.masterCategory]++;
                    } else {
                        MasterCats[cur.masterCategory] = 1;
                    }


                    if ( Ratios.hasOwnProperty(cur.gameType.ratio) ) {
                        Ratios[cur.gameType.ratio]++;
                    } else {
                        Ratios[cur.gameType.ratio] = 1;
                    }


                }
            }

            console.clear();
            console.log('Total Games: '+GamesCount);
            console.log('Mobile Games: '+MobileGames);
            console.log('Desktop Games: '+DesktopGames);

            console.log({ 'Providers': Providers });
            console.log({ 'Categories' : GameCats });
            console.log({ 'MasterCats' : MasterCats });

            console.log({ 'Ratios' : Ratios });

        });
    },


    casinoPageAssets: function(){

        var self = this;

        $('.renderGames').on('click',function(){


            // Leave Editors Choice (cat=11) by click Provider
            if ($(this).data('location') == 'top' && $('.nav#casino_top li.active a').data('type') == 'category' && $('.nav#casino_top li.active a').data('id') == 11 && $(this).data('type') == 'provider'){
                render_opt.cat = '';
                $('#casino_cats a#cat_all').addClass('active');
            }
            // Leave Editors Choice (cat=11) by click Category
            else if ($(this).data('location') != 'top' && $('.nav#casino_top li.active a').data('type') == 'category' && $('.nav#casino_top li.active a').data('id') == 11 && $(this).data('type') == 'category') {
                $('.nav#casino_top li').removeClass('active');
                $('.nav#casino_top li#all').addClass('active');
            }
            // ENTER to Editor Choice
            else if ( $(this).data('location') == 'top' && $(this).data('id') == 11 ) {
                $('#casino_cats a').removeClass('active');
                render_opt.prov = '';
            }


            if ( $(this).data('type') == 'category' ) {
                render_opt.cat = $(this).data('id');
            } else if ( $(this).data('type') == 'provider') {
                render_opt.prov = $(this).data('id');
            }

            if( $(this).data('location') == 'top' ) {
                $('.nav#casino_top li').removeClass('active');
                $(this).parent('li').addClass('active');
            } else {
                $('#casino_cats a').removeClass('active');
                $(this).addClass('active');
            }

            self.renderGames(render_opt);
        });

        var slotsSlider = $('.swiper-container.casino-slider').swiper({
          mode:'horizontal',
          loop: true,
          autoplay: 5000,
          speed: 500,
          keyboardControl: true,
          pagination: '.swiper-pagination',
          paginationClickable: true
        });

    },

    toggleCats: function(cats){
        var moveToAll = false;
        if ( cats ) {
            $("#casino_cats a:not(#cat_all)").each(function( index ) {
                cat_id = $(this).data('id');

                if ( $.inArray(cat_id,cats) < 0) {
                    $(this).hide();
                    if ( $(this).hasClass('active') ) {
                        $(this).removeClass('active');
                        $("#casino_cats a#cat_all").addClass('active');
                        moveToAll = true;
                    }
                } else {
                    $(this).show();
                }
            });
        } else {
            $( "#casino_cats a:not(#cat_all)" ).show();
        }

        return moveToAll;
    },

    renderGames: function (options) {

        Util.addLoader("#slots_list");

        var self = this;
        var finalHTML = "";


        $.get( base_href+"/"+cur_lang+"/casino/get_games?prov="+options.prov+"&cat="+options.cat, function( data ) {
            var gamesList = data['games'];

            for (var i in gamesList) {
                if (gamesList.hasOwnProperty(i)) {
                    var cur = gamesList[i];

                    finalHTML += self.slotItemTeplate
                        .replace("{{icon}}", cur.thumb)
                        .replace("{{name}}", cur.title)
                        .replace(/{{game_id}}/g, cur.external_id)
                    ;

                }
            }

            var moveToAll = self.toggleCats(data['cats_by_prov']);

            $('#slots_list').html(finalHTML);
            Util.removeLoader("#slots_list");
        });


    },

    renderGamesFile: function () {

        var self = this;
        var finalHTML = "";

        $.getJSON('/games.json', function (data) {
            for (var i in data) {
                if (data.hasOwnProperty(i)) {
                    var cur = data[i];

                    if ( cur.isMobile == 'Y' ) {
                        continue;
                    }

                    var providerFilter = cur['providerFilter'];

                    var icon = "";

                    if (cur['gameIcon'] != '[]') {
                        icon = cur['gameIcon'].replace("http", "https");
                    }
                    else {
                        icon = cur['gameIcon2'].replace("http", "https");
                    }


                    var externalID = cur['externalID'];
                    var gameName = cur['gameName']+" - "+providerFilter;


                    finalHTML += self.slotItemTeplate
                        .replace("{{icon}}", icon)
                        .replace("{{name}}", gameName)
                        .replace(/{{game_id}}/g, externalID)
                    ;

                    //console.log(cur);


                }
            }

            $('#slots_list').html(finalHTML);

        });

    },



    openBCGame: function (id,ratio) {
        var height = Math.floor( $('#gameplay_bg').height() );
        var ratios = ratio.split(":");
        var width = Math.floor( height*(ratios[0]/ratios[1]) );

        //var winObject = window.open('SlotWindow - '+id, "DepositWindow", 'height=' + 768 + ',width=' + 1024);

        var openURL = "https://casinoapi.betconstruct.com/authorization.php?gameId="+id+"&token={token}&partnerId=481&language="+cur_lang+"&openType=real";

        Session.generateProviderToken("8f672252-7516-41dd-807c-f1532ae6aa1e", function (err, token) {
            if(err) {
                alert('Cant Generate Token');
            }
            else {
                openURL = openURL.replace("{token}",token);
                $('#game_wrapper').height(height);
                $('#game_wrapper').width(width);
                if(id == 160008 || id == '160008') {
                    openURL = 'https://sp.patagoniaentertainment.com/game.do?pn=betconstruct&lang=ru&type=real';
                }
                else if(id == 160001 || id == '160001') {
                    openURL = "https://p75.patagoniaentertainment.com/game.do?pn=betconstruct&lang=ru&type=real";
                }
                $('#game_wrapper').html('<iframe src="'+openURL+'" style="width:'+width+'px;height:'+height+'px;"></iframe>');
                //winObject.location.href = openURL;

                $(window).resize(function() {
                    var height = Math.floor( $(window).height() ) - 50;
                    var width = Math.floor( height*ratios[0]/ratios[1] );


                    $('#game_wrapper').height(height);
                    $('#game_wrapper').width(width);
                    $('#game_wrapper > iframe').height(height);
                    $('#game_wrapper > iframe').width(width);
                });

            }
        });
    },



    openGame: function (provider_id, url) {

        Session.generateProviderToken(provider_id, function (err, token) {
            if (err) {
                alert(token);
                return false;
            }

            console.log(url);
            url = url.replace("{lang}", cur_lang);
            url = url.replace("{token}", token);

            console.log(url, "---");
            window.open(url, "Game Opened", 'width=1450,height=850');
        });

    },


    openKeno: function (isLocal) {

        if (isLocal) {
            var URL = "http://localhost:4750/?Token={token}&Lang={lang}";
        } else {

            var URL = "http://keno.betplanet.win:4750/?Token={token}&Lang={lang}";
        }

        var Provider = "bfc583ee-ba0d-4ae1-a04a-b096a1e2f16d";
        this.open(Provider, URL);
    }


};
