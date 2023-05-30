{{$Data.modules.header}}

{{$label_class = 'control-label col-md-3'}}
{{$input_class = 'col-md-9'}}
{{$form_class = '_col-md-5 _col-md-offset-3'}}

<body>

<div class="wrapper">
{{$Data.modules.topmenu}}


{{$Data.modules.bettingmenu}}



<div class="container">

    <div class="row">

        <div class="col-md-12">

            {{$Data.modules.accountmenu}}

            <div class="panel panel-default panel-profile">

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <h2 class="panel-title">{{$lang_arr.account_settings}}</h2>
                            <hr />
                            <div class="container-fluid profile-section">
                                <div class="row">

                                    <div class="{{$form_class}}">
                                        <form method="POST" role="form" class="form-horizontal" id="info_form" autocomplete="off">
                                            <div class="form-group">
                                                <label class="{{$label_class}}">{{$lang_arr.username}}:</label>
                                                <div class="{{$input_class}}">
                                                    <input autocomplete="off" type="text" class="form-control input-default" disabled id="field_username" name="field_username">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="{{$label_class}}">{{$lang_arr.first_name}}:</label>
                                                <div class="{{$input_class}}">
                                                    <input autocomplete="off" type="text" class="form-control input-default" disabled id="field_first_name" name="field_first_name">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="{{$label_class}}">{{$lang_arr.last_name}}:</label>
                                                <div class="{{$input_class}}">
                                                    <input autocomplete="off" type="text" class="form-control input-default" disabled id="field_last_name" name="field_last_name">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="{{$label_class}}">{{$lang_arr.birthdate}}:</label>
                                                <div class="{{$input_class}}">
                                                    <input autocomplete="off" type="text" class="form-control input-default" disabled id="field_birthdate" name="field_birthdate">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="{{$label_class}}">{{$lang_arr.nickname}}:</label>
                                                <div class="{{$input_class}}">
                                                    <input autocomplete="off" type="text" class="form-control input-default" id="field_nickname" name="field_nickname">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="{{$label_class}}">{{$lang_arr.mobile}}:</label>
                                                <div class="{{$input_class}}">
                                                    <input autocomplete="off" type="text" class="input-sm" id="field_phone" name="field_phone">

                                                    <span class="phone-not confirmation-label hidden btn btn-xs btn-danger" onclick="Settings.InitPhoneVerification();return false;">Please Verify</span>
                                                    <span class="phone-yes confirmation-label hidden label label-success">Verified</span>

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="{{$label_class}}">{{$lang_arr.email}}:</label>
                                                <div class="{{$input_class}}">
                                                    <input autocomplete="off" type="text" class="input-sm" id="field_email" name="field_email">
                                                    <span class="email-not confirmation-label hidden btn btn-xs btn-danger" onclick="Settings.InitEmailVerification();return false;" >Please Verify</span>
                                                    <span class="email-yes confirmation-label hidden label label-success">Verified</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="{{$label_class}}">{{$lang_arr.country}}:</label>
                                                <div class="{{$input_class}}">
                                                    <select name="field_country" class="custom-select full-width" id="field_country" data-name="field_country">

                                                        {{foreach $Data.countries as $country}}
                                                            <option value="{{$country.id}}">{{$country.short_name}}</option>
                                                        {{/foreach}}
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="{{$label_class}}">{{$lang_arr.city}}:</label>
                                                <div class="{{$input_class}}">
                                                    <input autocomplete="off" type="text" class="form-control input-default" id="field_city" name="field_city">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="{{$label_class}}">{{$lang_arr.address}}:</label>
                                                <div class="{{$input_class}}">
                                                    <input autocomplete="off" type="text" class="form-control input-default" id="field_address" name="field_address">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="{{$label_class}}">{{$lang_arr.account_password}}:</label>
                                                <div class="{{$input_class}}">
                                                    <input autocomplete="off" type="password" placeholder = "Enter Account Password" class="form-control input-default" id="field_password" name="field_password">
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <div class="col-md-4 col-md-offset-8">
                                                    <button type="submit" class="btn btn-block btn-dark-blue" onclick="Settings.updateUserInfo($('#info_form'));return false;">
                                                        {{$lang_arr.update_settings}}
                                                    </button>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                    <!-- col -->
                                </div>
                                <!-- row -->
                            </div>
                            <!-- container -->


                            <h2 class="panel-title">{{$lang_arr.privacy_settings}}</h2>
                            <hr />
                            <div class="container-fluid profile-section">
                                <div class="row">



                                    <div class="{{$form_class}}">
                                        <form method="POST" class="form-horizontal" id="privacy_form" autocomplete="off">


                                            <div class="form-group">
                                                <label class="{{$label_class}}">{{$lang_arr.my_bets_are}}:</label>
                                                <div class="{{$input_class}}">
                                                    <select name="bet_privacy" id="bet_privacy" class="custom-select full-width">
                                                        <option value="1">{{$lang_arr.public}}</option>
                                                        <option value="0">{{$lang_arr.private}}</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="{{$label_class}}">{{$lang_arr.show_my}}:</label>
                                                <div class="{{$input_class}}">
                                                    <select name="name_privacy" id="name_privacy" class="custom-select full-width">
                                                        <option value="1">{{$lang_arr.fullname}}</option>
                                                        <option value="0">{{$lang_arr.nickname}}</option>
                                                    </select>
                                                </div>
                                            </div>



                                            <div class="form-group">
                                                <div class="col-md-4 col-md-offset-8">
                                                    <button type="submit" class="btn btn-block btn-dark-blue" onclick="Settings.updatePrivacyInfo();return false;">
                                                        {{$lang_arr.update_privacy_settings}}
                                                    </button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                    <!-- col -->




                                </div>
                                <!-- row -->
                            </div>
                            <!-- container -->



                        </div>
                        <!-- col -->
                        <div class="col-md-6">

                            <h2 class="panel-title">{{$lang_arr.security_settings}}</h2>
                            <hr />
                            <div class="container-fluid profile-section">
                                <div class="row">
                                    <div class="{{$form_class}}">
                                        <form method="POST" id="changePasswordForm" role="form" class="form-horizontal" onsubmit="Settings.changePassword(this);return false;">
                                            <div class="form-group">
                                                <label class="{{$label_class}}">{{$lang_arr.old_password}}:</label>
                                                <div class="{{$input_class}}">
                                                    <input autocomplete="off" type="password"  class="form-control input-default" name="old_password">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="{{$label_class}}">{{$lang_arr.new_password}}:</label>
                                                <div class="{{$input_class}}">
                                                    <input autocomplete="off" type="password" class="form-control input-default" name="new_password">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="{{$label_class}}">{{$lang_arr.new_password_confirm}}:</label>
                                                <div class="{{$input_class}}">
                                                    <input autocomplete="off" type="password" class="form-control input-default" name="confirm_new_password">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-4 col-md-offset-8">
                                                    <button type="submit" class="btn btn-block btn-dark-blue">{{$lang_arr.change_password}}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- col -->
                                </div>
                                <!-- row -->
                            </div>
                            <!-- container -->





                            <h2 class="panel-title">{{$lang_arr.profile_picture}}</h2>
                            <hr />
                            <div class="container-fluid profile-section">
                                <div class="row">
                                    <div class="{{$form_class}}">
                                        <div class="form-group">
                                            <label class="{{$label_class}}"><img src="{{$THEME}}/images/avatar.jpg" class="img-responsive img-rounded img-thumbnail" id="profile_thumb"/></label>
                                            <div class="{{$input_class}}">
                                                <form method="POST" onsubmit="Settings.updateProfileImage(this);return false;">
                                                    <input type="file" class="form-control input-default" name="image" /> <br />
                                                    <input type="submit" class="btn btn-block btn-dark-blue" name="submit" value="{{$lang_arr.upload_profile_picture}}"/>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- col -->
                                </div>
                                <!-- row -->
                            </div>
                            <!-- container -->



                        </div>
                        <!-- col -->
                    </div>
                    <!-- row -->
