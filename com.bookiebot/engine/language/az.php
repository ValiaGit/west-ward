<?php

if (!defined("APP")) {
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



    "protection"=>array(
        "type_1_success"=>"Time out uğurla yenilənmişdir!",
        "type_3_success"=>"Özünü təcrid uğurla yenilənmişdir!",
        "type_2_success"=>"Depozit limiti uğurla yeniləndi!",
        "type_4_success"=>"İtki məbləği limiti uğurla yeniləndi!",
        "type_5_success"=>"Mərc limiti uğurla yenilənmişdir!",
        "type_6_success"=>"Sessiyanın vaxtının bitmə limiti uğurla yenilənmişdir ",

        "time_out_text"=>"Profil aktivləşdirildi, timeout protection. <br/> Son tarix: <strong>{expire_date}</strong>!"
    ),

    /********100.00, ********
     * COMMON1000.00, ERROR CODES
     ***************/
    'access_denided'=>'Giriş qadağandır',
    /****************
     * COMMON ERROR CODES
     ***************/

    'message'=>'Mesaj',
    'show_receivers'=>'Mərci qəbul edənləri göstər',

    'signin'=>'Daxil ol',

    'wrong_password_or_username'=>'İstifadəçi adı və şifrə səhvdir!',
    'fields_are_empty'=>'Bəzi məlumatlar doldurulmamışdır',

    'back'=>'GERİ',
    'lay'=>'LAY',

    'recover_password'=>'Kodu yenilə',
    'my_account'=>'Mənim hesabım',

    'deposit'=>'Depozit',
    'withdraw'=>'Pulun çıxarılması',
    'card_management'=>'Kartın idarə olunması',
    'transfer_history'=>'Transfer tarixçəsi',
    'transfer_history_games'=>'Oyun transferləri',
    'card_details'=>'Ödəniş hesabları',

    /****************
     * SOME REGISTRATION STAFF
     ***************/
    'registration'=>'Qeydiyyat',
    'sign_up'=>'Qeydiyyatdan keçmək',
    'add_funds_to_play'=>'Mərc etmək üçün hesabınıza pul yükləyin',
    'register'=>'Qeydiyyat',

    'username'=>'Username',
    'enter_username'=>'İstifadəçi adını daxil edin',

    'fullname'=>'Tam ad',
    'enter_fullname'=>'Tam adınızı daxil edin',


    'first_name'=>'AD',
    'enter_first_name'=>'Adınızı daxil edin',

    'last_name'=>'Soyad',
    'enter_last_name'=>'Soyadı daxil ete',

    'password'=>'Password',
    'password_confirmation'=>'Kodun təsdiq olunması',
    'enter_password'=>'Kodu daxil et',
    'confirm_password'=>'Kodu təsdiq et',

    'male'=>'Kişi',
    'female'=>'Qadın',

    'country'=>'Ölkə',
    'choose_country'=>'Ölkəni seç',

    'city'=>'Şəhər',
    'enter_city'=>'Şəhəri daxil et',

    'birthdate'=>'Doğum tarixi',
    'enter_birthdate'=>'Doğum tarixini daxil et',

    'email'=>'Email',
    'enter_mail'=>' Email daxil et',

    'address'=>'Ünvan',
    'enter_address'=>'Ünvanı daxil et',

    'zip_code'=>'Zip kod',
    'enter_zip_code'=>'Zip kodu daxil et',

    'phone'=>'Telefon',
    'enter_phone'=>'Telefon nömrəsini daxil et',



    'affiliate_id'=>'Affiliate Id',
    'enter_affiliate_id'=>'Enter Affiliate Id',


    'security_question'=>'Təhlükəsizlik sorğusu',
    'security_answer'=>'Cavab',
    'enter_answer'=>'Cavabı daxil et',

    'personal_identity'=>"Şəxsi məlumatlar",
    'phone'=>"Telefon",
    'credit_card'=>"Kredit Kartı",
    'player_protection'=>"İstifadəçinin müdafiəsi",




    'step'=>'Addım',




    //Registration Fields Validations
    'field_is_empty'=>"Field is empty",
    'username_exists'=>"Bu istifadəçi adı sistemdə artıq mövcuddur",
    'email_exists'=>"Bu email adı artıq mövcuddur",
    'email_invalid'=>"Bu email mövcud deyildir",
    'phone_exists'=>"Bu nömrə sistemdə artıq mövcuddur",
    'passwords_dont_match'=>"Kodlar uyğun deyildir",
    'password_too_short'=>"Kod çox qısadır",
    'password_not_valid'=>"Kodunuz ən bir böyük, bir kiçik rəqəm və bir hətfdən olmaqla ən  az 8 ədəd olmalıdır.",
    'at_least_18'=>"Ən 18 yaşınız olmalıdır!",


    'email_confirmation_subject'=>' BookieBot.Com hesabınızı təsdiqləyin!',

    'email_confirmation_text_registration'=>'Uğurla qeydiyyatdan keçdiniz - Bookiebot.com!<br/>  Hesabınızı aktivləşdirmək üçün aşağıdakı linkdən istifadə edin!<br/> {token}',
    'email_confirmation_text'=>'Hesabınızı aktivləşdirmək üçün aşağıdakı linkdən istifadə edin!<br/> <a href="{{confirmation_link}}">Email-inizi təsdiq edin</a>',


    'confirm_email'=>'Email ünvanını təsdiq edin',
    'confirmation_link_text'=>'Email ünvanını təsdiq edin',
    'registration_success'=>'Qeydiyyat uğurla tamamlanmışdır!<br/> Hesabınızın təsdiq olunması ilə bağlı link sizin email ünvanına göndərilmişdir!',

    /****************
     * END SOME REGISTRATION STAFF
     ***************/

    'not_authorized'=>'avtorizasiya olunmamışdır',


    /****************
     * Forgot Email
     ***************/
    'pass_reset_email_was_sent_to_user'=>'Təhlükəsizlik kodu sizin email ünvanına göndərilmişdir.',
    'reset_password'=>'Kodu yenilə',
    'new_password'=>'Yeni kod',
    'confirm_new_password'=>'Kodu təsdiq et',
    'enter_password'=>'Kodu daxil et',
    'enter_password_confirmation'=>'Kod təsdiqini daxil et',
    'enter_security_code'=>'Təhlükəsizlik kodunu daxil et',
    'pasword_was_changed_successfully'=>'Kod uğurla yenilənmişdir!',
    'try_again'=>'Xəta baş vermişdir, xahiş edirik bir daha yoxlayın!',
    'your_email_was_confirmed_successfully'=>'Email ünvanınız uğurla təsdiq olunmuşdur!',
    'email_confirmation_code_wrong_or_expired'=>'Email təsdiqi kodunuz səhv qeyd olunmuş və ya gec daxil olunmuşdur!',


    'please_confirm_email_to_make_bets'=>'Mərc edə bilməyiniz üçün email ünvanınızı təsdiq edin!',
    'resend_email_confirmation'=>'Email təsdiqini bir daha göndərin!',
    'confirmation_code_was_sent_successfully_please_check_email'=>' Təsdiq kodu uğurla göndərilmişdir, xahiş edirik email ünvanınızı yoxlayın!',


    /****************
     * User Profile Changes
     ***************/
    'login'=>'Daxil ol',
    'logout'=>'Çıxış',
    'my_account'=>'Mənim hesabım',
    'account_settings'=>'Hesab parametrləri',
    'privacy_settings'=>'Gizlilik parametrləri',
    'security_settings'=>'Təhlükəsizlik parametrləri',
    'profile_picture'=>'Hesab şəkli',
    'mobile'=>'Mobil telefon nömrəsi',
    'update_settings'=>'Parametrə dəyişiklik et',
    'update_privacy_settings'=>'Gizlilik parametrlərinə dəyişiklik et',
    'change_password'=>'Kodu dəyişmək',
    'my_bets_are'=>'Mənim mərclərim',
    'public'=>'Ictimai',
    'private'=>'Özəl',
    'old_password'=>'Əvvəlki kod',
    'new_password'=>'Yeni Kod',
    'new_password_confirm'=>'Yeni kodu təsdiq et',
    'upload_profile_picture'=>'Profil şəklini yüklə',
    'information_was_updated_successfully'=>'Məlumat uğurla yenilənmişdir!',
    'email_was_changed_has_to_be_confirmed'=>'Email məlumatınız dəyişdirilmişdir, saytda fəaliyyətə davam etmək üçün yeni email məlumatınızı təsdiq etməyinizi xahiş edirik!',
    'privacy_update_success'=>'Gizlilik parametrləri uğurla yenilənmişdir!',

    "ip_restriction_login_text"=>"Your IP: {ip}<br/> Səhv ödəniş məlumatları daxil etdiyiniz üçün hesabınız bloklaşdırılmışdır!<br/>Restriction will be expired at: {expires_at}",


    'success'=>"Əməliyyat uğurla tamamlanmışdır",
    'message_was_sent_successfully'=>"Mesajınız müvəffəqiyyətlə göndərilmişdir",
    'account'=>"Hesab",
    'account_password'=>"Hesab kodu",

    /****************
     * END User Profile Changes
     ***************/

    'favotires'=>'Favoritlər',
    'sports'=>'İdman növləri',
    'topmatches'=>'Əsas oyunlar',
    'betslip'=>'Betslip',
    'liability'=>'Öhdəlik',
    'promotions'=>'Təbliğ olunma',
    'bets_by_friends'=>'Dostlarla mərc',
    'betslip_empty'=>'Sol tərəfdəki xanaları seçməklə seçiminizi edin.',
    'clear_bets'=>'Mərcləri sil',
    'place_bets'=>'Mərc et',

    'odds'=>'Odds',
    'stake'=>'Stake($)',
    'profit'=>'Gəlir($)',
    'bakers_odds'=>'Backer\'s odds',
    'bakers_stake'=>'Backer\'s Stake',
    'your_liability'=>'Sizin öhdəlik',
    'min_amount'=>'Min məbləğ',
    'max_amount'=>'Max məbləğ',
    'commission'=>'Komissiya',
    'withdraw'=>'Pulun çıxarılması',
    'deposit'=>'Depozit',
    'my_community'=>'Mənim əlaqələrim',
    'upcoming'=>'Üzümüzə gələn tədbirlər',
    'like'=>'Bəyənmək',
    'dislike'=>'Bəyənməmək',
    'comments'=>'qeydlər',
    'post'=>'Post',
    'you_dont_have_joined_any_communities'=>'Heç bir icmaya daxil olmamısınız!',
    'write_a_comment'=>'Qeyd daxil et',
    'draw'=>'Heç-heçə',


    'enter_amount'=>'Məbləği daxil edin',
    'provided_by'=>'Tərəfindən təmin olunmuşdur',






    //History
    'not_matched'=>'Uyğun deyildir',
    'fully_matched'=>'Tamamilə uyğundur',
    'partly_matched'=>'Qismən uyğundur',
    'won'=>'Qalib oldunuz',
    'lose'=>'Məğlub oldunuz',
    'canceled'=>'Ləğv olundu',
    'if_you_cancel'=>'Mərci ləğv edəcəyiniz halda geriyə alacağınız məbləğ: ',

    'answer_was_wrong'=>'cavab səhvdir',


    //Transactions History
    'date'=>'Tarix',
    'unique_id'=>'Unikal ID',
    'provider'=>'Provider',
    'amount'=>'Məbləğ',
    'commission'=>'Komissiya',
    'net_amount'=>'Tam Məbləğ',
    'cut_amount'=>'Komissiya və tam alacağınız məbləğ ',
    'transfer_type'=>'Transfer tipi',


    'personal_documents'=>'SƏNƏDLƏRİN İDENTİFİKASİYASI ',
    'add_new_document'=>'YENİ SƏNƏDİN ƏLAVƏ OLUNMASI',
    'add_identity_document'=>'ŞƏXSİYYƏTİ TƏSDİQ EDƏN SƏNƏDİN ƏLAVƏ OLUNMASI',
    /*
     * 1 - Passport
        2 - Driving License
        3 - Personal Card
     */
    'upload_id_document'=>'Şəxsiyyət vəsiqəsini əlavə et',
    'doc_1'=>'Pasport',
    'doc_2'=>'Sürücülük vəsiqəsi',
    'doc_3'=>'Şəxsiyyət vəsiqəsi',
    'verified'=>'Təsdiq olunmuşdur',
    'uploaded'=>'YÜKLƏNMİŞDİR',
    'upload_copy'=>'KOPYANI YÜKLƏ',
    'unverified'=>'Təsdiq olunmamışdır',
    'upcoming_for'=>'Gələcək: ',
    'team_bets_for'=>'Komanda mərci - ',
    'nickname'=>'Təxəllüs',
    'show_my'=>'Göstər',
    'date_modified'=>'DATE MODIFIED',
    'document_type'=>'SƏNƏD NÖVÜ',
    'issuer_country'=>'KİM TƏRƏFİNDƏN QEYDƏ ALINMIŞDIR',
    'document_number'=>'SƏNƏDİN NÖMRƏSİ',
    'status'=>'STATUS',
    'transfer_status'=>'Status',
    'document_copy'=>'SƏNƏDİN KOPYASI',
    'have_not_Added_documents'=>'Sənəd əlavə etməmisiniz!<br/> Hesabınız təsdiq olunmamışdır!<br/> Xahiş edirik şəxsiyyəti təsdiq edən sənədi əlavə edəsiniz!',



    'choose'=>'Seç...',
    'passport'=>'Pasport',
    'driving_licence'=>'Sürücülük vəsiqəsi',
    'personal_id'=>'Şəxsiyyət vəsiqəsi',


    'password_recovery_description'=>'Kodun yenilənməsi üçün qeydiyyatdan keçdiyiniz email ünvanını daxil etməyinizi xahiş edirik!',
    'provided_email_was_not_found'=>'Qeyd olunan email ünvanı tapılmadı!',
    'password_reset_email_text'=>'Salam, BookieBot -da kodunuzun yenilənməsi üçün təhlükəsizlik sualı budur: {{token}}',



    'verification_status'=>'Hesabınızın təsdiq olunması statusu',
    'registration_from_country_prohibited'=>'Qeydiyyatdan keçmək istədiyiniz ölkəyə icazə verilmir!',
    'not_verified'=>'Təsdiq olunmamışdır',
    'verified'=>'Təsdiq olunmuşdur',


    "date_from"=>"Tarixindən etibarən",
    "date_to"=>"Tarixinə qədər",

    'please_login_to_make_bets'=>'Mərc etmək üçün daxil olun',


    'friened_request_already_sent'=>'dost sorğudu artıq göndərilmişdir',



    //Deposit Money
    'deposit_limit_not_verified'=>'2300$ dan artıq mərclər etmək üçün hesab profilinizdə şəxsiyyət vəsiqənizi əlavə edin"!',
    'choose_card'=>'Kartı Seçin',
    'choose_payment_account'=>'Ödəniş hesabını seçin',
    'enter_cvc'=>'CVC (kartın arxasındakı 3 rəqəm) daxil edin',
    "featured"=>"Featured",
    "open_bets"=>"mövcud mərclər",
    "no_open_bets"=>"Mərcdə iştirak etmirsiniz!",


    "received_bets"=>"daxil olan Mərc sorğuları",
    "no_received_bets"=>"Hələki heç kim sizə fərdi mərc göndərməyib!",


    "min"=>"Min",
    "unmatched"=>"Mərc edən tapılmamışdır",
    "unmatched_amount"=>"Mərcə daxil olmayan məbləğ",
    "welcome"=>"Xoş gəmisiniz",
    "balance"=>"B",
    "where_is_the_money"=>"Hardan pul qazanım?",
    "phone"=>"Telefon",
    "all_rights_reserved"=>"Bütün hüquqlar qorunur",
    "this_means_you_bet_back"=>"",
    "pair"=>"Cütlük",



    "search"=>"Axtarış",
    "bet_type"=>"Mərcin növü",


    "bet_status"=>"Mərcin statusu",
    "bet_made"=>"Mərc olunmuşdur",
    "partially_matched"=>"Məbləğin müəyyən bir hisəsi ilə mərc qəbul olunmuşdur",
    "canceled_received_money"=>"Ləğv olundu, geri qaytarılmış məbləğ",
    "partially_canceled"=>"Yarımçıq ləğv olunmuşdur",
    "partially_canceled_lost"=>"Yarımçıq ləğv olunmaya görə itirilmiş məbləğ",
    "partially_canceled_won"=>"arımçıq ləğv olunmaya görə qazanılmış məbləğ",
    "not_matched_returned_money"=>"Mərc edən olmadığı üçün qaytarılan pul",
    "private_rejected"=>"Fərdi mərc qəbul olunmamışdır",
    "private_accepted"=>"Fərdi mərc qəbul olunmuşdur",



    "market"=>"Bazar",
    "selection"=>"Seçim",
    "bid_type"=>"Mərcin növü",
    "bet_id"=>"Mərc ID",
    "bet_placed"=>"Mərc qoyulmuşdur",
    "odds_req"=>"Kvota tələb olunur.",

    "profit_loss"=>"Qazanc/İtki",

    "betting_history_text"=>"Bütün qəbul olunmuş mərclər bir yere yığılmı halda göstərilmişdir.  Daha ətraflı məlumat üçün Mərc nəmrəsini seçin. ( Yalnız mərc olunmuş lakin nəticəsi bilinməyən mərclər üçün).",



    "username_or_email"=>"İstifadəçi adı və Email"

);

?>