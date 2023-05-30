<html>
<head>
    <title>Bookiebot.Com</title>
    <meta charset="utf8">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="./_media/css/application.css">
    <link rel="stylesheet" href="./_media/css/libs/datepicker.css">

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <script src="http://bookiebot.com/app/templates/default/view/_media/js/libs/jquery.js"></script>
    <script src="http://bookiebot.com/app/templates/default/view/_media/js/libs/jquery-ui.min.js"></script>
    <script src="http://bookiebot.com/app/templates/default/view/_media/js/libs/jquery.validate.min.js"></script>
    <script src="http://bookiebot.com/app/templates/default/view/_media/js/libs/additional-methods.min.js"></script>
    <script src="http://bookiebot.com/app/templates/default/view/_media/js/libs/jquery.cookie.js"></script>
    <script src="http://bookiebot.com/app/templates/default/view/_media/js/libs/bootstrap.min.js"></script>
    <script src="http://bookiebot.com/app/templates/default/view/_media/js/libs/idangerous.swiper.min.js"></script>
    <script src="http://bookiebot.com/app/templates/default/view/_media/js/libs/jquery.sticky.min.js"></script>

    <script src="http://bookiebot.com/app/templates/default/view/_media/js/libs/select2.min.js"></script>
    <script src="http://bookiebot.com/app/templates/default/view/_media/js/libs/collapsible.min.js"></script>
    <script src="http://bookiebot.com/app/templates/default/view/_media/js/libs/datepicker.js"></script>
    <script src="http://bookiebot.com/app/templates/default/view/_media/js/libs/moment.js"></script>

    <!-- Some Utility Functions -->
    <script src="http://bookiebot.com/app/templates/default/view/_media/js/Betstock/Util.js"></script>
</head>