<hr/>
                    <div class="row" style="padding:10px;">
                        <div class="col-md-7">
                            <h2 class="panel-title">{{$lang_arr.personal_documents}}</h2>
                            <span class="btn btn-sm btn-dark-blue" style="margin-top: -23px;float:right" onclick="Settings.openAddNewDocument();" style="float:right">{{$lang_arr.add_new_document}}</span>
                            <hr />
                            <div class="container-fluid profile-section">
                                <div class="row">
                                    <table class="table table-custom" id="user_documents_table">
                                        <thead>
                                        <tr>
                                            <th>{{$lang_arr.country}}</th>
                                            <th>{{$lang_arr.date_modified}}</th>
                                            <th>{{$lang_arr.document_type}}</th>
                                            <th>{{$lang_arr.document_number}}</th>
                                            <th>{{$lang_arr.status}}</th>
                                            <th>{{$lang_arr.document_copy}}</th>
                                        </tr>
                                        </thead>
                                        <tbody id="personalDocuments">


                                        </tbody>
                                    </table>
                                    <p class="empty_message hidden"></p>
                                </div>
                                <!-- row -->
                            </div>
                            <!-- container -->
                        </div><!-- end col-md-8-->
                        <div class="col-md-5 documents-explanation-text" style="padding-top:30px;">
                            <h4 style="font-size:13px;">{{$lang_arr.for_security}}</h4>
                            <ul style="list-style-type: circle;padding-left:25px;font-size:12px;margin-top:5px;line-height:1.6">
                                <li>Passport</li>
                                <li>Driving licence with photo</li>
                                <li>National Identity Card</li>
                            </ul>
                        </div>

                    </div>
                </div>
                <!-- container -->

            </div>
            <!-- panel -->

        </div>
        <!-- col -->
    </div>
    <!-- row -->

</div>
<!-- container -->




{{$Data.modules.footer}}
<script>
    $(function() {
        Settings.getUserInfo();
    });

</script>


