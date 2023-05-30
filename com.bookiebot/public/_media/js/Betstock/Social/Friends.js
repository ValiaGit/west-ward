var Friends = {
    MyFriendsList: $('#MyFriendsList'),
    ReceivedRequests: $('#ReceivedRequests'),

    /**
     *
     */
    init: function () {
        var me = this;
        me.getReceivedRequests();
        me.getMyFriendsList();


    },

    /**
     * add friend into friendship
     * @param friend_id
     * @param target
     */
    addFriend: function(friend_id, target) {
        API.call("social.friends", "sendFriendRequest", {user_id: Util.Cookie.get("user_id"), friend_id: friend_id}, function (response) {
            if (response.code == 10) {
                // change button
                if ('undfined' !== typeof target) {
                    $(target).html('<i class="glyphicon glyphicon-minus"></i> Remove Friend');
                    $(target).attr('onclick', 'Friends.removeFriend(' + friend_id + ', this); return false;');
                }
            } else {
                Util.Popup.open({
                    content:response.msg
                });
            }
        });
    },

    /**
     * remove friend from friendship
     * @param friend_id
     * @param target
     */
    removeFriend: function(friend_id, target) {
        API.call("social.friends", "deleteFriend", {friend_id: friend_id,user_id:Util.Cookie.get("user_id")}, function (response) {
            if (response.code == 10) {
                // change button
                if ('undfined' !== typeof target) {
                    $(target).html('<i class="glyphicon glyphicon-plus"></i> Add Friend');
                    $(target).attr('onclick', 'Friends.addFriend(' + friend_id + ', this); return false;');
                }
            } else {
                alert('Response: ' + response.code);
            }
        });
    },

    deleteFriend:function(friend_id) {
        var answer = confirm("Are you sure?");
        if(answer) {
            API.call("social.friends", "deleteFriend", {friend_id: friend_id,user_id:Util.Cookie.get("user_id")}, function (response) {
                if (response.code == 10) {
                    $('#friend_box_'+friend_id).remove();
                    Util.Popup.open({
                        content:"success"
                    });
                } else {
                    alert('Response: ' + response.code);
                }
            });
        }

    },

    /**
     *
     */
    getMyFriendsList: function () {
        var me = this;
        var user_id = Util.Cookie.get("user_id");
        Util.addLoader(me.MyFriendsList);
        API.call("social.friends", "getMyFriendsList", {user_id: user_id}, function (response) {

            if(response.code == 10) {
                var friends = response.data;

                var FriendsListHtml = "";
                for (var i = 0; i < friends.length; i++) {
                    var current = friends[i];

                    if (current.id != user_id) {
                        FriendsListHtml += '<div class="col-sm-6 col-md-4" id="friend_box_'+current.id+'">'
                        +'<div class="thumbnail">'
                        +'<img height="120" style="height:120px" src="'+current.avatar+'" alt="">'
                        +'    <div class="caption">'
                        +'        <h3>'+current.fullname+'</h3><br/>'
                        +'      <p>'
                        +'          <a href="#" class="btn btn-primary btn-xs" onclick="Messaging.openMessageSendPopup('+current.id+',\''+current.fullname+'\')" role="button">Message</a>'
                        +'          <a href="#" class="btn btn-danger btn-xs" role="button" onclick="Friends.deleteFriend('+current.id+')">Unfriend</a>'
                        +'      </p>'
                        +'  </div>'
                        +'</div>'
                        +'</div>';
                    }

                }
                //console.log(FriendsListHtml);
                me.MyFriendsList.html("<ul>" + FriendsListHtml + "</ul>");
            } else {
                me.MyFriendsList.html("<p style='padding-left:20px'>You don't have amy friends!</p>");
            }

        });
    },

    /**
     *
     * @param request_id
     */
    approveReceivedRequest: function (request_id) {
        var user_id = Util.Cookie.get("user_id");
        API.call("social.friends", "approveReceivedRequest", {
            user_id: user_id,
            request_id: request_id
        }, function (response) {
            if (response.code == 10) {
                Util.Popup.open({
                    content:"Request Was Accepted!"
                });
                $('#request_holder_'+request_id).fadeOut();
                Friends.init();
            }
        });
    },

    /**
     *
     * @param request_id
     */
    removeReceivedRequest: function (request_id) {
        var user_id = Util.Cookie.get("user_id");
        API.call("social.friends", "removeReceivedRequest", {
            user_id: user_id,
            request_id: request_id
        }, function (response) {
            if (response.code == 10) {
                Util.Popup.open({
                    content:"Request Was Deleted!"
                });
                $('#request_holder_'+request_id).fadeOut();
                Friends.init();
            }
        });
    },

    /**
     *
     */
    getReceivedRequests: function () {
        var me = this;
        var user_id = Util.Cookie.get("user_id");
        API.call("social.friends", "getReceivedRequests", {user_id: user_id}, function (requests) {
            var len = requests.length;
            if (!len) {
                me.ReceivedRequests.html(lang_arr['you_don_have_pending_requests']);
                return false;
            }
            var RequestsListHtml = "";
            for (var i = 0; i < len; i++) {
                var current_request = requests[i];
                RequestsListHtml += '' +
                '<div class="media" id="request_holder_' + current_request.request_id +'">'+
                '<div class="media-left pull-left">'+
                '<a href="#">'+
                '    <img class="media-object" src="'+current_request.avatar+'" alt="...">'+
                '    </a>'+
                '</div>'+
                '<div class="media-body">'+
                '<h4 class="media-heading"><strong>'+current_request.fullname+'</strong></h4>'+
                '<h4 class="media-heading">'+moment(current_request.start_date).format('Do MMM - HH:mm')+'</h4>'+
                '<div class="btn-group" role="group" aria-label="...">'+
                '    <button type="button" class="btn btn-xs btn-success" onclick="Friends.approveReceivedRequest(' + current_request.request_id +')">Accept</button>'+
                '    <button type="button" class="btn btn-xs btn-warning" onclick="Friends.removeReceivedRequest(' + current_request.request_id +')">Remove</button>'+
                '    <button type="button" class="btn btn-xs btn-danger" onclick="Friends.blockReceivedRequest(' + current_request.request_id +')">Block</button>'+
                '</div>'+
                '</div>'+
                '</div>';
                //RequestsListHtml += "<li>request_id:" + current_request.request_id + "; <br /> username:" + current_request.sender_fullname + "<br /><a onclick='Friends.approveReceivedRequest(" + current_request.request_id + ")'>Approve</a><hr /></li>";
            }

            me.ReceivedRequests.html(RequestsListHtml);
        });
    },


    /******
     * Bets By Friends
     */
    takeBet: function () {
        Util.Popup.open({
            content: "Do you want to take bet?",
            buttons: [
                {
                    text: "Ok",
                    click: ""
                },
                {
                    text: "Cancel",
                    click: ""
                }
            ]

        })
    },




    bet_by_friends_teamplate: '' +
    '<div class="bet-item">' +
    '<div class="item-inner">' +
    '<div class="item-details">' +
    '<div class="details-inner">' +
    '<div class="avatar">' +
    '<a href="#avatar"><img src="{avatar}" width="48" alt=""/></a>' +
    '</div>' +
        // end of avatar
    '<div class="bet-details">' +
    '<h3><a href="#username">{fullname}</a></h3>' +
    '<p class="elapse">' +
    '<a href="' + base_href + '/' + cur_lang + '/p/match/{match_id}#oddtype={oddtype_id}" target="_blank">{match}</a>' +
    '</p>' +
    '<p>' +
    '<span class="item-label">Type:</span> {type} <br/>' +
    '<span class="item-label">Market:</span> {market_title} <br/>' +
    '<span class="item-label">Selection:</span> {selection} <br/>' +
    '<span class="item-label">Bet Amount:</span> {bet_amount} &#8364;<br/>' +
    '<span class="item-label">Unmatched:</span> {unmatched_amount} &#8364;<br/><br/>' +
    '<button type="button" class="btn btn-dark-blue btn-small" onclick="Friends.takeBet({type},{unmatched_amount})">Take Bet</button>' +
    '  </p>' +
    '</div>' +
        // end of bet details
    '</div>' +
        // end of details inner
    '</div>' +
        // end of item details
    '<div class="item-more"><a href="' + base_href + '/' + cur_lang + '/p/match/{match_id}#oddtype={oddtype_id}"><i class="icon-arrow-right"></i></a></div>' + // end of item more
    '</div>' +
        // end of item-inner
    '</div>',
    // end of bet-item


    getBetsByFriends: function () {
        var me = this;
        var html = "";
        API.call("betting.bets", "getBetsByFriends", {user_id: Util.Cookie.get("user_id")}, function (response) {
            if (!response.length) {
                $('#bets_by_friends').html('<p style="padding-left:14px;font-size:16px;">There aren\'t any team bets yet!</p>');
                return false;
            }
            me.renderBetsByFriends(response);
        });

    },

    renderBetsByFriends: function (response) {
        var me = this;
        var html = "";
        for (var index in response) {
            var current = response[index];

            var user_id = current.user_id;
            var fullname = current.fullname;
            var away = current.away;
            var home = current.home;
            var bettime = current.bettime;
            var unmatched_amount = current.unmatched_amount;

            var market_title = current.market_title;
            var match_id = current.match_id;
            var selection = current.selection;
            var bet_amount = current.bet_amount;
            var oddtype_id = current.oddtype_id;
            var avatar = current.avatar;

            var betTypeString = lang_arr['back'];
            if (current.bet_type == 1) {
                betTypeString = lang_arr['lay'];
            }
            betTypeString = betTypeString.toLowerCase();

            var template = me.bet_by_friends_teamplate;
            template = template.replace(/{fullname}/g, fullname);
            template = template.replace(/{avatar}/g, avatar);
            template = template.replace(/{match_id}/g, match_id);
            template = template.replace(/{match}/g, home + " - " + away);
            template = template.replace(/{market_title}/g, market_title);
            template = template.replace(/{selection}/g, selection);
            template = template.replace(/{oddtype_id}/g, oddtype_id);
            template = template.replace(/{type}/g, betTypeString);
            template = template.replace(/{bet_amount}/g, (bet_amount / 100).toFixed(2));
            template = template.replace(/{unmatched_amount}/g, (unmatched_amount / 100).toFixed(2));

            html += template;
        }


        $('#bets_by_friends').html(html);
    }



};