<!-- Registraion -->
<body class="<?php echo $page_body_class; ?>">
<div class="modal _modal-message fade" data-style="display:block" tabindex="-1" id="register_modal" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Registration</h4>
            </div>

            <div class="modal-sub-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="heading"><h2>Step 1:</h2> Singn Up</div>
                        </div>
                        <!-- col -->
                        <div class="col-md-6">
                            <div class="heading"><h2>Step 2:</h2> Add Funds to Play</div>
                        </div>
                        <!-- col -->
                    </div>
                    <!-- row -->
                </div>
                <!-- container -->
            </div>
            <!-- modal sub header -->


            <div class="container-fluid">
                <form onsubmit="Registration.submit(this);return false;" style="margin-top:20px;" id="registrationForm"
                      autocomplete="off">
                    <div class="row" style="">
                        <div class="col-md-6">
                            <div class="form-group field_username">
                                <label class="control-label label-default" for="username">Username</label>
                                <input type="text" maxlength="20" class="form-control input-default" id="username"
                                       name="username" autocomplete="off" placeholder="Enter username">
                            </div>


                            <div class="form-group field_first_name">
                                <label class="control-label label-default" for="first_name">First name</label>
                                <input type="text" class="form-control input-default" id="first_name" name="first_name"
                                       autocomplete="off" placeholder="Enter first name">
                            </div>

                            <div class="form-group field_last_name">
                                <label class="control-label label-default" for="last_name">Last name</label>
                                <input type="text" class="form-control input-default" id="last_name" name="last_name"
                                       autocomplete="off" placeholder="Enter last name">
                            </div>


                            <div class="form-group field_gender">
                                <label class="control-label label-default" for="gender">gender</label>

                                <div class="select2-container custom-select full-width" id="s2id_gender"><a
                                        href="javascript:void(0)" class="select2-choice" tabindex="-1"> <span
                                            class="select2-chosen" id="select2-chosen-1">Male</span><abbr
                                            class="select2-search-choice-close"></abbr> <span class="select2-arrow"
                                                                                              role="presentation"><b
                                                role="presentation"></b></span></a><label for="s2id_autogen1"
                                                                                          class="select2-offscreen">gender</label><input
                                        class="select2-focusser select2-offscreen" type="text" aria-haspopup="true"
                                        role="button" aria-labelledby="select2-chosen-1" id="s2id_autogen1">

                                    <div class="select2-drop select2-display-none">
                                        <div class="select2-search select2-search-hidden select2-offscreen"><label
                                                for="s2id_autogen1_search" class="select2-offscreen">gender</label>
                                            <input type="text" autocomplete="off" autocorrect="off" autocapitalize="off"
                                                   spellcheck="false" class="select2-input" role="combobox"
                                                   aria-expanded="true" aria-autocomplete="list"
                                                   aria-owns="select2-results-1" id="s2id_autogen1_search"
                                                   placeholder=""></div>
                                        <ul class="select2-results" role="listbox" id="select2-results-1"></ul>
                                    </div>
                                </div>
                                <select class="custom-select full-width select2-offscreen" id="gender" name="gender"
                                        tabindex="-1" title="gender">
                                    <option value="1">Male</option>
                                    <option value="2">Female</option>
                                </select>
                            </div>

                            <div class="form-group field_birthdate">
                                <label class="control-label label-default" for="birthdate">Birth Date</label>
                                <input type="date" class="form-control input-default input-datepicker" id="birthdate"
                                       name="birthdate" autocomplete="off" placeholder="MM/DD/YYY">
                            </div>
                            <div class="form-group field_email">
                                <label class="control-label label-default" for="email">Email</label>
                                <input type="text" class="form-control input-default" id="email" name="email"
                                       autocomplete="off" placeholder="Enter Email">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group field_core_countries_id">
                                <label class="control-label label-default" for="core_countries_id">Country</label>
                                <select class="full-width form-control input-default" id="core_countries_id"
                                        name="core_countries_id">
                                </select>
                            </div>
                            <div class="form-group field_city">
                                <label class="control-label label-default" for="city">City</label>
                                <input type="text" class="form-control input-default" id="city" name="city"
                                       placeholder="Enter City">
                            </div>
                            <div class="form-group field_address">
                                <label class="control-label label-default" for="address">Address</label>
                                <input type="text" class="form-control input-default" id="address" name="address"
                                       placeholder="Enter Address">
                            </div>


                            <div class="form-group field_phone">
                                <label class="control-label label-default" for="phone">Phone</label>
                                <select class="form-control input-default" name="phone_prefix" id="phone_prefix">
                                </select>
                                <input type="text" class="form-control input-default" id="phone" name="phone"
                                       placeholder="Enter Phone">
                            </div>


                            <div class="form-group field_password">
                                <label class="control-label label-default" for="password">Password</label>
                                <input type="password" maxlength="30" class="form-control input-default" id="password"
                                       name="password" placeholder="Enter password">
                            </div>
                            <div class="form-group field_password_confirm">
                                <label class="control-label label-default" for="password_confirm">Password
                                    Confirmation</label>
                                <input type="password" maxlength="30" class="form-control input-default"
                                       id="password_confirm" name="password_confirm" placeholder="Confirm Password">
                            </div>
                        </div>
                        <div class="form-group col-md-12 registration-confirmation clearfix">
                            <div>
                                <strong>By clicking the button below, you:</strong>
                                <ul style="list-style: circle;margin-left:15px;">
                                    <li>Confirm that you are at least 18 years old</li>
                                    <li>Confirm that you do not hold an existing, active Bookiebot account.</li>
                                    <li>Agree to Bookiebot's <a
                                            href="http://bookiebot.com/en/page/show/terms_and_conditions"
                                            target="_blank">Terms and Conditions</a></li>
                                </ul>
                            </div>
                            <br>

                            <div class="col-md-6 col-md-offset-6">
                                <input type="submit" class="btn btn-block btn-dark-blue" id="submit" name="submit"
                                       value="Register">
                            </div>
                        </div>

                    </div>
                </form>
            </div>


        </div>
    </div>
</div>
<!-- End Registraion -->


<div class="modal modal-message fade" tabindex="-1" id="popup" role="dialog" aria-hidden="true">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"></h4>
            </div>

            <div class="modal-body">

                <div class="alert alert-warning hidden">
                    <p></p>
                </div>


                <div class="content"></div>
            </div>
            <div class="modal-footer center"></div>
        </div>
    </div>
</div>


