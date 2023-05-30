var Registration = {

    formID:"registrationForm",
    $form: $('form#registrationForm'),


    /**
     * Open Popup For Registration
     */
    openDialog:function(affiliateId) {


        Registration.setupValidator();
       $('#register_modal').modal('show');

        if(affiliateId) {
            $('#affiliate_id').val(affiliateId);
        }

        //Populate Countries After Popup Is Open
        API.call("common.countries","getList",{},function(response) {
            var options_html = "";
            var options_html_for_prefix = "";
            if(response.code == 10) {
                var options_responded = response.data;
                for(var k in options_responded) {
                    var cur_option = options_responded[k];
                    //Save Options HTML
                    options_html+="<option value='"+cur_option.id+"'>"+cur_option.short_name+"</option>";
                    options_html_for_prefix+="<option value='+"+cur_option.calling_code+"'>"+cur_option.short_name+" (+"+cur_option.calling_code+")</option>";
                }
                $('#core_countries_id').html(options_html);
                $('#phone_prefix').html(options_html_for_prefix);
                Util.InitSelect();
            }
        });



        //Populate Security Questions After Popup Is Opened
        API.call("user.securityquestions","getList",{},function(response) {
            var options_html = "";
            var options_html_for_prefix = "";
            if(response.code == 10) {
                var options_responded = response.data;
                for(var k in options_responded) {
                    var cur_option = options_responded[k];
                    //Save Options HTML
                    options_html+="<option value='"+cur_option.id+"'>"+cur_option.question+"</option>";
                }
                $('#core_security_question_id').html(options_html);
                Util.InitSelect();
            }
        });


        var CurrencyHTMLOptions = "";
        var CurrencyList = Currencies.list;
        for(var index in CurrencyList) {
            if(CurrencyList.hasOwnProperty(index)) {
                var cur = CurrencyList[index];
                CurrencyHTMLOptions+='<option value="'+index+'">'+cur['name']+'</option>';
            }
        }
        $('#core_currency_id').html(CurrencyHTMLOptions);



        $('label[for=terms_agree],label[for=terms_agree] a').css({
            color:'#323232'
        });
        $('label[for=terms_agree] a').css({
            color:'#2a6496'
        });


    },

    /**
     *
     */
    additionalMethods:function() {

        var me = this;

        // validate age
        $.validator.addMethod("check_date_of_birth", function(value, element) {

            var day = $("#day").val();
            var month = $("#month").val();
            var year = $("#year").val();
            var age =  21;

            var mydate = new Date();
            mydate.setFullYear(year, month-1, day);

            var currdate = new Date();
            currdate.setFullYear(currdate.getFullYear() - age);

            if( currdate > mydate ) {
                $(element).closest('.input-area').removeClass('area-error');
            } else {
                $(element).closest('.input-area').addClass('area-error');
            }
            return true;
            return currdate > mydate;

        }, "<em>Age Error</em>");


        $.validator.addMethod('validate_password', function(value, element) {
            return this.optional(element) || /^(?=.*[A-Z])(?=.*\d).*$/.test(value);
        }, "<em>"+lang_arr.password_not_valid+"</em>");

        // validate username method
        $.validator.addMethod('validate_username', function(value, element) {

            return this.optional(element) || /^[a-zA-Z0-9_\-\.]{8,20}$/i.test(value);
        }, "<em>"+Registration.errorMessage+"</em>");


        // validate address
        $.validator.addMethod('validate_address', function(value, element) {

            Registration.errorMessage = $(element).data('msg-validate_adderss');
            var regex = new XRegExp("^[a-zA-Z0-9\\p{L}][a-zA-Z0-9\\p{L},\\.;:#'\-/() ]+$");

            return this.optional(element) || regex.test(value);
            //return this.optional(element) || /^[a-z]+$/i.test(value);
        }, "<em>"+Registration.errorMessage+"</em>");


        // username exists method
        $.validator.addMethod('username_exists', function(value, element) {
            Registration.errorMessage = $(element).data('msg-username_exists');
            //$(element).closest('.input-area').removeClass('area-error area-success').addClass('loading');

            return this.optional(element) || !me.checkUsernameExists(value);

        }, "<em>"+lang_arr.username_exists+"</em>");

        // email exists method
        $.validator.addMethod('email_exists', function(value, element) {
            //Registration.errorMessage = $(element).data('msg-email_exists');
            //$(element).closest('.input-area').addClass('loading');
            return this.optional(element) || !me.checkUserEmailExists(value);

        }, "<em>"+lang_arr.email_exists+"</em>");

        // mobile exists method
        $.validator.addMethod('mobile_exists', function(value, element) {
            Registration.errorMessage = $(element).data('msg-username_exists');
            //$(element).closest('.input-area').addClass('loading');
            //value = $('#mobilePrefix').val()+value;
            return this.optional(element) || !me.checkUserPhoneExists($('#phone_prefix').val()+value);

        }, "<em>"+lang_arr.phone_exists+"</em>");

    },


    /**
     *
     * @returns {{username: {required: boolean, minlength: number, maxlength: number}, fullname: {required: boolean}, gender: {required: boolean}, birthdate: {required: boolean}, email: {required: boolean, email: boolean}, core_countries_id: {required: boolean}, city: {required: boolean}, address: {required: boolean}, phone: {required: boolean}, password: {required: boolean, minlength: number, maxlength: number}, password_confirm: {required: boolean, equalTo: string}}}
     */
    setupRules: function() {
        var me = this;
        me.additionalMethods();

        return {
            username: {
                required: true,
                username_exists:true,
                minlength: 4,
                maxlength: 20
            },

            first_name: {
                required: true
            },

            last_name: {
                required: true
            },

            gender: {
                required: true
            },


            birthdate: {
                required: true,
                check_date_of_birth: true
            },

            email: {
                required: true,
                email_exists:true,
                email: true
            },

            core_countries_id: {
                required: true
            },

            city: {
                required: true
            },

            address: {
                required: true
            },

            zip_code: {
                required: true
            },

            phone: {
                required: true,
                mobile_exists:true
            },

            password: {
                required: true,
                minlength: 8,
                validate_password:true,
                maxlength: 20
            },
            password_confirm: {
                required: true,
                equalTo: '#password'
            }
        };
    },

    /**
     *
     */
    setupValidator : function() {

        var self = this;

        this.$form.validate({

            errorElement: 'div',

            highlight: function(element) {
                $(element).closest('.form-group').removeClass('is-valid').addClass('with-error');
            },

            unhighlight: function(element) {
                $(element).closest('.form-group').removeClass('with-error');
            },

            success: function(label, element) {
                $(element).closest('.form-group').addClass('is-valid');
            },

            rules: self.setupRules()
        });
    },


    /**
     * Submit Registraton Form
     * @param form
     */
    submit:function(form) {

        var data = Util.Form.serialize($(form));
        data.phone = data.phone_prefix+""+data.phone;

        if(!$('#terms_agree').is(":checked")) {
            $('label[for=terms_agree],label[for=terms_agree] a').css({
                color:'red'
            });
            setTimeout(function() {
                $('label[for=terms_agree],label[for=terms_agree] a').css({
                    color:'#323232'
                });
                $('label[for=terms_agree] a').css({
                    color:'#2a6496'
                });
            },2500);
            return false;
        }

        API.call("user.registration","submit",data,function(response) {
            if(response.code == 10) {
                document.getElementById('registrationForm').reset();
                $('#register_modal').modal('hide');

                Session.showLoginPopup(true);


                //Session.login(false,data.username,data.password);

            }
            else if(response.code == -89) {
                console.log("okokokok");
                Util.Popup.open({
                    title:"Can not register new user",
                    content:'User with same first name, last name, birth day and country of residence is already registered!'
                });
            }


            else {

                alert(JSON.stringify(response));

                $('.error').text('');
                $('.errors').text('');

                var errors = response.errors;

                for( var i in errors) {
                    var curError = errors[i];
                    if(curError.length>0) {

                        var errors_string = "";

                        for(var j in curError) {
                            errors_string += "<p>"+curError[j]+"</p>";
                        }

                        $('.field_'+i).find(".error").html(errors_string);
                        $('.field_'+i).find(".errors").html(errors_string);

                    }
                }


            }
        });
    },


    /**
     * Check if username is already taken
     * @param username
     * @returns {boolean}
     */
    checkUsernameExists:function(username) {
        var exists = false;
        API.call("user.registration","usernameExists",{username:username},function(response) {
            exists = response.exists;
        },false,false);
        return exists;
    },


    /**
     * Check if email is already taken
     * @param email
     * @returns {boolean}
     */
    checkUserEmailExists:function(email) {
        var exists = false;
        API.call("user.registration","emailExists",{email:email},function(response) {
            exists = response.exists;
        },false,false);
        return exists;
    },

    
    /**
     * Check if phone is already taken
     * @param phone
     * @returns {boolean}
     */
    checkUserPhoneExists:function(phone) {
        var exists = false;
        API.call("user.registration","phoneExists",{phone:phone},function(response) {
            exists = response.exists;
        },false,false);
        return exists;
    },


    /**
     * Check Whether registration from provided country is allowed
     * @param country_id
     */
    checkProhibition:function(country_id) {
        var prohibided = [236,235];
        var country_id = parseInt(country_id);
        if(prohibided.indexOf(country_id)!=-1) {
            $('#register_modal').modal('hide');
            Util.Popup.open({
                content:lang_arr['registration_from_country_prohibited']
            });
        }



        if(country_id == 70) {
            setDatePicker(21);
        }



    }



};


$('#core_countries_id').change(function(val) {

    //Checks If Chosen Country Is Not Allowed For Register
    Registration.checkProhibition($(this).val());


});


function setDatePicker(age) {
    var start = new Date();
    start.setFullYear(start.getFullYear() - 70);
    var end = new Date();
    end.setFullYear(end.getFullYear() - age);

    var params = {
        dateFormat:"yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        minDate: start,
        maxDate: end,
        yearRange: start.getFullYear() + ':' + end.getFullYear()
    };

    console.log(params);
    $('#birthdate').datepicker(params);
}
setDatePicker(18);






