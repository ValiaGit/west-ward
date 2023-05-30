var Search = {

    input: $('#peopleGroupSearch'),

    search_item_tpl: '<div class="search-item">' +
    '<div class="item-thumb">' +
    '<img src="{{thumb}}" alt=""/>' +
    '</div>' +
    '<!-- item-thumb -->' +
    '<div class="item-details">' +
    '    <h3 class="item-title">{{title}}</h3>' +
    '    <p class="item-description">{{description}}</p>' +
    ' </div>' +
    ' <!-- item-details -->' +
    '<button style="{{display_remove}}" class="btn btn-sm btn-dark-blue btn-add-friend" class="add_friend_button" onclick="Friends.removeFriend(\'{{friend_id}}\', this); return false;"><i class="glyphicon glyphicon-minus"></i> Remove Friend</button>'+
    '<button style="{{display_add}}" class="btn btn-sm btn-dark-blue btn-add-friend" class="add_friend_button" onclick="Friends.addFriend(\'{{friend_id}}\', this); return false;"><i class="glyphicon glyphicon-plus"></i> Add Friend</button>' +
    '<a href="#s1" class="full-link"></a>' +
    '</div><!-- search-item -->',


    init: function (event) {
        event.stopPropagation();
        $('.search-items').html("");
        var me = this;
        var val = me.input.val();
        if (val.length > 2) {
            me.callService(val);
        }
    },


    blur: function (event) {
        //$('.search-form').removeClass("has-results");
        //event.stopPropagation();
    },


    callService: function (term) {
        var me = this;

        var params = {
            user_id: Util.Cookie.get("user_id"),
            term: term
        };

        API.call("social.friends", "searchPeople", params, function (response) {
            if (response.code == 10) {
                $('.search-form').addClass("has-results");
                var itemsHTML = "";
                var data = response.data;
                for (var index in data) {
                    var current = data[index];
                    var template = me.search_item_tpl;
                    template = template.replace("{{thumb}}", current.avatar);
                    template = template.replace("{{title}}", current.fullname);
                    template = template.replace(/{{friend_id}}/g, current.id);
                    template = template.replace("{{description}}", "");
                    if(current.is_friend == true) {
                        template = template.replace("{{display_remove}}", "display:block");
                        template = template.replace("{{display_add}}", "display:none");
                    }

                    else {
                        template = template.replace("{{display_add}}", "display:block");
                        template = template.replace("{{display_remove}}", "display:none");
                    }

                    itemsHTML += template;
                }
                $('.search-items').html(itemsHTML);
            } else {
                $('.search-form').removeClass("has-results");
            }
        });
    }
};