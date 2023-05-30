var Session = {

	GeoLocationData:null,

	userData: null,

	loginForm: $('#loginForm'),
	loggedIn: $('.loggedIn'),

	realityCheckInterval:null,
	isRealityPopupOpened:false,


	checkRealitySession:function() {
		var me = this;
		var session_start_time = parseInt(Util.Cookie.get('session_start'));
		var now = moment().unix();



		if(session_start_time && !isNaN(session_start_time)) {
			var passed_seconds = now-session_start_time;
			if(passed_seconds >= 60*60) {


				if(me.realityCheckInterval) {
					clearInterval(me.realityCheckInterval);
				}

				API.call("betting.bets", "getBetsForCurrentSesion", {user_id: parseInt(Util.Cookie.get('user_id'))}, function (response) {


					var message = "You are playing more then 60 minutes. Do you want to continue current session or Logout? ";

					if(response.code == 10) {
						message+='<br/><br/> During this session, your balance was changed by ('+(response['amounts']/100)+' Euros) amount with wins and losses.<br/><br/>Closing this window will log you out!';
					}



					//Get Detils For Current Session
					Util.Popup.open({
						content:message,
						buttons:[
							{
								text:"Continue",
								click:"Session.increaseRealityCheckSession();Util.Popup.close();Session.isRealityPopupOpened=false;"
							},
							{
								text:"Log Out",
								click:"Session.logout();Util.Popup.close();Session.isRealityPopupOpened=false;"
							}
						],
						onCloseAction:"Session.checkImplicitCloseRealCheckPopup();Session.isRealityPopupOpened=false;"
					});
				});



			}


		}
	},


	checkImplicitCloseRealCheckPopup:function() {
		console.log("checkImplicitCloseRealCheckPopup");
		var session_start_time = parseInt(Util.Cookie.get('session_start'));
		var now = moment().unix();
		var passed_seconds = now-session_start_time;
		if(passed_seconds >= 60*45) {
			Session.logout();
		}

	},

	/**
	 *
     */
	increaseRealityCheckSession:function() {

		console.log("increaseRealityCheckSession");
		var me = this;

		if(me.realityCheckInterval) {
			clearInterval(me.realityCheckInterval);
			Util.Cookie.set('session_start',moment().unix());
			me.realityCheckInterval = setInterval(function() {
				Session.checkRealitySession();
			},1000);
		}


	},


    /**
     *
     */
	init: function (cb) {

		if(!cb) {
			cb = function() {}
		}

		var me = Session;



		var user_id = Util.Cookie.get("user_id");
		if (user_id) {
			API.call("user.session", "checkSession", {user_id: user_id}, function (response) {

				if (response.code == 10) {


					if(user_id == 3 || user_id ==1) {
						$('#OpenKeno').removeClass("hidden");
					}
					me.realityCheckInterval = setInterval(function() {
						Session.checkRealitySession();
					},1000);

					me.startSession(response);
					cb();
				}
				else {
					var okAction = "Session.logout();";
					if(response.code == 31) {
						okAction = 'Util.Popup.close();';
					}


					if(response.msg) {
						Util.Popup.open({
							content:response.msg,
							buttons:[
								{
									text:"Ok",
									click:okAction
								}
							]
						});
						setTimeout(function() {
							me.logout();
						},3000);
					} else {
						me.logout();
					}

					cb();


				}
			});
		}

		else {
			me.dieSession();
			cb();
		}

		//If Page Has Callback
		if (typeof pageCallback != "undefined") {
			if (callBackParams == undefined) {
				var callBackParams = null;
			}
			Util.callFunc(pageCallback, window, callBackParams);
		}





	},

	/**
	 *
     */
    getUsersOpenedBets:function() {

        API.call("betting.bets", "getUsersOpenedBets", {}, function (response) {
            var betSlipStore = App.getStore('betslip');
            if (response.code == 10) {
                //Opened Bets Rendering ##IKA
                var opened_bets = response.data;

                betSlipStore.store.opened.back = {};
                betSlipStore.store.opened.lay = {};
				console.log("remove");


                betSlipStore.setOpenedBets(opened_bets);

            } else {
                betSlipStore.store.opened.back = {};
                betSlipStore.store.opened.lay = {};
                betSlipStore.setOpenedBets([]);

            }
        });
    },

	/**
	 *
     */
    getUsersReceivedBets:function() {
        API.call("betting.bets", "getUsersReceivedBets", {}, function (response) {

            var betSlipStore = App.getStore('betslip');

            if (response.code == 10) {
                var received_bets = response.data;
                betSlipStore.store.received.back = {};
                betSlipStore.store.received.lay = {};
                betSlipStore.setReceivedBets(received_bets);
            } else {

                betSlipStore.store.opened.back = {};
                betSlipStore.store.opened.lay = {};
                betSlipStore.setReceivedBets([]);
            }
        });
    },


    /**
     *
     * @param form
     * @param username
     * @param password
     * @param fromRegistration
     * @returns {boolean}
     */
	login: function (form, username, password, fromRegistration, callback) {
		var me = Session,
			params;
		Util.Popup.close();
		if (form) {
			form = $(form);
			params = Util.Form.serialize(form);
		} else {
			params = {username: username, password: password};
		}

		if (params.username == "" || params.password == "") {
            Util.Popup.open({
               content: lang_arr['fields_are_empty']
            });
			return false;
		}

        Util.addLoader(me.loginForm);

		API.call("user.session", "login", params, function (response) {
            Util.removeLoader(me.loginForm);
			if (response.code == 10) {


                Util.Cookie.set("username", response.user.username);
                Util.Cookie.set("session_start", moment().unix());
                Util.Cookie.set("fullname", response.user.fullname);


				me.init();

                //If User Starts Session After Registration We Should Redirect To Deposit Money
                if (fromRegistration) {
                     window.location.href = base_href+"/"+cur_lang+"/user/balance_management#afterregistration";
                }


				// check if page is social
				if ($('body').hasClass('page-social-not')) {
					location.reload();
				}
			}

            //Ip Is Blocked For Current User
            else if(response.code == -2) {
                var message = lang_arr['ip_restriction_login_text'].replace("{ip}",response.ip).replace("{expires_at}",response.restriction_expiry_time);
                Util.Popup.open({
                    content: message
                });
            }

            //Ip Is Blocked For Current User
            else if(response.code == -65) {
                var message = response.msg;

                Util.Popup.open({
                    content: message
                });
            }

            //Time Out
            else if(response.code == -89) {
                var message = lang_arr['protection']['time_out_text'].replace("{expire_date}",response['protection'].expire_date);

                Util.Popup.open({
                    content: message
                });
            }

            //Self Exclusion
            else if(response.code == -185) {
                var message = response.msg;

                Util.Popup.open({
                    content: message
                });
            }


            else if(response.code == -85) {
                var message = response.msg;
                var expires = response.expires;

                Util.Popup.open({
                    content: message+"<br/> Expiration date: "+response['protection']['expire_date']
                });
            }

            else {
                Util.Popup.open({
                    content: lang_arr['wrong_password_or_username']
                });
			}
		});
	},

    /**
     *
     */
	getFbLoginUrl: function () {
		API.call("user.session", "getFbLoginUrl", {}, function (response) {
			console.log(response);
			setTimeout(function () {
				window.location.href = response.url;
			}, 15000);

		});
	},


    /**
     *
     */
	logout: function () {
		var Me = this;


		if(Me.realityCheckInterval) {
			clearInterval(Me.realityCheckInterval);
		}

		API.call("user.session", "logout",{},function(response) {

			try {
				if(response.success == true) {

					Me.dieSession();
				}
			}catch(e) {
				Util.Popup.open({
					content:"Cant kill session please try again!"
				});

			}


		});

	},

    /**
     *
     * @param userData
     * @returns {boolean}
     */
	startSession: function (sessionData) {
		var me = Session;

        var userData = sessionData.user;
		if (!userData.id) {
			return false;
		}


		var CurrencyIcon = Currencies.list[sessionData.user.core_currencies_id].icon;




		$('#profile_pic').attr('src', userData.thumb);
		$('#friendsBets').removeClass("hidden");

		$('#forgot_register').hide();
		var balance = parseFloat(userData.balance / 100).toFixed(2);

		$('.u_balance').removeClass('hidden').html('' +
			'<strong class="glyphicon glyphicon-refresh" onclick="Session.init();" style="cursor:pointer"></strong> ' +
			'<strong>'+lang_arr['balance']+': ' + balance + " "+CurrencyIcon+"</strong>" +
		"");

		$('#userData').html("<span class='profile-label'>"+lang_arr['welcome']+", </span> <a class='profile-label bold cap blue' href='" + base_href + "/" + cur_lang + "/user/settings'>" + userData.username + " </a>&nbsp;&nbsp;UserId:" + userData.id + "");
		$('#userData').show().removeClass("hidden");
        $('.betslip_tab').removeClass("hidden");
		me.loginForm.addClass('hidden');
		me.loggedIn.removeClass('hidden');

		me.getNotifications();
		me.userData = userData;


        me.getUsersOpenedBets();
        me.getUsersReceivedBets();

	},

    /**
     *
     */
	showEmailConfirmationPopup: function () {
		$('#email_to_confirm').html("<strong>" + Session.userData.email + "</strong>");
		$('#email_confirmation').modal('show');
	},

    /**
     *
     */
	dieSession: function () {


		$('#friendsBets').addClass("hidden");
		$('.fav_tournament').remove();
		Util.Cookie.remove("user_id");
		Util.Cookie.remove("username");
		Util.Cookie.remove("fullname");
		Util.Cookie.remove("session_start");
		Util.Cookie.remove("currency_id");
		Util.Cookie.remove("currency_code");
		Util.Cookie.remove("currency_name");

		this.loginForm.removeClass('hidden');
		this.loggedIn.addClass('hidden');
        $('.betslip_tab').addClass("hidden");
		$('#forgot_register').show();
		$('#userData').html("").addClass("hidden");
		$('#forgot_register').removeClass("hidden");

		$('.u_balance').addClass('hidden');


		Session.userData = null;

		if (needs_authentication) {
			Util.redirectToMain();
		}



        $('#loginForm').find("input").val("");
        $('#betslip-1-clicker').click();
	},

    /**
     *
     */
	getNotifications: function () {
		var user_id = Util.Cookie.get("user_id");
		API.call("user.session", "notifications", {user_id: user_id}, function (response) {
            if(response.code == 10) {
                var total_notifications = 0;

                if(response.data.friend_requests) {
                    total_notifications += response.data.friend_requests;
                }

                if(response.data.new_messages_count) {
                    total_notifications += response.data.new_messages_count;
                }

                if(total_notifications>0) {
                    $('.notifications_badge').text(total_notifications);
                }
            }
//            console.log(response);
		});
	},


	/**
	 *
	 */
	showLoginPopup:function(fromReg) {
		var LoginText = "Please authorise in system!";
		if(fromReg) {
			LoginText = "" +
				"Registration was successfull please log in now!" +
				"<p style='margin-top:7px;font-size:12px;line-height:1.5em'>Note: email verification was sent on your email.<br> To activate your account please check our message in your inbox.</p>";
		}

		//Open Form Popup
		Util.Popup.openForm({
			title: LoginText,
			fields: [
				{
					name: "fromReg",
					type: "hidden",
					value:fromReg
				},
				{
					name: "username",
					type: "text",
					label:"Username or email",
					validation:{
						required:true
					}
				},
				{
					name: "password",
					label:"password",
					type: "password",
					validation:{
						required:true
					}
				}
			],
			onSubmit: "Session.handlePopupLogin"
		});
	},


	handlePopupLogin:function(form) {
		var data = Util.Form.serialize($(form));
		Session.login(false,data['username'],data['password'],function() {
			try {
				if(data['fromReg'] || data['fromReg'] == 'true' || data['fromReg'] == true) {
					Util.Popup.open({
						content: lang_arr['registration_success']
					});
				}
			}catch(e) {
				console.log(e);
			}

		});
	},



	/**
	 *
	 * @param provider_id
	 * @param cb
     */
	generateProviderToken:function(provider_id,cb) {
		API.call("user.tokens","generateToken",{provider_id:provider_id},function(response) {

			try {
				if(response.code == 10) {
					cb(false,response.token);
				} else {
					cb(true,"Cant generate token");
				}
			}catch(e) {
				cb(true,e);
			}

		},function() {
			cb(true,"Cant generate token");
		});
	}



};