App.view('users',{

    /**
     * You're dummy if u need comment for Init function
     */

    init: function(){


        $('.col-sm-1').removeClass('active');
        $('.col-sm-1[data-controller=users]').addClass("active");

        var me = this,

            extend = {},

            container = new Tab({
                id: 'users',
                name: "Users"
            });


        setTimeout(function() {
            $('#statuese').remove();
            container.prepend("<span id='statuese'>Statuses: 1=Active, 2=Blocked, Inactive=5, Suspended Permanenlty=7</span>");
        },600);


        var grid = me.createGrid('UsersGrid',container);

        $("#UsersGrid").kendoGrid({
            toolbar: ["excel"],
            excel: {
                fileName: "Bets",
                proxyURL: "http://demos.telerik.com/kendo-ui/service/export",
                filterable: true,
                allPages: true
            },
                dataSource: {
                    transport: {
                        read: {
                            url: API.getUrl('user.user','getUserList'),
                            type: 'post',
                            dataType: 'json'
                        }
                    },
                    requestEnd:function(e) {
                        try {
                            var response = e.response;
                            if(response['logout'] == true) {
                                window.location.href = 'index.php';
                            }
                        }catch(e) {

                        }

                    },
                    schema: {
                        data: 'data',
                        total:"total",
                        id: 'core_users__id',
                        model: {
                            fields: {
                                id: {},
                                address: {},
                                address_zip_code: {},
                                balance: { type: 'number', parse: function(v){ return v/100; } },
                                birthdate: {},
                                core_countries_id: {},
                                long_name: {},
                                email: {},
                                fullname: {},
                                gender: { parse: function(v){return {1: 'Male', 2: 'Female'}[v]}},
                                is_email_confirmed: {},
                                is_passport_confirmed: {},
                                is_phone_confirmed: {},
                                phone: {},
                                registration_date: { type: 'date' },
                                status: { parse: function(v){
                                    return {
                                        1: 'Active',
                                        2: 'Blocked',
                                        3: 'Suspended',
                                        4: 'Self Excluded',
                                        5: 'Inactive',
                                        6: 'Deregistered',
                                        7: 'Suspended Permanently'
                                    }[v];
                                }},
                                username: {}
                            }
                        }
                    },
                    pageSize: 10,
                    serverFiltering: true,
                    serverPaging:true
                },
                scrollable: true,
                sortable: true,
                pageable: true,

                detailInit: function(e) {

                    var detailRow = e.detailRow, //get row
                        tpl = e.detailRow.html(), //get tpl
                        model = me.myModel().fields; //get model


                    var vars = $.extend(extend, e.data);
                    tpl = me.parseTpl(tpl, vars);


                    e.detailRow.html(tpl);//update tpl

                    if(vars.is_passport_confirmed == "Yes") {
                        $('#is_passport_confirmed'+vars.core_users__id).prop('checked', true);
                    }


                    var user_id = vars.core_users__id;

                    me.myStore().requestData({
                        proxy:"getDocuments",
                        params:{users_id:user_id}
                    },
                        function(response) {

                        var table = $('#Data_user_table_'+user_id);

                        if(response.code == 10) {
                            var documentList = response.data;
                            if(documentList.length) {
                                var TBody_HTML = "";
                                for(var index in documentList) {
                                    var currentDocument = documentList[index];
                                    /**
                                     *  1 - Passport
                                     *  2 - Driving License
                                     *  3 - Personal Card
                                     */
                                    switch(currentDocument.identity_type) {
                                        case 1:
                                            currentDocument.identity_type = "Passport";
                                            break;
                                        case 2:
                                            currentDocument.identity_type = "Driving License";
                                            break;
                                        case 3:
                                            currentDocument.identity_type = "Personal Card";
                                            break;
                                    }

                                    var IsVerified = currentDocument.IsVerified;
                                    var date_modified = currentDocument.date_modified;

                                    var copy_file = "<td>No File</td>";
                                    if(currentDocument.copy_file_path) {
                                        copy_file = "<td><a href='http://api.bookiebot.com/"+currentDocument.copy_file_path+"' target='_blank'>Copy</a></td>";
                                    }

                                    TBody_HTML+="<tr>" +
                                    "<td>"+currentDocument.identity_type+"</td>" +
                                    "<td>"+currentDocument.document_number+"</td>" +
                                    "<td>"+currentDocument.country+"</td>" +
                                    copy_file +
                                    "<td>"+
                                        "<input data-id="+currentDocument.id+" type=\"checkbox\" class=\"toggle-documents\" "+(currentDocument.IsVerified?'checked="checked"':'')+" />" +
                                    "</td>" +
                                    "</tr>";
                                }

                                table.find("tbody").html(TBody_HTML);
                                $('.no_documents_'+user_id).addClass("hidden");
                                table.removeClass("hidden");
                            } else {
                                $('.no_documents_'+user_id).removeClass("hidden");
                                table.addClass("hidden");
                            }

                        }




                        $('.passport_verification').change(function(event) {


                            var conrimmessage = confirm("Are you sure? Do you really want to verify users Personal Documents Status?");
                            if(!conrimmessage) {
                                $(".passport_verification").prop("checked", false);
                            }

                            event.preventDefault();
                            var id = $(this).data("id");
                            var is_checked = $(this).is(":checked");
                            var method = "unVerifyPassport";
                            if(is_checked) {
                                method = "verifyPassport";
                            }

                            me.myStore().requestData({
                                proxy:method,
                                params:{user_id:id}
                            },function(response) {
                                if(response.code == 10) {
                                    Util.showNotification();
                                } else {
                                    Util.showNotification("Error","danger");
                                }
                            });
                        });


                        $('.is_blocked').change(function(event) {

                            var conrimmessage = confirm("Are you sure? Do you really want to block this user?");
                            if(!conrimmessage) {
                                $(".is_blocked").prop("checked", false);
                            }


                            event.preventDefault();
                            var id = $(this).data("id");
                            var is_checked = $(this).is(":checked");
                            var method = "unBlockUser";
                            if(is_checked) {
                                method = "blockUser";
                            }

                            me.myStore().requestData({
                                proxy:method,
                                params:{user_id:id}
                            },function(response) {
                                if(response.code == 10) {
                                    Util.showNotification();
                                } else {
                                    Util.showNotification("Error","danger");
                                }
                            });
                        });



                            $('.is_SuspendedPermanently').change(function() {

                                var id = $(this).data("id");
                               var conrimmessage = confirm("Are you sure? If you suspend this user permanently this action can not be undone!!!");
                                if(conrimmessage) {
                                    me.myStore().requestData({
                                        proxy:"suspendPermanently",
                                        params:{user_id:id}
                                    },function(response) {
                                        if(response.code == 10) {
                                            Util.showNotification();
                                        } else {
                                            Util.showNotification("Error","danger");
                                        }
                                    });
                                } else {
                                    console.log("here");
                                    $(".is_SuspendedPermanently").prop("checked", false);
                                }
                            });




                        $('.toggle-documents').change(function(event) {
                            event.preventDefault();

                            var id = $(this).data("id");
                            var is_checked = $(this).is(":checked");
                            var method = "unVerifyDocument";
                            if(is_checked) {
                                method = "verifyDocument";
                            }

                            me.myStore().requestData({
                                proxy:method,
                                params:{document_id:id}
                            },function(response) {
                                if(response.code == 10) {
                                    Util.showNotification();
                                } else {
                                    Util.showNotification("Error","danger");
                                }
                            });
                        });


                    });


                    me.myStore().requestData({
                            proxy:"getMoneyAccounts",
                            params:{users_id:user_id}
                        },
                        function(response) {


                            var table = $('#MAccounts_user_table_'+user_id);

                            if(response.code == 10) {
                                var MoneyAccountsList = response.data;
                                if(MoneyAccountsList.length) {
                                    var TBody_HTML = "";
                                    for(var index in MoneyAccountsList) {
                                        var currentDocument = MoneyAccountsList[index];
                                        var Pan = currentDocument.Pan;

                                        if(currentDocument.money_providers_id == 2) {
                                            Pan = "<strong>Bank</strong>: "+currentDocument['BankName']+", <strong>BankCode</strong>:"+currentDocument['BankName']+"<br/>" +
                                                "<strong>BankAccount</strong>: "+currentDocument['BankAccount']+"" +
                                                "<br/>" +
                                                "<strong>Payee</strong>:"+currentDocument['Payee']+", <strong>SWIFT</strong>: "+currentDocument['SwiftCode'];
                                        }


                                        TBody_HTML+="<tr>" +
                                            "<td>"+currentDocument.money_provider_title+"</td>" +
                                            "<td>"+Pan+"</td>" +
                                            "<td>"+currentDocument.AddDate+"</td>" +
                                            "<td>"+
                                            "<input data-id="+currentDocument.id+" type=\"checkbox\" class=\"toggle-money_accounts\" "+(currentDocument.ConfirmationStatus?'checked="checked"':'')+" />" +
                                            "</td>" +
                                            "</tr>";
                                    }
                                    console.log(TBody_HTML);

                                    table.find("tbody").html(TBody_HTML);
                                    $('.no_maccounts_'+user_id).addClass("hidden");
                                    table.removeClass("hidden");
                                } else {
                                    $('.no_maccounts_'+user_id).removeClass("hidden");
                                    table.addClass("hidden");
                                }

                            }


                            $('.toggle-money_accounts').change(function(event) {
                                event.preventDefault();

                                var id = $(this).data("id");
                                var is_checked = $(this).is(":checked");
                                var method = "unVerifyMoneyAccount";
                                if(is_checked) {
                                    method = "verifyMoneyAccount";
                                }

                                me.myStore().requestData({
                                    proxy:method,
                                    params:{account_id:id}
                                },function(response) {
                                    if(response.code == 10) {
                                        Util.showNotification();
                                    } else {
                                        Util.showNotification("Error","danger");
                                    }
                                });
                            });


                        });


                },

                detailTemplate: $("#UserDetailsTpl").html(),
                filterable: {
                    extra: false,
                    operators: {
                        string: {eq: "Is equal to"},
                        number: {eq: "Is equal to"}
                    }
                },

                columns: [
                    { field:'core_users__id', title: 'ID', width: 100},
                    {
                        field:'username',
                        title: 'Username'
                    },{
                        field:'fullname',
                        title: 'Full Name',
                        filterable:false
                    },{
                        field:'email',
                        title: 'EMail'
                    },{
                        field:'balance',
                        title: 'Balance',
                        template:function(row) {
                            return row['balance'].trunc(2)+"€";
                        },
                        filterable:false
                    },{
                        field:'status',
                        title: 'Status'
                    },
                    {
                        field:'gender',
                        title: 'Gender',
                        filterable:false
                    },
                    {
                        field:'last_login_date',
                        title: 'Last Login',
                        filterable:false
                    }
                ]
            });






    },//end init();

    /**
     * Render grid for history data
     */
    renderData: function(){


    }//end renderData();


});//end {}