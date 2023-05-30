var Protection = {

    dom:{
        select:$('#protection_types')
    },

    has_protections:null,

    /**
     *
     */
    init:function() {
        var me = this;
        me.dom.select.change(function(event) {
            me.show_protection_type($(this).val());
        });
    },

    /**
     * Crwating New Protection
     * @param form
     */
    addProtection:function(form) {

        var data = Util.Form.serialize($(form));
        data.user_id = Util.Cookie.get("user_id");

        API.call("user.protection","makeProtectionChange",data,function(response) {
            if(response.code == 10) {



                var onCloseAction = 'Util.Popup.close();Protection.getProtectionTypes();';
                try {
                    if(data.core_protection_types_id == 3 || data.core_protection_types_id == 1) {
                        onCloseAction = "Session.logout();";
                    }
                }catch(e) {
                    console.log(e);
                }
                var buttons = [
                    {
                        text:"Ok",
                        click:onCloseAction
                    }
                ];


                if(data.core_protection_types_id == 6) {
                    buttons.push(
                        {
                            text:"Logout to take affect",
                            click:"Protection.logoutToTakeAffect();"
                        }
                    );
                }


                Util.Popup.open({
                    content:lang_arr['protection']['type_'+data.core_protection_types_id+'_success'],
                    buttons:buttons,
                    onCloseAction:onCloseAction
                });

            }

            else {
                try {
                    Util.Popup.open({
                        content: response['msg']
                    });
                }catch(e) {
                    Util.Popup.open({
                        content: response
                    });
                }

            }
        });

    },

    logoutToTakeAffect:function() {
        Session.logout();
    },



    /**
     *
     * @param buttonElem
     */
    disableProtection:function(buttonElem) {
        var Me = this;
        var button = $(buttonElem);
        var protection_id = button.closest('.tab-pane').attr("data-id");
        var type_id = button.closest('.tab-pane').attr("id").split("pr")[1];

        API.call("user.protection","disableProtection",{protection_id:protection_id,type_id:type_id},function(response) {
            console.log(response);
            if(response.code == 10) {
                Util.Popup.open({
                    content:lang_arr['protection']['type_'+type_id+'_success'],
                    buttons:[
                        {
                            text:"ok",
                            click:"Util.Popup.close();Protection.getProtectionTypes();return false;"
                        }
                    ]
                });
            }  else {

            }
        });
    },

    /**
     *
     */
    callJob:function() {
        API.call("user.protection","jobHandles",{},function(response) {
            console.log(response);
        });
    },

    /**
     *
     */
    getProtectionTypes:function() {
        var data = {user_id:Util.Cookie.get("user_id")};

        API.call("user.protection","getProtections",data,function(response) {
            if(response.code == 10) {
                if(response.has_protections) {
                    var protections_array = response['protections'];
                    for(var i in protections_array) {
                        if(protections_array.hasOwnProperty(i)) {
                            var current = protections_array[i];

                            var core_protection_types_id = current['core_protection_types_id'];

                            var tab_click_selector = $('a[aria-controls=pr'+core_protection_types_id+']');
                            var old_text = tab_click_selector.text();
                            if(old_text.indexOf("(")) {
                                old_text = old_text.split(" (")[0];
                            }



                            var protection_id = current['protection_id'];
                            var period_id = current['period_id'];


                            var is_in_action_queue = current['is_in_action_queue'];
                            var queue_action_type = current['queue_action_type'];


                            var expire_date = current['expire_date'];
                            var amount = parseFloat(current['amount'])/100;

                            var protection_tab_pane = $('#pr'+core_protection_types_id);


                            var period_select = protection_tab_pane.find("select.period");
                            period_select.val(period_id);

                            var PeriodText = "";
                            try {
                                PeriodText = period_select.find('option[value='+period_id+']').text();
                            }catch(e) {
                                console.log(e);
                            }

                            if(core_protection_types_id == 6) {
                                protection_tab_pane.find(".period_minutes").val(current['period_minutes']);
                            }

                            protection_tab_pane.find(".amount-input").val(amount);
                            protection_tab_pane.find(".expiry_date_Val").text(expire_date);

                            protection_tab_pane.attr("data-id",protection_id).attr('data-expire',expire_date);

                            if(is_in_action_queue) {





                                //Requested Protection Modification
                                if(queue_action_type == 1) {
                                    var protectionText ="<strong>Protection Status</strong>: In Update Queue";
                                    var queue_affect_time = current['queue_affect_time'];
                                    var queue_amount = current['queue_amount']/100;
                                    var queue_period_id = current['queue_period_id'];
                                    try {
                                        PeriodText = period_select.find('option[value='+queue_period_id+']').text();
                                    }catch(e) {

                                    }

                                    if(core_protection_types_id == 6) {
                                        protectionText+="<br/> <strong>Requested Session:</strong>  "+current['queue_interval_minutes']+" Minutes";
                                    } else {
                                        protectionText+="<br/> <strong>Requested Amount:</strong> €"+queue_amount+"  "+PeriodText;
                                    }

                                    protectionText+="<br/> <strong>Will take affect after:</strong> "+queue_affect_time+"  ";


                                    tab_click_selector.text("");
                                    tab_click_selector.text(old_text+" (In Update Queue)");
                                }

                                //Requested Queue Disable
                                else {
                                    var protectionText ="<strong>Protection Status</strong>: In Disable Queue";
                                    var queue_affect_time = current['queue_affect_time'];


                                    tab_click_selector.text("");
                                    tab_click_selector.text(old_text+" (In Disable Queue)");

                                    protectionText+="<br/> <strong>Will take affect after:</strong> "+queue_affect_time+"  ";

                                    protection_tab_pane.find('.disable-button').hide();


                                }




                            }


                            else {

                                tab_click_selector.text("");
                                tab_click_selector.text(old_text+" (Active)");

                                var protectionText ="<strong>Protection Status</strong>: Active";
                                if(amount && amount!="") {
                                    protectionText+="<br/>€"+amount+"  "+PeriodText;
                                } else {
                                    protectionText+="<br/>"+PeriodText
                                }


                                protection_tab_pane.find('.disable-button').show();
                            }



                            protection_tab_pane.find('.is-active-alert').removeClass('hidden').find('.protection_status_text').html(protectionText);







                        }

                    }



                }
            }



        });


    },


    /**
     *
     * @param type_id
     */
    show_protection_type:function(type_id) {
        $('.protection-group').addClass("hidden");

        $('#protection-group-'+type_id).removeClass("hidden");

        console.log(type_id);
    }

};

Protection.init();
