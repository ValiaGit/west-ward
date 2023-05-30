var Messaging = {

	inputMessage: $('#inputMessage'),
	messagesPanel: $('#messagesPanel'),
	countConversations: 0,
	friendInterval: null,
	openedFriend: null,

	/**
	 *
	 */
	openLastConversation: function () {
		var me = this;
		me.getFriendsWithIHadConversation(function () {
			if (me.countConversations) {
				$('#conversationsList').find('li').eq(0).find('a').click();
			}
		});
	},


    createConversation:function(friend_name,friend_id) {
        var me = this;
        //<li id="friend_conversation_103" class="active"><a href="#" onclick="Messaging.getMessagesByFriend(103); Util.State.addActive(this, 'parent'); return false;"><i class="icon-close pull-right" onclick="Messaging.deleteConversationWithFriend(103, this); return false;"></i><em><i class="online"></i> e</em></a></li>
        var ListItemToPushInConversations = $('<li id="friend_conversation_'+friend_id+'" class="active"></li>');
        ListItemToPushInConversations.html('<a href="#" onclick="Messaging.getMessagesByFriend('+friend_id+'); Util.State.addActive(this, \'parent\'); return false;">' +
        '<i class="icon-close pull-right" onclick="Messaging.deleteConversationWithFriend('+friend_id+', this); return false;"></i>' +
        '<em><i class="online"></i> ' +
        ''+friend_name+'</em>' +
        '</a>');
        $('#conversationsList').prepend(ListItemToPushInConversations);
        me.inputMessage.focus();
        console.log(ListItemToPushInConversations);
    },

	/**
	 *
	 */
	getFriendsWithIHadConversation: function (callback) {
		var me = this;
		var user_id = Util.Cookie.get("user_id");
		var params = {
			user_id: user_id
		};

		API.call("social.messaging", "getFriendsWithIHadConversation", params, function (response) {
			var html = "";
			for (var index in response) {
				var current = response[index];
				html += '<li id="friend_conversation_' + current.friend_id + '">' +
				'<a href="#" onclick="Messaging.getMessagesByFriend(' + current.friend_id + '); Util.State.addActive(this, \'parent\'); return false;">' +
				'<i class="icon-close pull-right" onclick="Messaging.deleteConversationWithFriend(' + current.friend_id + ', this); return false;"></i>' +
				'<em><i class="online"></i> ' + current.fullname + '</em>' +
				'</a>' +
				'</li>';

				me.countConversations++;
			}

			$('#conversationsList').html(html);
			if ('function' == typeof callback) callback();
		});
	},

	/**
	 * @param friend_id
	 */
    openFriendMessages: function (friend_id) {
		var me = this;
		me.getMessagesByFriend(friend_id);
		me.friendInterval = setInterval(function () {
			me.getMessagesByFriend(friend_id);
		}, 3000);
	},


	/**
	 *
	 */
	closeFriendMessages: function () {
		var me = this;
		clearInterval(me.friendInterval);
		me.friendInterval = null;
	},

	/**
	 * @param friend_id
	 */
	getMessagesByFriend: function (friend_id) {
		var me = this;
		me.openedFriend = friend_id;
		clearInterval(me.friendInterval);

		var user_id = Util.Cookie.get("user_id");
		var params = {
			friend_id: friend_id,
			user_id: user_id
		};
		$('#conversationsList li').removeClass("active");
		$('#friend_conversation_' + friend_id).addClass("active");
        //Util.addLoader(me.messagesPanel);
		API.call("social.messaging", "getMessagesByFriend", params, function (response) {
			var html = "";
			var template = "";

			// iterate over messages
			for (var index in response) {
				var current = response[index];

				template = '<!-- date -->' +
				'<div class="message-part">' +
				'    <div class="pull-right time">' + current['send_date'] + '</div>' +
				'    <!-- time -->' +
				'   <div class="author">' +
				'       <div class="thumb">' +
				'           <a href="#"><img src="' + current['avatar'] + '" alt="" width="32"/></a>' +
				'       </div>' +
				'       <!-- thumb -->' +
				'       <h3><a href="#">' + current['fullname'] + '</a></h3>' +
				'   </div>' +
				'   <!-- author -->' +
				'   <div class="message">' + current['content'] + '</div>' +
				'   <!-- message -->' +
				'</div>' +
				'<!-- message part -->' +
				'<!-- conversation-item -->';

				html += template;
			}

			me.messagesPanel.html(html);
			me.messagesPanel.parent().scrollTop(me.messagesPanel.height());
		});

		me.friendInterval = setInterval(function () {
			me.getMessagesByFriend(friend_id);
		}, 3000);

	},

	/**
	 *
	 */
	sendMessage: function (friend_id, content) {
		var me = this;
		var user_id = Util.Cookie.get("user_id");
		content = typeof content == 'undefined' ? me.inputMessage.val() : content;
		friend_id = typeof friend_id == 'undefined' ? me.openedFriend : friend_id;

		// check if conversation is opened
		if (friend_id) {
			var params = {
				user_id: user_id,
				friend_id: friend_id,
				message_content: content
			};

			API.call("social.messaging", "sendMessage", params, function (response) {
				if (response.code == 10) {
					me.inputMessage.val('');
					me.getMessagesByFriend(friend_id);
				}
			});
		} else {
			Util.Popup.openForm({
				fields: [{
					label: "Friend ID",
					name: "friendId",
					type: "text"
				}],
				onSubmit: "Messaging.openFriendMessages($('#form-popup-friendId').val()); Util.Popup.close();"
			});
		}
	},

    /**
     *
     * @param form
     */
    sendMessageFromPopup:function(form) {
        var data = Util.Form.serialize($(form));

        var content = data.content;
        var friend_id = parseInt(data.friend_id);

        if(content == "") {
            Util.Popup.openWarn("message_is_empty");
            return false;
        }

        if(friend_id == "" || !friend_id) {
            Util.Popup.openWarn("general_error");
            return false;
        }

        API.call("social.messaging", "sendMessage", {message_content:content,friend_id:friend_id}, function (response) {
            if (response.code == 10) {
                Util.Popup.open({
                    content:"message_was_sent_successfully"
                })
            }
        });

    },

    /**
     *
     * @param friend_id
     */
    openMessageSendPopup:function( friend_id, friend_name ) {
        Util.Popup.openForm({
            fields:[
                {
                    label:"friend",
                    type:"info_input",
                    name:"friend_id",
                    text_field:friend_name,
                    value_field:friend_id
                },
                {
                    label:"message",
                    type:"textarea",
                    name:"content"
                }
            ],
            buttons:[
                {
                    text:"Send",
                    type:"submit"
                },
                {
                    text:"Cancel",
                    click:"close"
                }
            ],
            onSubmit:"Messaging.sendMessageFromPopup"
        });
    },


	/**
	 * @param friend_id
	 * @param target
	 */
	deleteConversationWithFriend: function (friend_id, target) {
		var me = this;
		friend_id = typeof friend_id == 'undefined' ? me.openedFriend : friend_id;

		var params = {
			user_id: Util.Cookie.get("user_id"),
			friend_id: friend_id
		};

		API.call("social.messaging", "deleteConversationWithFriend", params, function (response) {
			if (response.code == 10) {
				// remove item from conversation list
				if (target) $(target).closest('li').remove();
                $('#friend_conversation_'+friend_id).remove();
				// load last conversation
				Messaging.openLastConversation();
			} else {
				Util.Popup.openWarn('Error while deleting conversation with friend');
			}
		});
	}

};//friends_for_message



$( "#friends_for_message" ).autocomplete({
    source: function( request, response ) {

        var term = request.term;
        API.call("social.friends","searchFriends",{term:term},function(data) {

            if(data.code == 10) {
                var renderData = [];
                var data = data.data;
                for( var index in data) {
                    var current = data[index];
                    renderData.push({
                        id:current.id,
                        value:current.fullname,
                        label:current.fullname
                    });
                }
                response( renderData );
            } else {

            }

        });

    },
    minLength: 2,
    select: function( event, ui ) {
        var domElement = this;
        var item = ui.item;

        var friend_id = item.id;
        var friend_name = item.value;

        var friend_exists = $('#friend_conversation_'+friend_id);
        if(friend_exists.length) {
            Messaging.openFriendMessages(friend_id);
        }
        else {
            Messaging.openedFriend = friend_id;
            Messaging.createConversation(friend_name,friend_id);
        }
        $('#friends_for_message').val("");

        //log( ui.item ?
        //"Selected: " + ui.item.label :
        //"Nothing selected, input was " + this.value);
    },
    open: function() {
        $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
    },
    close: function() {
        $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
    }
});


$('.message-friends').css({
    'margin-top':"48px"
});