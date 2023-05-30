<!-- Registraion -->
<div class="modal modal-wide fade" data-style="display:block" tabindex="-1" id="register_modal" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">{{$lang_arr.registration}}</h4>
            </div>

            <div class="modal-sub-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="heading"><h2>{{$lang_arr.step}} 1:</h2> {{$lang_arr.sign_up}}</div>
                        </div>
                        <!-- col -->
                    </div>
                    <!-- row -->
                </div>
                <!-- container -->
            </div>
            <!-- modal sub header -->

            <div class="modal-body">

                <div class="container-fluid">
                    <form method="POST" onsubmit="Registration.submit(this);return false;" style="margin-top:20px;"
                          id="registrationForm"
                          autocomplete="off">
                        <div class="row" style="">
                            <div class="col-md-4">


                                <div class="form-group field_first_name">
                                    <label class="control-label label-default"
                                           for="first_name">{{$lang_arr.first_name}}</label>
                                    <input type="text" class="form-control input-default" id="first_name"
                                           name="first_name"
                                           autocomplete="off" placeholder="{{$lang_arr.enter_first_name}}">
                                </div>

                                <div class="form-group field_last_name">
                                    <label class="control-label label-default"
                                           for="last_name">{{$lang_arr.last_name}}</label>
                                    <input type="text" class="form-control input-default" id="last_name"
                                           name="last_name"
                                           autocomplete="off" placeholder="{{$lang_arr.enter_last_name}}">
                                </div>


                                <div class="form-group field_gender">
                                    <label class="control-label label-default" for="gender">gender</label> <select
                                            class="custom-select full-width" id="gender" name="gender">
                                        <option value="1">{{$lang_arr.male}}</option>
                                        <option value="2">{{$lang_arr.female}}</option>
                                    </select>
                                </div>


                                <div class="form-group field_core_countries_id">
                                    <label class="control-label label-default"
                                           for="core_countries_id">{{$lang_arr.country}}</label>
                                    <select class="full-width form-control input-default" id="core_countries_id"
                                            name="core_countries_id">
                                    </select>
                                </div>


                                <div class="form-group field_birthdate">
                                    <label class="control-label label-default"
                                           for="birthdate">{{$lang_arr.birthdate}}</label>
                                    <input type="text" class="form-control input-default input-datepicker"
                                           id="birthdate"
                                           name="birthdate" autocomplete="off" placeholder="MM/DD/YYY">
                                </div>


                                <div class="form-group field_currency">
                                    <label class="control-label label-default"
                                           for="address">{{$lang_arr.currency}}</label>
                                    <select class="full-width form-control input-default" id="core_currency_id"
                                            name="core_currency_id">
                                    </select>
                                </div>



                            </div><!-- End Personal Column-->


                            <div class="col-md-4">

                                <div class="form-group field_email">
                                    <label class="control-label label-default" for="email">{{$lang_arr.email}}</label>
                                    <input type="text" class="form-control input-default" id="email" name="email"
                                           autocomplete="off" placeholder="{{$lang_arr.enter_mail}}">
                                </div>


                                <div class="form-group field_city">
                                    <label class="control-label label-default" for="city">{{$lang_arr.city}}</label>
                                    <input type="text" class="form-control input-default" id="city" name="city"
                                           placeholder="{{$lang_arr.enter_city}}">
                                </div>

                                <div class="form-group field_address">
                                    <label class="control-label label-default"
                                           for="address">{{$lang_arr.address}}</label>
                                    <input type="text" class="form-control input-default" id="address" name="address"
                                           placeholder="{{$lang_arr.enter_address}}">
                                </div>

                                <div class="form-group field_address">
                                    <label class="control-label label-default"
                                           for="address">{{$lang_arr.zip_code}}</label>
                                    <input type="text" class="form-control input-default" id="zip_code" name="zip_code"
                                           placeholder="{{$lang_arr.enter_zip_code}}">
                                </div>

                                <div class="form-group field_phone">
                                    <label class="control-label label-default" for="phone">{{$lang_arr.phone}}</label>
                                    <select class="form-control input-default" name="phone_prefix" id="phone_prefix">
                                    </select>
                                    <br />
                                    <input type="text" class="form-control input-default" id="phone" name="phone"
                                           placeholder="{{$lang_arr.enter_phone}}">
                                </div>
                            </div><!-- End Addresses Column-->


                            <div class="col-md-4">

                                <div class="form-group field_username">
                                    <label class="control-label label-default"
                                           for="username">{{$lang_arr.username}}</label>
                                    <input type="text" maxlength="20" class="form-control input-default" id="username"
                                           name="username" autocomplete="off"
                                           placeholder="{{$lang_arr.enter_username}}">
                                </div>

                                <div class="form-group field_password">
                                    <label class="control-label label-default"
                                           for="password">{{$lang_arr.password}}</label>
                                    <input type="password" maxlength="30" class="form-control input-default"
                                           id="password"
                                           name="password" placeholder="{{$lang_arr.enter_password}}">
                                </div>

                                <div class="form-group field_password_confirm">
                                    <label class="control-label label-default"
                                           for="password_confirm">{{$lang_arr.password_confirmation}}</label>
                                    <input type="password" maxlength="30" class="form-control input-default"
                                           id="password_confirm" name="password_confirm"
                                           placeholder="{{$lang_arr.confirm_password}}">
                                </div>



                                <div class="form-group field_address">
                                    <label class="control-label label-default"
                                           for="address">{{$lang_arr.security_question}}</label>
                                    <select class="full-width form-control input-default" id="core_security_question_id"
                                            name="core_security_question_id">
                                    </select>
                                </div>

                                <div class="form-group field_password_confirm">
                                    <label class="control-label label-default"
                                           for="password_confirm">{{$lang_arr.security_answer}}</label>
                                    <input type="password" maxlength="30" class="form-control input-default"
                                           id="security_answer" name="security_answer"
                                           placeholder="{{$lang_arr.enter_answer}}">
                                </div>


                                <div class="form-group field_password_confirm">
                                    <label class="control-label label-default"
                                           for="affiliate_id">{{$lang_arr.affiliate_id}}</label>
                                    <input type="text" maxlength="30" class="form-control input-default"
                                           id="affiliate_id" name="affiliate_id"
                                           placeholder="{{$lang_arr.enter_affiliate_id}}">
                                </div>

                            </div><!-- End Password Column-->


                            <div class="form-group col-md-12 registration-confirmation clearfix">
                                <div>
                                    <strong>By clicking the button below, you:</strong>
                                    <br/>
                                    <ul style="list-style: circle;margin-left:15px;line-height:1.6em;">
                                        <li>Confirm that you are at least 18 years old</li>
                                        <li>Confirm that you do not hold an existing, active Bookiebot account.</li>
                                        <li>Agree to Websites's
                                            <a href="{{$base_href}}/{{$cur_lang}}/page/show/terms_and_conditions" target="_blank">Terms and Conditions</a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="col-md-6 col-md-offset-6" style="margin-top:-51px">
                                    {{if $cur_lang eq 'ja'}}
                                    <label class="control-label label-default"
                                           for="terms_agree"><a href="{{$base_href}}/{{$cur_lang}}/page/show/terms_and_conditions" target="_blank">私は、規約と条件を理解し、これに同意します。</a></label>
                                    {{else}}
                                    <label class="control-label label-default"
                                           for="terms_agree">I acknowledged and accept <a href="{{$base_href}}/{{$cur_lang}}/page/show/terms_and_conditions" target="_blank">Terms and Conditions</a></label>
                                    {{/if}}

                                    <input type="checkbox" id="terms_agree" name="terms_agree" />
                                    <input type="submit" class="btn btn-block btn-dark-blue" id="submit" name="submit"
                                           value="{{$lang_arr.register}}">
                                </div>
                            </div>

                    </form>
                </div>

            </div>
        </div>


    </div>
</div>
</div>
<!-- End Registraion -->
