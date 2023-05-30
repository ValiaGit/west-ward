var Settings;
Settings = {

    //Get User Info
    getUserInfo: function () {
        var me = this;
        var user_id = Util.Cookie.get("user_id");
        API.call("user.settings", "getUserInfo", {user_id: user_id}, function (response) {
            var data;
            data = response.data;

            $('.confirmation-label').addClass("hidden");

            var is_email_confirmed = data.is_email_confirmed;
            if(is_email_confirmed) {
                $('.email-yes').removeClass("hidden");
            } else {
                $('.email-not').removeClass("hidden");
            }

            var is_phone_confirmed = data.is_phone_confirmed;
            if(is_phone_confirmed) {
                $('.phone-yes').removeClass("hidden");
            } else {
                $('.phone-not').removeClass("hidden");
            }


            var country_index = $("select#field_country").find("option[value="+data.cId+"]").index();
            $("select#field_country").prop('selectedIndex', country_index);


            var privacy_index = $("select#bet_privacy").find("option[value="+data.bet_privacy+"]").index();
            $("select#bet_privacy").prop('selectedIndex', privacy_index);


            var name_privacy_index = $("select#name_privacy").find("option[value="+data.name_privacy+"]").index();
            $("select#name_privacy").prop('selectedIndex', name_privacy_index);

            $('select.custom-select').select2({
                minimumResultsForSearch: -1

            }).on("change", function(e) {
                    //alert('opened');
                    $('.select2-container').removeClass('select2-container-active');
                });

            $('#field_first_name').val(data.first_name);
            $('#field_last_name').val(data.last_name);
            $('#field_username').val(data.username);
            $('#field_nickname').val(data.nickname);
            $('#field_phone').val(data.phone);
            $('#field_email').val(data.email);
            $('#field_address').val(data.address);
            $('#field_city').val(data.city);
            $('#field_birthdate').val(data.birthdate);


            if(data.thumbnail!="") {
                $('#profile_thumb').attr("src",data.thumbnail);
            }


            me.getUserDocuments();
            // console.log(data);
        });



    },



    getUserDocuments:function() {
        var user_id = Util.Cookie.get("user_id");
        API.call("user.settings","getUserDocuments",{user_id:user_id},function(response) {
            var tbody = $('#personalDocuments');
            html = "";
            if(response.code == 10) {
                var data = response.data;
                for(var index in data) {

                    var current = data[index];
                    var type = lang_arr['doc_'+current.identity_type];
                    var has_uploaded = current.has_uploaded;
                    if(!has_uploaded) {
                        has_uploaded = '<button class="btn btn-dark-blue" onclick="Settings.openDocumentUploadForm('+current.id+');return false;">'+lang_arr['upload_copy']+'</button>';
                    } else {
                        has_uploaded = lang_arr['uploaded'];
                    }

                    if(current.IsVerified) {
                        var verified = lang_arr['verified'];
                    } else {
                        var verified = lang_arr['unverified'];
                    }

                    console.log(has_uploaded);
                    html+="<tr>" +
                        "<td>"+current.country+"</td>" +
                        "<td>"+current.date_modified+"</td>" +
                        "<td>"+type+"</td>" +
                        "<td>"+current.document_number+"</td>" +
                        "<td>"+verified+"</td>" +
                        "<td>"+has_uploaded+"</td>" +
                        "</tr>";
                }
                tbody.html(html);
                $('#user_documents_table').show();
                tbody.closest('div').find('.empty_message').addClass("hidden");
            }

            if(response.code == 60) {
                $('#user_documents_table').hide();
                tbody.closest('div').find('.empty_message').html("<h4 style='padding-left:7px;font-size:14px'>"+lang_arr['have_not_Added_documents']+"</h4>").removeClass("hidden");
            }

        });
    },



    /////////////////// ADD NEW DOCUMENTS
    openAddNewDocument:function() {

        Util.Popup.openForm({
            title:"Add ID Document",
            fields:[
                {
                    name:"document_type",
                    type:"select",
                    label:"document_type",
                    options:[
                        {
                            option_value:"3",
                            option_name:"personal_id"
                        },
                        {
                            option_value:"2",
                            option_name:"driving_licence"
                        },
                        {
                            option_value:1,
                            option_name:"passport"
                        }

                    ]

                },
                {
                    name:"document_number",
                    label:"document_number"
                },
                {
                    name:"core_countries_id",
                    type:"select",
                    label:"issuer_country",
                    ajax:{
                        service_name:"common.countries",
                        method_name:"getList",
                        parameters:{},
                        mapping:{
                            "option_name":"short_name",
                            "option_value":"id"
                        }
                    }
                }
            ],
            onSubmit:"Settings.addDocument"
        });


    },

    addDocument:function(form) {
        var me = this;
        var formData = Util.Form.serialize($(form));
        formData.user_id = Util.Cookie.get("user_id");
        API.call("user.settings","addDocument",formData,function(response) {
            if(response.code == 10) {
                me.getUserDocuments();
                Util.Popup.open({
                    content:lang_arr['success']
                });
            }
        })
    },

    openDocumentUploadForm:function(documentId) {
         var formHTML = '<form onsubmit="Settings.upLoadDocumentImage(this);return false;">' +
             '<input type="hidden" value="'+documentId+'" name="document_id"> ' +
             '<input type="file" class="form-control input-default" name="file"> ' +
             '<br>' +
             '<input type="submit" class="btn btn-block btn-dark-blue" name="submit" value="'+lang_arr['upload']+'">' +
             '</form>';


        Util.Popup.open({
            title:lang_arr['upload_id_document'],
            content:formHTML,
            noButton:true
        });
         return formHTML;
    },

    upLoadDocumentImage:function(form) {
        var me = this;
        var formData = Util.Form.serializeUploadForm(form);
        API.callWithMimeFile("user.settings","addDocumentFile",formData,function(response) {
          if(response.code == 10) {
              me.getUserDocuments();
              Util.Popup.open({
                  content:lang_arr['success']
              });
          } else {
            var Message = "Error Happened";
              if(response.hasOwnProperty("msg")) {
                  Message = response['msg'];
              }
              Util.Popup.open({
                  content:Message
              });
          }
        });
    },
    /////////////////// ADD NEW DOCUMENTS


    //Update user info
    updateUserInfo: function (form) {
        var parameters = Util.Form.serialize(form);
        parameters.user_id = Util.Cookie.get("user_id");


        var me = this;

        API.call("user.settings", "updateUserInfo", parameters, function (response) {
            console.log(response);

            if(response.code == 10) {
                me.getUserInfo();
                var message = lang_arr['information_was_updated_successfully'];
                $('#field_password').val("");

                if(response.email_change) {
                    message = message+"<br/>"+lang_arr['email_was_changed_has_to_be_confirmed'];
                }
                Util.Popup.open({
                    content:message
                });
            } else {
                Util.Popup.open({
                    content:response.msg
                });
            }
        });
    },

    //Change User Profile Picture
    updateProfileImage:function(form) {
        var formData = Util.Form.serializeUploadForm(form);
        API.callWithMimeFile("user.settings","updateProfileImage",formData,function(response) {
            if(response.code == 10) {
                var message = lang_arr['information_was_updated_successfully'];
                Util.Popup.open({
                    content:message
                });
                $("#profile_thumb").attr("src", response.data.thumb);
                $("#profile_pic").attr("src", response.data.thumb);
            }
        });

    },




    InitPhoneVerification:function() {
        var phone = $('#field_phone').val();
        API.call("user.settings","sendPhoneVerification",{phone:phone},function(response) {
            if(response.code == 10) {
                Util.Popup.openForm({
                    title:"phone_confirmation",
                    description:"confirmation_code_was_sent_on_your_mobile",
                    fields:[
                        {
                            label:"Phone",
                            value:phone,
                            name:"phone",
                            type:"text",
                            disabled:true
                        },{
                            label:"confirmation_code",
                            name:"code"
                        }
                    ],
                    onSubmit:"Settings.VerifyPhone"
                });
            }

            else {
                Util.Popup.open({
                    content:response['msg']
                })
            }
        });
    },

    VerifyPhone:function(form) {
        var data = Util.Form.serialize($(form));
        API.call("user.settings","verifyPhoneNumber",{code:data.code},function(response) {
            if(response.code == 10) {
                Settings.getUserInfo();
                Util.Popup.close();
            } else {
                Util.Popup.openWarn(response.code);
            }
        });
    },



    InitEmailVerification:function() {
        var email = $('#field_email').val();
        API.call("user.settings","sendEmailVerification",{email:email},function(response) {
            if(response.code == 10) {
                Util.Popup.openForm({
                    title:"email_confirmation",
                    description:"confirmation_code_was_sent_on_your_email",
                    fields:[
                        {
                            label:"Email",
                            value:email,
                            name:"email",
                            type:"text",
                            disabled:true
                        },{
                            label:"confirmation_code",
                            name:"code"
                        }
                    ],
                    onSubmit:"Settings.VerifyEmail"
                });
            }

            else {
                Util.Popup.open({
                    content:response['msg']
                })
            }
        });
    },

    VerifyEmail:function(form) {
        var data = Util.Form.serialize($(form));
        API.call("user.settings","verifyEmail",{code:data.code},function(response) {
            if(response.code == 10) {
                Settings.getUserInfo();
                Util.Popup.close();
            } else {
                Util.Popup.openWarn(response.code);
            }
        });
    },


    changePassword: function (form) {
        var data = Util.Form.serialize($(form));
        data.user_id = Util.Cookie.get("user_id");

        //If Fields Are Empty
        if(data.old_password == "" || data.new_password == "" || data.confirm_new_password == "") {
            var message = lang_arr['fields_are_empty'];
            Util.Popup.open({
                content:message
            });
            return  false;
        }


        //If New pAssword Confirmation Is Wrong
        if(data.new_password!=data.confirm_new_password) {
            var message = lang_arr['passwords_dont_match'];
            Util.Popup.open({
                content:message
            });
            return  false;
        }


        API.call("user.settings", "changePassword", data, function (response) {
            if(response.code == 10) {
                var message = lang_arr['information_was_updated_successfully'];
                Util.Popup.open({
                    content:message
                });
            } else {


                if(response.hasOwnProperty("msg")) {
                    Util.Popup.open({
                        content:response['msg']
                    });
                } else {
                    Util.Popup.open({
                        content:"Can not change password please try again!"
                    });
                }

                document.getElementById('changePasswordForm').reset();
            }
        });

    },


    updatePrivacyInfo:function() {
        var user_id = Util.Cookie.get("user_id");

        var privacy_form = $('#privacy_form');
        var data = Util.Form.serialize(privacy_form);
        data.user_id = user_id;

        API.call("user.settings","updatePrivacyInfo",data,function(response) {
            if( response.code == 10 ) {
                Util.Popup.open({
                    content:lang_arr['privacy_update_success']
                });
            }
            else {

            }
        });
        console.log(user_id);
    },


    sendEmailVerification:function() {
        var user_id = Util.Cookie.get("user_id");
        //sendAndSaveEmailConfirmation
        API.call("user.settings","sendEmailVerification",{user_id:user_id},function(response) {
            if(response.code == 10) {
                Util.Popup.open({
                    content:lang_arr['confirmation_code_was_sent_successfully_please_check_email']
                },true);
            }
        });
    }

};