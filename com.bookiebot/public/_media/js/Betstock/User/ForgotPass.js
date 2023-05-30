var ForgotPass = {

    //Start Password Reset
    openDialog:function() {
        var me = this;

        Util.Popup.openForm({
            title:"Recover Password",
            description:"password_recovery_description",
            fields:[
                {
                    name:"email",
                    type:"text",
                    label:"enter_mail",
                    validation:{
                        required:true,
                        email:true
                    }
                }
            ],
            onSubmit:"ForgotPass.initReset"
        });
        return false;
    },

    /**
     *
     * @param form
     */
    initReset:function(form) {
        var data = Util.Form.serialize($(form));
        var me = this;
        var params = {
            email:data.email
        };
        API.call("user.resetpassword","initReset",params,function(response) {
            if(response.code == 10) {
                var username = response.data.username;
                Util.Popup.openForm({
                    title:"Recover Password",
                    description:"pass_reset_email_was_sent_to_user",
                    fields:[
                        {
                            name:"username",
                            type:"text",
                            value:username,
                            label:"username",
                            disabled:true
                        },
                        {
                            name:"security_code",
                            type:"text",
                            placeholder:"enter_security_code",
                            label:"enter_security_code",
                            validation:{
                                required:true
                            }
                        },
                        {
                            name:"new_password",
                            type:"password",
                            placeholder:"enter_password",
                            label:"new_password",
                            validation:{
                                required:true,
                                validate_password:true
                            }
                        },
                        {
                            name:"confirm_new_password",
                            type:"password",
                            placeholder:"enter_password_confirmation",
                            label:"confirm_new_password",
                            validation:{
                                required:true,
                                equalTo: '#form-popup-new_password'
                            }
                        }
                    ],
                    validate_functions:function() {
                        $.validator.addMethod('validate_password', function(value, element) {
                            return this.optional(element) || /^(?=.*[A-Z])(?=.*\d).*$/.test(value);
                        }, "<em>"+lang_arr.password_not_valid+"</em>");
                    },
                    onSubmit:"ForgotPass.resetPass"
                });
            } else {

                Util.Popup.openWarn(lang_arr["provided_email_was_not_found"]);
            }

        });
    },

    /**
     *
     * @param form
     */
    resetPass:function(form) {
        var me = this;

        var data = Util.Form.serialize($(form));
        if(data.new_password == data.confirm_new_password) {
            var params = {
                security_code:data.security_code,
                password:data.new_password
            };

            API.call("user.resetpassword","resetPass",params,function(response) {
                if(response.code == 10) {
                    Util.Popup.open({
                        content:lang_arr['pasword_was_changed_successfully']
                    });
                } else {
                    if(response.hasOwnProperty('msg')) {
                        Util.Popup.openWarn(response['msg']);
                        return false;
                    }
                    Util.Popup.openWarn(lang_arr['try_again']);
                }
            });
        } else {
            Util.Popup.openWarn(lang_arr['try_again']);
        }

    }








};