var IpBlock = {

    openPopup: function (ip) {

        Util.Popup.openForm({
            title: "Block Ip?",
            fields: [
                {
                    name: "core_question_id",
                    type: "info_input",
                    label: "security_question",
                    ajax: {
                        service_name: "user.securityquestions",
                        method_name: "getSecurityQuestionForCurrentUser",
                        parameters: {
                            user_id: Util.Cookie.get("user_id")
                        },
                        mapping: {
                            value_field: "question_id",
                            text_field: "question"
                        }
                    }

                },
                {
                    name: "ip",
                    type: "hidden",
                    value: ip
                },
                {
                    name: "answer_value",
                    type: "text",
                    label: "security_answer",
                    placeholder: "enter_answer"
                }
            ],
            onSubmit: "IpBlock.blockIP"
        });
    },


    blockIP: function (form) {
        var me = this;
        var formData = Util.Form.serialize($(form));
        formData.user_id = Util.Cookie.get("user_id");

        API.call("user.blockips", "blockIp", formData, function (response) {
            if (response.code == 65) {
                Util.Popup.openWarn(lang_arr["answer_was_wrong"]);
            } else if (response.code == 10) {
                Util.Popup.open({
                    content: lang_arr['success']
                });
                AccessLog.getData();
            }
        });
    },


    unBlockIp:function(blocked_ip_id) {
        var parameters = {
            blocked_ip_id:blocked_ip_id,
            user_id:Util.Cookie.get("user_id")
        };
        API.call("user.blockips", "unBlockIp", parameters, function (response) {
            if (response.code == 10) {
                AccessLog.getData();
                Util.Popup.open({
                    content: lang_arr['success']
                });
            }
        });
    }


}