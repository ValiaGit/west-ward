<?php

if(!defined("APP")) {
    die("Dont have Access");
}



$langPackage = array(

    'betslip_m' => array(
        'stake_range' => array(
            'e2' => 'Odds between 1.01 and 2 must be in increments of 0.01. Your odds have been updated accordingly.',
            'e3' => 'Odds between 2 and 3 must be in increments of 0.02. Your odds have been updated accordingly.',
            'e4' => 'Odds between 3 and 4 must be in increments of 0.05. Your odds have been updated accordingly.',
            'e6' => 'Odds between 4 and 6 must be in increments of 0.1. Your odds have been updated accordingly.',
            'e10' => 'Odds between 6 and 10 must be in increments of 0.2. Your odds have been updated accordingly.',
            'e20' => 'Odds between 10 and 20 must be in increments of 0.5. Your odds have been updated accordingly.',
            'e30' => 'Odds between 20 and 30 must be in increments of 1. Your odds have been updated accordingly.',
            'e50' => 'Odds between 30 and 50 must be in increments of 2. Your odds have been updated accordingly.',
            'e100' => 'Odds between 50 and 100 must be in increments of 5. Your odds have been updated accordingly.',
            'e1000' => 'Odds between 100 and 1000 must be in increments of 10. Your odds have been updated accordingly.'
        ),
    ),

    /********100.00, ********
     * COMMON1000.00, ERROR CODES
     ***************/
    'access_denided'=>'access_denided',
    /****************
     * COMMON ERROR CODES
     ***************/

    'message'=>'Message',

    'signin'=>'Sign In',

    'wrong_password_or_username'=>'Username or password is wrong!',
    'fields_are_empty'=>'Some fields are empty',

    'back'=>'BACK',
    'lay'=>'LAY',

    'recover_password'=>'Recover password',
    'my_account'=>'My Account',

    'deposit'=>'Deposit',
    'withdraw'=>'Withdraw',
    'card_management'=>'Card Management',
    'transfer_history'=>'Transfer History',

    /****************
     * SOME REGISTRATION STAFF
     ***************/
    'registration'=>'Registration',
    'sign_up'=>'Singn Up',
    'add_funds_to_play'=>'Add Funds to Play',
    'register'=>'Register',

    'username'=>'Username',
    'enter_username'=>'Enter username',

    'fullname'=>'Full name',
    'enter_fullname'=>'Enter Full name',


    'first_name'=>'First name',
    'enter_first_name'=>'Enter first name',

    'last_name'=>'Last name',
    'enter_last_name'=>'Enter last name',

    'password'=>'Password',
    'password_confirmation'=>'Password Confirmation',
    'enter_password'=>'Enter Password',
    'confirm_password'=>'Confirm Password',

    'male'=>'Male',
    'female'=>'Female',

    'country'=>'Country',
    'choose_country'=>'Choose Country',

    'city'=>'City',
    'enter_city'=>'Enter City',

    'birthdate'=>'Birth Date',
    'enter_birthdate'=>'Enter birth date',

    'email'=>'Email',
    'enter_mail'=>'Enter Email',

    'address'=>'Address',
    'enter_address'=>'Enter Address',


    'phone'=>'Phone',
    'enter_phone'=>'Enter Phone',

    'personal_identity'=>"Personal Identity",
    'phone'=>"Phone",
    'credit_card'=>"Credit Card",
    'player_protection'=>"Player Protection",




    'step'=>'Step',




    //Registration Fields Validations
    'field_is_empty'=>"Field is empty",
    'username_exists'=>"Username already exists",
    'email_exists'=>"Email already exists",
    'email_invalid'=>"Email is invalid",
    'phone_exists'=>"Phone already exists",
    'passwords_dont_match'=>"Passwords don't match",
    'password_too_short'=>"Password too short",
    'password_not_valid'=>"Your password should consist of at least 6 characters and certainly contain one uppercase letter, one lowercase letter and one number.",
    'at_least_18'=>"You must be at least 18 years old!",
    'at_least_21'=>"Estonian citisens must be at least 21 years old!",


    'email_confirmation_subject'=>'Please confirm your account for BookieBot.Com!',

    'email_confirmation_text_registration'=>'You were successfully registered on Bookiebot.com!<br/>  Please click link below to activate your account!<br/> {token}',
    'email_confirmation_text'=>'Your email confirmation code is:<br/> {code}',


    'confirm_email'=>'confirm_email',
    'confirmation_link_text'=>'Confirm Email',
    'registration_success'=>'Registration was successfull!<br/> An email with confirmation link was sent to your Email!',

    /****************
     * END SOME REGISTRATION STAFF
     ***************/

    'not_authorized'=>'not_authorized',


    /****************
     * Forgot Email
     ***************/
    'pass_reset_email_was_sent_to_user'=>'An email with security code was sent on your user email.',
    'reset_password'=>'Reset password',
    'new_password'=>'New password',
    'confirm_new_password'=>'Confirm new password',
    'enter_password'=>'Enter password',
    'enter_password_confirmation'=>'Enter password confirmation',
    'enter_security_code'=>'Enter Security Code',
    'pasword_was_changed_successfully'=>'Password was changed successfully!',
    'try_again'=>'Something went wrong please try again!',
    'your_email_was_confirmed_successfully'=>'Your email was confirmed successfully!',
    'email_confirmation_code_wrong_or_expired'=>'Your email verification code was wrong or expired!',


    'please_confirm_email_to_make_bets'=>'Please confirm email to make bets!',
    'resend_email_confirmation'=>'Resend Email confirmation!',
    'confirmation_code_was_sent_successfully_please_check_email'=>'Confirmation code was sent successfully, please check your email!',


    /****************
     * User Profile Changes
     ***************/
    'login'=>'Login',
    'logout'=>'Logout',
    'my_account'=>'My Account',
    'account_settings'=>'Account Settings',
    'privacy_settings'=>'Privacy Settings',
    'security_settings'=>'Security Settings',
    'profile_picture'=>'Profile Picture',
    'mobile'=>'Mobile',
    'update_settings'=>'Update Settings',
    'update_privacy_settings'=>'Update Privacy Settings',
    'change_password'=>'Change Password',
    'my_bets_are'=>'My Bets Are',
    'public'=>'Public',
    'private'=>'Private',
    'old_password'=>'Old Password',
    'new_password'=>'New Password',
    'new_password_confirm'=>'Confirm new password',
    'upload_profile_picture'=>'Upload Profile Picture',
    'information_was_updated_successfully'=>'Information was updated successfully!',
    'email_was_changed_has_to_be_confirmed'=>'Email was changed so you must confirm new Email to make actions on website!',
    'privacy_update_success'=>'Privacy setting was updated successfully!',

    "ip_restriction_login_text"=>"Your IP: {ip}<br/> Was blocked for trying wrong credentials!<br/>Restriction will be expired at: {expires_at}",


    'success'=>"Action Was Successfull",

    /****************
     * END User Profile Changes
     ***************/

    'favotires'=>'Favorites',
    'sports'=>'Sports',
    'topmatches'=>'Top Matches',
    'betslip'=>'Betslip',
    'liability'=>'Liability',
    'promotions'=>'Promotions',
    'bets_by_friends'=>'Bets By Friends',
    'betslip_empty'=>'Make your selection(s) on the left by clicking on the odds.',
    'clear_bets'=>'Clear Bets',
    'place_bets'=>'Place Bets',

    'odds'=>'Odds',
    'stake'=>'Stake($)',
    'profit'=>'Profit($)',
    'bakers_odds'=>'Backer\'s odds',
    'bakers_stake'=>'Backer\'s Stake',
    'your_liability'=>'Your liability',
    'min_amount'=>'Min Amount',
    'max_amount'=>'Max Amount',
    'commission'=>'Commission',
    'withdraw'=>'Withdraw',
    'deposit'=>'Deposit',
    'my_community'=>'My Communities',
    'upcoming'=>'Upcoming Events',
    'like'=>'like',
    'dislike'=>'dislike',
    'comments'=>'comments',
    'post'=>'Post',
    'you_dont_have_joined_any_communities'=>'You don\'t have joined communities!',
    'write_a_comment'=>'Write a comment',
    'draw'=>'Draw',



    //History
    'not_matched'=>'Not matched',
    'fully_matched'=>'Fully matched',
    'partly_matched'=>'Partly matched',
    'won'=>'Won',
    'lose'=>'Lose',
    'canceled'=>'Canceled',


    //Transactions History
    'date'=>'Date',
    'unique_id'=>'Unique ID',
    'provider'=>'Provider',
    'amount'=>'Amount',
    'commission'=>'Commission',
    'net_amount'=>'Net Amount',
    'transfer_type'=>'Transfer Type',


    'personal_documents'=>'IDENTIFICATION DOCUMENTS',
    'add_new_document'=>'ADD NEW DOCUMENT',
    'add_identity_document'=>'ADD IDENTITY DOCUMENT',
    /*
     * 1 - Passport
        2 - Driving License
        3 - Personal Card
     */
    'upload_id_document'=>'Upload ID Document',
    'doc_1'=>'Passport',
    'doc_2'=>'Driving License',
    'doc_3'=>'Personal Card',
    'verified'=>'Verified',
    'uploaded'=>'PENDING APPROVAL',
    'upload_copy'=>'UPLOAD COPY',
    'unverified'=>'Unverified',
    'upcoming_for'=>'Upcoming: ',
    'team_bets_for'=>'Team Bets For - ',
    'nickname'=>'Nickname',
    'show_my'=>'Show my',
    'date_modified'=>'DATE MODIFIED',
    'document_type'=>'DOCUMENT TYPE',
    'issuer_country'=>'ISSUED BY',
    'document_number'=>'DOCUMENT NUMBER',
    'status'=>'STATUS',
    'document_copy'=>'DOCUMENT COPY',
    'have_not_Added_documents'=>'You haven\'t added any documents!<br/> Account is unverified!<br/> Please add identifications documents!',



    'choose'=>'Choose...',
    'passport'=>'Passport',
    'driving_licence'=>'Driving Licence',
    'personal_id'=>'Personal ID',


    'password_recovery_description'=>'Please provide your account email to start password recovery process!',
    'provided_email_was_not_found'=>'Provided email was not found!',
    'password_reset_email_text'=>'Hello Your, password reset, security code for BookieBot is: {{token}}',



    'verification_status'=>'Account Verification Status',
    'registration_from_country_prohibited'=>'Registration from chosen country id prohibited!',
    'not_verified'=>'Not Verified',
    'verified'=>'Verified',


    'please_login_to_make_bets'=>'please_login_to_make_bets',


    'friened_request_already_sent'=>'friened_request_already_sent',



    //Deposit Money
    'deposit_limit_not_verified'=>'To make transactions with more that 2300$ amount, please verify your Identity from "Account Settings"!',

);

?>