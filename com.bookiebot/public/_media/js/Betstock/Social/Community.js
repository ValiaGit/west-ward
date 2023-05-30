var Community = {


    /**************************************************
     * Join Community
     */



    getAllCommunities:function() {
        var me = this;
        var user_id = Util.Cookie.get("user_id");
        Util.addLoader($('#AllCommunities'));
        API.call("social.community","getAllCommunities",{},function(response) {
            console.log(response);
            if(response.code ==10) {
                me.renderAllCommunities(response.data);
            }
            Util.removeLoader($('#AllCommunities'));

        });
    },

    renderAllCommunities:function(comunities) {
        var CommunitiesHTML = "";
        for (var i = 0; i < comunities.length; i++) {
            var current = comunities[i];
            var link = base_href+"/"+cur_lang+"/social/community/"+current.community_id;


            if(!current.is_in_community) {
                CommunitiesHTML += '<div class="col-sm-6 col-md-3" id="community_box_'+current.community_id+'">'
                +'<div class="thumbnail">'
                +'<a href="'+current['original_logo']+'" class="highslide" onclick="return hs.expand(this)"><img height="120" style="height:120px" src="'+current.logo_path+'" alt=""></a>'
                +'    <div class="caption">'
                +'        <h3><a href="'+link+'">'+current.title+'</a></h3><br/>'
                +'      <p>'
                +'          <a href="#" class="btn btn-success btn-xs" onclick="Community.joinCommunityFromOutside('+current.community_id+')" role="button">JOIN</a>'
                +'      </p>'
                +'  </div>'
                +'</div>'
                +'</div>';
            } else {
                CommunitiesHTML += '<div class="col-sm-6 col-md-3" id="community_box_'+current.community_id+'">'
                +'<div class="thumbnail">'
                +'<a href="'+current['original_logo']+'" class="highslide" onclick="return hs.expand(this)"><img height="120" style="height:120px" src="'+current.logo_path+'" alt=""></a>'
                +'    <div class="caption">'
                +'        <h3><a href="'+link+'">'+current.title+'</a></h3><br/>'
                +'      <p>'
                +'          <a href="#" class="btn btn-danger btn-xs" onclick="Community.removeSelfFromCommunityFromOutside('+current.community_id+')" role="button">LEAVE</a>'
                +'      </p>'
                +'  </div>'
                +'</div>'
                +'</div>';
            }



        }


        $('#AllCommunities').html(CommunitiesHTML);
    },

    OpenCreateClubPopup:function() {
        Util.Popup.openForm({
            title:"create_club",
            fields:[
                {
                    name:"community_title",
                    label:"Club name",
                    validation:{
                        required:true
                    }
                },
                {
                    name:"logo_path",
                    label:"Logo image",
                    type:"file",
                    validation:{
                        required:true
                    }
                },
                {
                    name:"cover_path",
                    label:"Cover image",
                    type:"file",
                    validation:{
                        required:true
                    }
                },
                {
                    name:"background_path",
                    label:"Background image",
                    type:"file",
                    validation:{
                        required:true
                    }
                }

            ],
            onSubmit:"Community.createCommunity"

        });
    },


    createCommunity:function(form) {
        var data = Util.Form.serializeUploadForm(form);
        API.callWithMimeFile("social.community","createCommunity",data,function(response) {
            if(response.code == 10) {
                me.getUserDocuments();
                Util.Popup.open({
                    content:lang_arr['success']
                });
            }
        });


    },

    /**************************************************
     * Render Communities List
     */
    getMyCommunitiesList:function() {
        var me = this;
        var user_id = Util.Cookie.get("user_id");
        Util.addLoader($('#my_communities'));
        API.call("social.community","getMyCommunitiesList",{user_id:user_id},function(response) {
            me.renderCommunitiesList(response);
        });
    },

    renderCommunitiesList:function(communities_list) {
        var html = "";
        var length = communities_list.length;
        if(length) {
            for(var i=0;i<length;i++) {

                html += '<li id="community_li_'+communities_list[i].id+'"><a href="/en/social/community/'+communities_list[i].id+'"><span class="glyphicon glyphicon-star social-nav-icon"></span> '+communities_list[i].title+' (Members:'+communities_list[i].user_num+')</a></li>';
            }
        } else {
            html = "<li><a>You Dont Have Any Communities</a></li>";
        }

        $('#my_communities').html(html);
    },
    /**************************************************
     * END Render Communities List
     */


    searchCommunity:function(term) {
        if(term.length<4) {
            console.log("Term Should be longer than 4 chars");
            return false;
        }
        var params = {
            user_id:Util.Cookie.get("user_id"),
            term:term
        };
        API.call("social.community","searchCommunity",params,function(response) {
            console.log(response);
        });
    },


    getCommunity:function(community_id) {
        var me = this;
        var params = {
            user_id:Util.Cookie.get("user_id"),
            community_id:community_id
        };
        API.call("social.community","getCommunity",params,function(response) {


            $('#community_li_'+community_id).addClass("active");
            $('.community_id').attr('rel',response.id);
            $('#community_title').text(response.title);
            $('.competitor_name').text(response.title);
            $('#community_sport').text(response.sport_title);
            $('#community_logo').attr('src',response.logo_path);


            $('body .wrapper').css('background','#bd1016 url(https://s-media-cache-ak0.pinimg.com/originals/e1/a2/93/e1a293e57854747ee435c0246cf78746.jpg?1403077911)');

            if(response.is_user_in_community) {
                $('#leaveCommunity').removeClass("hidden");
                $('#joinCommunity').addClass("hidden");
                me.showFeed(response.feed);
            }


            else {
                $('#joinCommunity').removeClass("hidden");
                $('#leaveCommunity').addClass("hidden");
                me.hideFeed();
            }

            $('#leaveCommunity').click(function() {
                var id = $(this).attr("rel");
                Community.removeSelfFromCommunity(id);
            });
            $('#joinCommunity').click(function() {
                var id = $(this).attr("rel");
                Community.joinCommunity(id);
            });

            if(response.hasOwnProperty("team_bets")) {
                if(response.team_bets.length) {
                    Friends.renderBetsByFriends(response.team_bets);
                } else {
                    $('#bets_by_friends').html("<hr style='margin-top:0px;margin-bottom:5px'/><p style='padding-left:14px;font-size:16px;'>There aren't any team bets yet!</p>");
                }
            }




        })
    },


    showFeed:function(feedData) {
        Util.addLoader($('#stream'));
        Posts.renderFeed(feedData);
    },


    hideFeed:function() {
        $('#stream').html("Please Join Community To See Posts!");
        $('#team_bets').find(".bets_by_friends").html("<div style='padding-left:20px'>Please join community to see bets!</div>");

    },


    joinCommunity:function(community_id) {
        var me = this;
        var params = {
            user_id:Util.Cookie.get("user_id"),
            community_id:community_id
        };
        API.call("social.community","joinCommunity",params,function(response) {
            me.getCommunity(community_id);
            me.getMyCommunitiesList();
        })
    },

    joinCommunityFromOutside:function(community_id) {
        var me = this;
        var params = {
            user_id:Util.Cookie.get("user_id"),
            community_id:community_id
        };
        API.call("social.community","joinCommunity",params,function(response) {
            //me.getCommunity(community_id);
            me.getMyCommunitiesList();
            me.getAllCommunities();
        })
    },


    removeSelfFromCommunity:function(community_id) {
        var me = this;
        var params = {
            user_id:Util.Cookie.get("user_id"),
            community_id:community_id
        };
        API.call("social.community","removeSelfFromCommunity",params,function(response) {
            me.getCommunity(community_id);
            me.getMyCommunitiesList();
        })
    },

    removeSelfFromCommunityFromOutside:function(community_id) {
        var me = this;
        var params = {
            user_id:Util.Cookie.get("user_id"),
            community_id:community_id
        };
        API.call("social.community","removeSelfFromCommunity",params,function(response) {
            me.getMyCommunitiesList();
            me.getAllCommunities();
        })
    }





}


