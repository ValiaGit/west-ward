var Util = {

    redirectToMain: function () {
        window.location.href = base_href + "/" + cur_lang;
    },

    Cookie: {

        set: function (key, value, expireDays) {

            //$.cookie(key, value,{ path: '/' });
            if (expireDays) {
                var date = new Date(new Date().getTime() + parseInt(expireDays) * 1000 * 60 * 60 * 24);
                document.cookie = key + "=" + encodeURIComponent(value) + ";path=/;expires=" + date.toGMTString() + ";";
            } else {
                document.cookie = key + "=" + encodeURIComponent(value) + ";path=/;";
            }

        },

        get: function (key) {

            //return $.cookie(key)
            var i, x, y, ARRcookies = document.cookie.split(";");
            for (i = 0; i < ARRcookies.length; i++) {
                x = ARRcookies[i].substr(0, ARRcookies[i].indexOf("="));
                y = ARRcookies[i].substr(ARRcookies[i].indexOf("=") + 1);
                x = x.replace(/^\s+|\s+$/g, "");
                if (x == key) {
                    return unescape(decodeURIComponent(y));
                }
            }
        },

        remove: function (key) {

            //$.removeCookie(key,{ path: '/' });
            document.cookie = key + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;path=/;';
        },

        destroy: function () {
            var cookies = document.cookie.split(";");

            for (var i = 0; i < cookies.length; i++) {
                var cookie = cookies[i];
                var eqPos = cookie.indexOf("=");
                var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
                document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT;";
            }
        }

    },

    Form: {
        serialize: function (form) {
            var serialized = form.serializeArray();
            var retObj = {}
            for (var i in serialized) {
                var field = serialized[i];
                retObj[field.name] = field.value;
            }

            var user_id = Util.Cookie.get("user_id");
            retObj['user_id'] = user_id;
            return retObj;
        },

        /**
         * Not  JQUERY from
         * @param form
         */
        serializeUploadForm: function (form) {
            var input = document.createElement("input"); //input element, text
            input.setAttribute('type', "hidden");
            input.setAttribute('name', "user_id");
            input.setAttribute('value', Util.Cookie.get("user_id"));
            form.appendChild(input);

            var input = document.createElement("input"); //input element, text
            input.setAttribute('type', "hidden");
            input.setAttribute('name', "lang");
            input.setAttribute('value', cur_lang);
            form.appendChild(input);

            var input = document.createElement("input"); //input element, text
            input.setAttribute('type', "hidden");
            input.setAttribute('name', "token");
            input.setAttribute('value', Util.Cookie.get("token"));
            form.appendChild(input);

            formData = new FormData(form);
            return formData;
        },

        onKeyPress: function (input) {
            var num = input.value.replace(/\,/g, '');
            if (!isNaN(num)) {
                if (num.indexOf('.') > -1) {
                    num = num.split('.');
                    num[0] = num[0].toString().split('').reverse().join('').split('').reverse().join('').replace(/^[\,]/, '');
                    if (num[1].length > 2) {
                        num[1] = num[1].substring(0, num[1].length - 1);
                    }
                    input.value = num[0] + '.' + num[1];
                } else {
                    input.value = num.toString().split('').reverse().join('').split('').reverse().join('').replace(/^[\,]/, '');
                }
            } else {
                input.value = input.value.substring(0, input.value.length - 1);
            }
        },

        getCurrentDate: function () {
            return new Date().getDate() + "/" + (new Date().getMonth() - 1) + "/" + new Date().getFullYear();
        },

        correctFormatting: function (event) {

            var target = event.target ? event.target : event.srcElement;
            if (target) {

                if (reqType == "CASHIN") {
                    if (parseFloat(target.value) > adjBalance) target.value = adjBalance;
                } else if (reqType == "CASHOUT") {
                    if (parseFloat(target.value) > mgsBalance) target.value = mgsBalance;
                }

                while (target.value.indexOf("0") == 0) target.value = target.value.substring(1, target.value.length);
                var indx = target.value.indexOf(".");
                if (indx >= 0) {
                    if (indx == 0) {
                        target.value = 0 + target.value;
                        indx = target.value.indexOf(".");
                    }
                    if (indx == target.value.length - 1) target.value = target.value + "00";
                    else if (indx == target.value.length - 2) target.value = target.value + "0";
                    else if (indx < target.value.length - 3) target.value = target.value.substring(0, indx + 3);
                } else {
                    if (target.value.length != 0) target.value = target.value + ".00"; else target.value = target.value + "0.00";
                }
            }
        }

    },

    Hash: {
        hash_messages: {
            "#wrong_email_confirmation_code": "email_confirmation_code_wrong_or_expired",
            "#email_confirmation_success": "your_email_was_confirmed_successfully"
        },


        hash_actions: {
            '#registration': 'Registration.openDialog'
        },

        init: function () {
            var me = this;
            hash_messages = me.hash_messages;
            hash_actions = me.hash_actions;

            if (hash_messages.hasOwnProperty(window.location.hash)) {
                var hash_message_text = "";
                if (lang_arr.hasOwnProperty(hash_messages[window.location.hash])) {
                    hash_message_text = lang_arr[hash_messages[window.location.hash]];
                } else {
                    hash_message_text = hash_messages[window.location.hash];
                }
                Util.Popup.open({
                    content: hash_message_text,
                    buttons: [{
                        text: "Ok",
                        click: "Util.Hash.removeHash();"
                    }]
                });
            }


            try {
                var splited = window.location.hash.split("|");

                var action = splited[0];
                console.log(splited.splice(0, 1));


                if (hash_actions.hasOwnProperty(action)) {

                    var methodToCall = hash_actions[action];
                    if(methodToCall.indexOf('.')!=-1) {

                        var Object = methodToCall.split(".")[0];
                        var Method = methodToCall.split(".")[1];


                        window[Object][Method].apply(Object, splited.splice(0, 1));


                    }

                    else {


                        window[hash_actions[action]].apply(hash_actions[action], splited.splice(0, 1));
                    }





                }
            } catch (e) {
                console.log(e);
            }


            me.handle_on_change();
        },
        handle_on_change: function () {
            var me = this;
            $(window).on('hashchange', function () {
                me.init();
            });
        },
        removeHash: function () {
            history.pushState("", document.title, window.location.pathname);
        }
    },

    Popup: {

        /**
         * {
         *      title:"Bla"
         *      fields:[
         *          {
         *              name:"userId",
         *              type:"text",
         *              label:"User ID"
         *          }
         *      ]
         * }
         * @param params
         */
        openForm: function (params) {
            var me = this;

            //Popup Title
            var title = params.title != undefined ? params.title : lang_arr['message'];

            //Fields That Should be displayed in form
            var fields = params.fields;
//            [
//                {
//                    name:"userId",
//                    type:"text",
//                    label:"User ID"
//                }
//            ]

            //Onsubmit ACtion
            var onSubmit = params.onSubmit;
            var description_text = "";

            if (params.hasOwnProperty("description")) {
                if (lang_arr.hasOwnProperty(params.description)) {
                    description_text = "<div class='popup-form-description'>" + lang_arr[params.description] + "</div>";
                } else {
                    description_text = "<div class='popup-form-description'>" + params.description + "</div>";
                }
            }


            var validations = {};
            var onChangeEvents = {};
            var formHTML = description_text + '<form class=\"form-horizontal\" enctype="multipart/form-data" novalidate="novalidate" id="popup-form" autocomplete="off" method="POST" onsubmit="' + onSubmit + '(this); return false;">';
            for (var index in fields) {
                var current = fields[index];


                if (current.onchange) {
                    onChangeEvents[current.name] = current.onchange;
                }

                if (current.validation) {
                    validations[current.name] = current.validation;
                }

                var type = current.type != undefined ? current.type : "text";


                var label = "";
                if (lang_arr[current.label]) {
                    label = lang_arr[current.label];
                } else {
                    label = current.label;
                }

                var value = "";
                if (current.value) {
                    if (lang_arr[current.value]) {
                        value = lang_arr[current.value];
                    } else {
                        value = current.value;
                    }
                }

                var placeholder = "";
                if (current.placeholder) {
                    if (lang_arr[current.placeholder]) {
                        placeholder = lang_arr[current.placeholder];
                    } else {
                        placeholder = current.placeholder;
                    }
                }

                var disabled = "";
                var input_id = "";
                if (current.disabled) {
                    disabled = "disabled";
                }
                else {
                    input_id = "form-popup-" + current.name;
                }


                var name = "";
                if (current.hasOwnProperty("name")) {
                    name = current.name;
                }

                //If Fields Current Type Was Select
                if (current.type == "select") {
                    var options_html = "";

                    //If Options Was Specified
                    if (current.hasOwnProperty("options")) {
                        var options = current.options;

                        options_html += "<option value=''>" + lang_arr['choose'] + "</option>";

                        //Try If Option Has value and name
                        try {
                            for (var j in options) {
                                var current_option = options[j];
                                var option_name = current_option.option_name;
                                var option_value = current_option.option_value;

                                //If Name Was Language Parameters Key
                                if (lang_arr.hasOwnProperty(option_name)) {
                                    option_name = lang_arr[option_name];
                                }

                                //Save Options HTML
                                options_html += "<option value='" + option_value + "'>" + option_name + "</option>";
                            }

                        } catch (e) {
                            console.log(e);
                        }

                    }//End If Options Were Specified

                    //If Ajax Was Specified Should Request
                    if (current.hasOwnProperty("ajax")) {
                        var ajaxOptions = current.ajax;
                        try {
                            var service_name = ajaxOptions.service_name;
                            var method_name = ajaxOptions.method_name;
                            var parameters = ajaxOptions.parameters;

                            API.call(service_name, method_name, parameters, function (response) {
                                if (response.code == 10) {
                                    var options_responded = response.data;
                                    for (var k in options_responded) {
                                        var cur_option = options_responded[k];

                                        var option_name = cur_option[ajaxOptions.mapping.option_name];
                                        var option_value = cur_option[ajaxOptions.mapping.option_value];

                                        //Save Options HTML
                                        options_html += "<option value='" + option_value + "'>" + option_name + "</option>";

                                    }


                                }
                            }, false, false);

                        } catch (e) {
                            console.log(e);
                        }

                    }//End If Ajax Were Specified


                    formHTML += '<div class="form-group">' +
                        '<label class="control-label col-md-3" style="text-align: left;">' + label + ':</label>' +
                        '<div class="col-md-9">' +
                        '<select class="form-control input-default" id="select_' + name + '" name="' + name + '">' + options_html + '</select>' +
                        '</div>' +
                        '</div>';
                }

                else if (current.type == "hidden") {
                    formHTML += '<input type="' + type + '" id="' + input_id + '"  class="form-control input-default" value="' + value + '" ' + disabled + ' placeholder="' + placeholder + '" name="' + current.name + '">';
                }

                else if (current.type == "textarea") {
                    formHTML += '<div class="form-group">' +
                        '<label class="control-label col-md-3" style="text-align: left;">' + label + ':</label>' +
                        '<div class="col-md-9">' +
                        '<textarea id="' + input_id + '"  class="form-control input-default" value="' + value + '" ' + disabled + ' placeholder="' + placeholder + '" name="' + name + '"></textarea>' +
                        '</div>' +
                        '</div>';
                }

                //This is In IpBlock
                //Disabled Was Not Good
                else if (current.type == "info_input") {

                    var text_field = "";//What Text Should Be Seen To User As Info
                    var value_field = "";//What Is The Underling Value Of Info Input

                    //If Ajax Was Specified Should Request
                    if (current.hasOwnProperty("ajax")) {
                        var ajaxOptions = current.ajax;

                        try {
                            var service_name = ajaxOptions.service_name;
                            var method_name = ajaxOptions.method_name;
                            var parameters = ajaxOptions.parameters;


                            API.call(service_name, method_name, parameters, function (response) {
                                if (response.code == 10) {
                                    var data = response.data;

                                    if (ajaxOptions.hasOwnProperty("mapping")) {
                                        value_field = data[ajaxOptions.mapping.value_field];
                                        text_field = data[ajaxOptions.mapping.text_field];
                                    }
                                }
                            }, false, false);

                        } catch (e) {
                            console.log(e);
                        }

                    }//End If Ajax Were Specified
                    else {
                        if (current.hasOwnProperty("text_field")) {
                            text_field = current.text_field;
                        }
                        if (current.hasOwnProperty("value_field")) {
                            value_field = current.value_field;
                        }
                    }

                    formHTML += '<div class="form-group">' +
                        '<label class="control-label col-md-3" style="text-align: left;padding-top:0px;">' + label + ':</label>' +
                        '<div class="col-md-9">' +
                        '<p>' + text_field + '</p><input type="hidden" name="' + current.name + '" value="' + value_field + '"/>' +
                        '</div>' +
                        '</div>';
                }


                else if (current.type == "suggested_input") {

                    //If Ajax Was Specified Should Request
                    if (current.hasOwnProperty("ajax")) {
                        var ajaxOptions = current.ajax;

                        try {
                            var service_name = ajaxOptions.service_name;
                            var method_name = ajaxOptions.method_name;

                            API.call(service_name, method_name, parameters, function (response) {
                                if (response.code == 10) {
                                    var data = response.data;

                                    if (ajaxOptions.hasOwnProperty("mapping")) {
                                        value_field = data[ajaxOptions.mapping.value_field];
                                        text_field = data[ajaxOptions.mapping.text_field];
                                    }
                                }
                            }, false, false);

                        } catch (e) {
                            console.log(e);
                        }

                    }

                    formHTML += '<div class="form-group">' +
                        '<label class="control-label col-md-3" style="text-align: left;">' + label + ':</label>' +
                        '<div class="col-md-9">' +
                        '<input type="' + type + '" id="sugested_input"  class="form-control input-default" value="' + value + '" ' + disabled + ' placeholder="' + placeholder + '" name="' + current.name + '">' +
                        '</div>' +
                        '</div>';
                }

                //If Type Was Text or Default
                else if (current.type == "file") {

                    formHTML += '<div class="form-group">' +
                        '<label class="control-label col-md-3" style="text-align: left;">' + label + ':</label>' +
                        '<div class="col-md-9">' +
                        '<input type="' + type + '" id="' + input_id + '"  class="form-control input-default" value="' + value + '" ' + disabled + ' placeholder="' + placeholder + '" name="' + current.name + '">' +
                        '</div>' +
                        '</div>';
                }

                //If Type Was Text or Default
                else {
                    formHTML += '<div class="form-group">' +
                        '<label class="control-label col-md-3" style="text-align: left;">' + label + ':</label>' +
                        '<div class="col-md-9">' +
                        '<input type="' + type + '" id="' + input_id + '"  class="form-control input-default" value="' + value + '" ' + disabled + ' placeholder="' + placeholder + '" name="' + current.name + '">' +
                        '</div>' +
                        '</div>';
                }

            }


            if (!params.buttons) {
                formHTML +=
                    '<div class="form-group">' +
                    '<div class="col-md-12">' +
                    '<button type="submit" class="btn btn-block btn-dark-blue">'+lang_arr['submit']+'</button>' +
                    '</div>' +
                    '</div>';
            }
            else {
                var buttons_html = '<div class="form-group"><div class="col-md-12">';
                for (var index in params.buttons) {
                    var button = params.buttons[index];

                    if (typeof button == "object") {
                        if (button.click) {
                            if (button.click == "close") {
                                button.click = 'Util.Popup.close();return false;';
                            } else if (button.text == "Ok") {
                                button.click += "Util.Popup.close();return false;";
                            } else {
                                button.click = button.click.toString();
                            }

                        } else {
                            button.click = "return false;";
                        }
                        if (button.type == "submit") {
                            buttons_html += ' <button type="submit" class="btn btn-30 btn-dark-blue btn-space">' + button.text + '</button> ';

                        } else {
                            buttons_html += ' <button class="btn btn-30 btn-dark-blue btn-space" onclick="' + button.click + '">' + button.text + '</button> ';
                        }
                    }
                }
                buttons_html += "</div></div>";
                formHTML += buttons_html;


            }

            formHTML += '</form>';

            var openParams = {
                title: title,
                content: formHTML,
                noButton: true,
                isForm: true,
                onChangeEvents: onChangeEvents
            };


            me.open(openParams);

            if (Object.keys(validations).length) {

                if (params.validate_functions) {
                    params.validate_functions();
                }

                $('#popup').find("form").validate({
                    errorElement: 'div',
                    highlight: function (element) {
                        $(element).closest('.form-group').removeClass('is-valid').addClass('with-error');
                    },
                    unhighlight: function (element) {
                        $(element).closest('.form-group').removeClass('with-error');
                    },
                    success: function (label, element) {
                        $(element).closest('.form-group').addClass('is-valid');
                    },
                    rules: validations
                });
            }

        },

        open: function (params) {

            var me = this;

            me.closeWarn();
            me.closeLoader();
            clearInterval(Util.Popup.wartTimeOut);


            var popup = $('#popup');

            var title = params.title != undefined ? params.title : lang_arr['message'];
            var content = params.content;
            if (lang_arr.hasOwnProperty(content)) {
                content = lang_arr[content];
            }

            popup.find('.modal-title').html(title);
            popup.find('.modal-body > .content').html("").html(content);

            if (params['onChangeEvents']) {
                if (Object.keys(params['onChangeEvents'])) {
                    var onChangeEvents = params['onChangeEvents'];
                    for (var field in onChangeEvents) {
                        $('#form-popup-' + field).keyup(function () {
                            if (typeof onChangeEvents[field] == "function") {
                                onChangeEvents[field](this);
                            }
                        });


                    }
                }

            }

            var buttons_html = "";
            if (params.buttons) {
                for (var index in params.buttons) {
                    var button = params.buttons[index];

                    if (typeof button == "object") {
                        if (button.click) {
                            if (button.click == "close") {
                                button.click = '$(\'#popup\').modal(\'hide\');';
                            } else if (button.text == "Ok") {
                                button.click += " Util.Popup.close();";
                            } else {
                                button.click = button.click.toString();
                            }

                        } else {
                            button.click = "return false;";
                        }
                        if (button.type == "submit") {
                            buttons_html += '<button type="submit" class="btn btn-30 btn-dark-blue btn-space">' + button.text + '</button>';

                        } else {
                            buttons_html += '<button class="btn btn-30 btn-dark-blue btn-space" onclick="' + button.click + '">' + button.text + '</button>';

                        }
                        popup.find('.modal-footer').html(buttons_html).show();
                    }
                }
            }
            else {
                if (!params.noButton) {
                    buttons_html += '<button class="btn btn-30 btn-dark-blue btn-space" onclick="$(\'#popup\').modal(\'hide\');">Ok</button>';
                    popup.find('.modal-footer').html(buttons_html).show();
                } else {
                    popup.find('.modal-footer').hide();
                }

            }
            popup.modal('show');
            if(params.width) {
                console.log(popup.find('.modal-dialog'));
                popup.find('.modal-dialog').css({
                    'width':params.width
                })
            }
            console.log(popup);


            try {

                if (params.onCloseAction) {
                    $('#popup').on('hidden.bs.modal', function () {
                        console.log("on close");
                        if (typeof params.onCloseAction == 'string') {
                            eval(params.onCloseAction);
                        }
                    });

                }


                $('#popup').on('shown.bs.modal', function () {
                    console.log("on open");
                });

            } catch (e) {
                console.log(e);
            }


        },

        close: function (callback) {
            $('#popup').modal('hide');
            $('#popup').find('.modal-body > .content').html("");
            if (callback) {
                callback();
            }
        },

        openWarn: function (warning_text, warn_class, hideSeconds) {
            var me = this;
            var warn_text = "";
            if (!warn_class) {
                warn_class = "danger";
            }
            if (lang_arr.hasOwnProperty(warning_text)) {
                warn_text = lang_arr[warning_text];
            } else {
                warn_text = warning_text;
            }
            $('#popup  .modal-body .alert').addClass("warn").find("p").html(warn_text);
            $('#popup  .modal-body .alert').removeClass("hidden");
            if (!hideSeconds) {
                hideSeconds = 6000;
            }
            clearTimeout(Util.Popup.wartTimeOut);
            Util.Popup.wartTimeOut = setTimeout(function () {
                me.closeWarn();
            }, hideSeconds);
        },

        closeWarn: function () {
            $('#popup  .modal-body .alert p').html("");
            $('#popup  .modal-body .alert').addClass("hidden");
        },


        openLoader: function () {
            $('.popup-loader').removeClass("hidden");
        },

        closeLoader: function () {
            $('.popup-loader').addClass("hidden");
        }

    },

    State: {
        /**
         * @param target
         * @param self
         */
        addActive: function (target, self) {
            'undefined' == typeof self ? $(target).addClass('active') : $(target).parent().addClass('active');
        },

        /**
         * @param target
         * @param self
         */
        removeActive: function (target, self) {
            'undefined' == typeof self ? $(target).removeClass('active') : $(target).parent().removeClass('active');
        }
    },


    AddCSRFToken: function () {
        $('<input type="hidden" name="CSRFToken" value="' + Util.Cookie.get("CSRFToken") + '"/>').prependTo("form");
    },

    InitSelect: function () {
        $('select.custom-select').select2({
            minimumResultsForSearch: -1
        }).on("change", function (e) {
            //alert('opened');
            $('.select2-container').removeClass('select2-container-active');
        });
    },

    changeLang: function (value) {

        var splited = request_uri.split("/");
        splited[1] = value;
        var location = base_href + splited.join("/");
        window.location.href = location
    },

    callFunc: function (functionName, context, args) {
        var args = Array.prototype.slice.call(arguments).splice(2);
        var namespaces = functionName.split(".");
        var func = namespaces.pop();
        for (var i = 0; i < namespaces.length; i++) {
            context = context[namespaces[i]];
        }
        return context[func].apply(this, args);
    },

    getUrlVars: function () {
        var vars = {};
        var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function (m, key, value) {
            vars[key] = value;
        });
        return vars;
    },

    /**
     * add loading class on target element
     * @param element
     */
    addLoader: function (element) {
        if (element instanceof jQuery == false) {
            element = $(element);
        }

        var position = element.css("position");
        if (!position) {
            position = "relative";
        }

        if (element.find(".loader").length == 0) {
            element.css({position: "relative"});
            console.log(base_href);
            var loading = $('<div class="loader"><div class="loader-overlay"></div><div class="loader-content"><img src="' + base_href + '/app/templates/default/view/_media/images/ajax-loader.gif"/><br/><span>Loading...</span></div> </div>');
            element.append(loading);
        }


    },


    swift_validate: function (swift) {

        var regSWIFT = /^([a-zA-Z]){4}([a-zA-Z]){2}([0-9a-zA-Z]){2}([0-9a-zA-Z]{3})?$/;

        if (regSWIFT.test(swift) == false) {

            return false;

        }
        else {

            return true;

        }
    },

    /**
     * remove loading class from target element
     * @param element
     */
    removeLoader: function (element) {
        if (element instanceof jQuery == false) {
            element = $(element);
        }
        element.find('.loader').remove();
    }

};



