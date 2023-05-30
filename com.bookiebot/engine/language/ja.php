
<?php

if (!defined("APP")) {
    die("Dont have Access");
}



$langPackage = array(


    'money_providers_instructions'  => array(
        1 => 'First Instruction',
        2 => '2 Instruction',
        3 => '3 Instruction',
        4 => '4 Instruction',
        5 => '5 Instruction',
        6 => '6 Instruction',
        7 => '7 Instruction',
        8 => '8 Instruction',
    ),


    'betslip_m' => array(
        'stake_range' => array(
            'e2' => '1.01と2間のオッズは0.01増加します。あなたのオッズは適切にアップデートされました。',
            'e3' => '2と3間のオッズは0.02増加します。あなたのオッズは適切にアップデートされました。',
            'e4' => '3と4間のオッズは0.05増加します。あなたのオッズは適切にアップデートされました。',
            'e6' => '4と6間のオッズは0.1増加します。あなたのオッズは適切にアップデートされました。',
            'e10' => '6と10間のオッズは0.2増加します。あなたのオッズは適切にアップデートされました。',
            'e20' => '10と20間のオッズは0.5増加します。あなたのオッズは適切にアップデートされました。',
            'e30' => '20と30間のオッズは1増加します。あなたのオッズは適切にアップデートされました。',
            'e50' => '30と50間のオッズは2増加します。あなたのオッズは適切にアップデートされました。',
            'e100' => '50と100間のオッズは5増加します。あなたのオッズは適切にアップデートされました。',
            'e1000' => '100と1000間のオッズは10増加します。あなたのオッズは適切にアップデートされました。'
        ),
    ),



    "protection"=>array(
        "type_1_success"=>"制限時間切れは成功裏にアップデートされました!",
        "type_3_success"=>"自動は成功裏にアップデートされました!",
        "type_2_success"=>"デポジットリミットは成功裏にアップデートされました!",
        "type_4_success"=>"掛け金損失リミットは成功裏にアップデートされました!",
        "type_5_success"=>"賭けの対象リミットは成功裏にアップデートされました!",
        "type_6_success"=>"セッション時間切れは成功裏にアップデートされました!",

        "time_out_text"=>"口座は起動しています。時間制限プロテクション。 <br/> 有効期限: <strong>{expire_date}</strong>!"
    ),

    /********100.00, ********
     * COMMON1000.00, ERROR CODES
     ***************/

    'access_denided'=>'アクセスが拒否されました。',



    /****************
     * COMMON ERROR CODES
     ***************/

    'message'=>'メッセージ',
    'show_receivers'=>'受取人を確認',

    'signin'=>'サインイン',

    'wrong_password_or_username'=>'ユーザー名あるいはパスワードが違います!',
    'fields_are_empty'=>'幾つかのフィールドは空です。',

    'back'=>'勝つ方への賭け',
    'lay'=>'負ける方への賭け',

    'recover_password'=>'パスワードを回復',
    'my_account'=>'マイアカウント',

    'deposit'=>'入金',
    'withdraw'=>'出金',
    'card_management'=>'カードマネジメント',
    'transfer_history'=>'送金履歴',
    'transfer_history_games'=>'ゲーム履歴',
    'card_details'=>'支払い口座',

    /****************
     * SOME REGISTRATION STAFF
     ***************/
    'registration'=>'登録',
    'sign_up'=>'サインアップ',
    'add_funds_to_play'=>'プレイマネー追加',
    'register'=>'登録する',

    'username'=>'ユーザー名',
    'enter_username'=>'ユーザー名記入',

    'fullname'=>'フルネーム',
    'enter_fullname'=>'姓名を記入',


    'first_name'=>'名前',
    'enter_first_name'=>'名前を記入',

    'last_name'=>'苗字',
    'enter_last_name'=>'苗字を記入',

    'password'=>'パスワード',
    'password_confirmation'=>'パスワード確認',
    'enter_password'=>'パスワードを記入',
    'confirm_password'=>'パスワードを確認',

    'male'=>'男性',
    'female'=>'女性',

    'country'=>'国名',
    'choose_country'=>'国を選択',

    'city'=>'都市',
    'enter_city'=>'都市を記入',

    'birthdate'=>'生年月日',
    'enter_birthdate'=>'生年月日を記入',

    'email'=>'Eメール',
    'enter_mail'=>'Eメールを記入',

    'address'=>'住所',
    'enter_address'=>'住所を記入',

    'zip_code'=>'郵便番号',
    'enter_zip_code'=>'郵便番号を記入',

    'phone'=>'電話番号',
    'enter_phone'=>'電話番号を記入',



    'affiliate_id'=>'アフィリエイトId',
    'enter_affiliate_id'=>'アフィリエイトIdを記入',


    'security_question'=>'セキュリティに関する質問',
    'security_answer'=>'回答',
    'enter_answer'=>'回答を記入',

    'personal_identity'=>"個人情報",
    'phone'=>"電話番号",
    'credit_card'=>"クレジットカード",
    'player_protection'=>"プレイヤーの保護",




    'step'=>'ステップ',




    //Registration Fields Validations
    'field_is_empty'=>"フィールドは空です。",
    'username_exists'=>"ユーザー名はすでに存在します。",
    'email_exists'=>"Eメールはすでに存在します。",
    'email_invalid'=>"Eメールは無効です。",
    'phone_exists'=>"電話番号はすでに存在します。",
    
    'passwords_dont_match'=>"パスワードが違います。",
    'password_too_short'=>"パスワードが短すぎます。",
    'password_not_valid'=>"パスワードは８文字以上で、少なくとも１文字の大文字および１文字の小文字および１個以上の数字を含むことが必要です。",
    'at_least_18'=>"満１８歳以上でなければなりません!",


    'email_confirmation_subject'=>'BookieBot.Comの口座を確認してください!',

    'email_confirmation_text_registration'=>'あなたは成功裏にBookiebot.comに登録されました!<br/>  左下のリンクをクリックしてあなたの口座を起動してください!<br/> {token}',
    'email_confirmation_text'=>'左下のリンクをクリックしてあなたの口座を起動してください!<br/> <a href="{{confirmation_link}}">Confirm Email</a>',

    'confirm_email'=>'Eメールを確認する',
    'confirmation_link_text'=>'Eメール確認',
    'registration_success'=>'登録が完了しました!<br/> 登録完了メールがあなたのEメールに送信されました!',

    /****************
     * END SOME REGISTRATION STAFF
     ***************/

    'not_authorized'=>'許可されていません',


    /****************
     * Forgot Email
     ***************/
    'pass_reset_email_was_sent_to_user'=>'セキュリティコードを添付したメールがあなたのEメールに送信されました。',
    'reset_password'=>'パスワードをリセットする',
    'new_password'=>'新しいぱすワード',
    'confirm_new_password'=>'新しいパスワードを確認する',
    'enter_password'=>'パスワードを記入する',
    'enter_password_confirmation'=>'確認したパスワードを記入する',
    'enter_security_code'=>'セキュリティコードを記入する',
    'pasword_was_changed_successfully'=>'パスワード変更が完了しました!',
    'try_again'=>'異常が発生しました。もう一度行ってください!',
    'your_email_was_confirmed_successfully'=>'あなたのEメールは成功裏に確認されました!',
    'email_confirmation_code_wrong_or_expired'=>'あなたのEメール確認コードが間違っているか、有効期限が切れています!',


    'please_confirm_email_to_make_bets'=>'Eメールを確認して賭けベットを行ってください!',
    'resend_email_confirmation'=>'確認Eメールを再送してください!',
    'confirmation_code_was_sent_successfully_please_check_email'=>'確認コードは成功裏に送信されました。あなたのEメールを確認してください!',


    /****************
     * User Profile Changes
     ***************/
    'login'=>'ログイン',
    'logout'=>'ログアウト',
    'my_account'=>'マイアカウント',
    'account_settings'=>'口座登録設定',
    'privacy_settings'=>'個人登録設定',
    'security_settings'=>'セキュリティ設定',
    'profile_picture'=>'プロフィール写真',
    'mobile'=>'携帯電話',
    'update_settings'=>'変更設定',
    'update_privacy_settings'=>'個人登録変更設定',
    'change_password'=>'パスワードの変更',
    'my_bets_are'=>'私の賭けペットは',
    'public'=>'公開',
    'private'=>'非公開',
    'old_password'=>'古いパスワード',
    'new_password'=>'新しいパスワード',
    'new_password_confirm'=>'新しいパスワードを確認する',
    'upload_profile_picture'=>'プロフィール写真をアップロードする',
    'information_was_updated_successfully'=>'情報は成功裏にアップデートされました!',
    'email_was_changed_has_to_be_confirmed'=>'Eメールが変更されましたのでウェブでのアクションを行うために新しいEメールを確認しなければなりません!',
    'privacy_update_success'=>'非公開設定は成功裏にアップデートされました!',

    "ip_restriction_login_text"=>"あなたのIP: {ip}<br/> は不正使用によりブロックされました!<br/>利用制限は継続されます: {expires_at}",


    'success'=>"アクションは正常に行われました",
    'message_was_sent_successfully'=>"メッセージは正常に送信されました",
    'account'=>"口座",
    'account_password'=>"口座パスワード",

    /****************
     * END User Profile Changes
     ***************/

    'favotires'=>'お気に入りの',
    'sports'=>'スポーツ',
    'topmatches'=>'人気のある試合',
    'betslip'=>'あなたの賭け',
    'liability'=>'負による負債',
    'promotions'=>'プロモーション',
    'bets_by_friends'=>'友人による賭け',
    'betslip_empty'=>'掛け率をクリックして左側のあなたの賭けを選択する。',
    'clear_bets'=>'賭けを取り消す',
    'place_bets'=>'賭ける',

    'odds'=>'掛け率',
    'stake'=>'掛け金',
    'profit'=>'勝ち金',
    'bakers_odds'=>'勝ちに賭けた人の掛け率',
    'bakers_stake'=>'勝ちにかけた人の掛け金',
    'your_liability'=>'負けによる負債',
    'min_amount'=>'最低額',
    'max_amount'=>'限度額',
    'commission'=>'手数料',
    'withdraw'=>'出金',
    'deposit'=>'入金',
    'my_community'=>'マイコミュニティー',
    'upcoming'=>'直近の試合',
    'like'=>'好き',
    'dislike'=>'嫌い',
    'comments'=>'コメント',
    'post'=>'Post',
    'you_dont_have_joined_any_communities'=>'あなたはコミュニティーに参加していません!',
    'write_a_comment'=>'コメントを書く',
    'draw'=>'引き分け',


    'enter_amount'=>'入金を記入してください',
    'provided_by'=>'与えられました',






    //History
    'not_matched'=>'賭けが成立しません',
    'fully_matched'=>'賭けが成立しました',
    'partly_matched'=>'部分的に成立しました',
    'won'=>'勝ち',
    'lose'=>'負け',
    'canceled'=>'キャンセル',
    'if_you_cancel'=>'あなたの賭けをキャンセルすると返金を受けます: ',

    'answer_was_wrong'=>'回答は間違っていました',


    //Transactions History
    'date'=>'日時',
    'unique_id'=>'個別ID',
    'provider'=>'プロバイダー',
    'amount'=>'口座',
    'commission'=>'手数料',
    'net_amount'=>'総額',
    'cut_amount'=>'手数料引き後の総額',
    'transfer_type'=>'送金種類',

    'personal_documents'=>'個人識別資料',
    'add_new_document'=>'新しい資料を追加する',
    'add_identity_document'=>'個人識別資料を追加する',
    /*
     * 1 - Passport
        2 - Driving License
        3 - Personal Card
     */
    'upload_id_document'=>'ID資料をアップロードする',
    'doc_1'=>'パスポート',
    'doc_2'=>'運転免許証',
    'doc_3'=>'個人カード',
    'verified'=>'認証しました',
    'uploaded'=>'アップロードしました',
    'upload_copy'=>'アップロードコピー',
    'unverified'=>'認証できません',
    'upcoming_for'=>'直近の: ',
    'team_bets_for'=>'Team Bets For - ',
    'nickname'=>'ニックネーム',
    'show_my'=>'示す',
    'date_modified'=>'更新日時',
    'document_type'=>'資料タイプ',
    'issuer_country'=>'発行された',
    'document_number'=>'ドキュメント番号',
    'status'=>'資格身分',
    'transfer_status'=>'資格身分',
    'document_copy'=>'ドキュメントコピー',
    'have_not_Added_documents'=>'あなたは資料を追加していません!<br/> 口座は認証されていません!<br/> 個人認証資料を添付してください!',
    'choose'=>'選択する…',
    'passport'=>'パスポート',
    'driving_licence'=>'運転免許証',
    'personal_id'=>'個人ID',
    'password_recovery_description'=>'パスワード回復を進めるためにあなたの口座Eメールを送ってください!',
    'provided_email_was_not_found'=>'送られたEメールが見つかりません!',
    'password_reset_email_text'=>'こんにちは　あなたのパスワードはリセットされました。BookieBotのセキュリティコードは: {{token}}',



    'verification_status'=>'口座認証状況',
    'registration_from_country_prohibited'=>'選択された国からの登録は禁止されています!',
    'not_verified'=>'認証されません',
    'verified'=>'認証されました',


    "date_from"=>"年月日より",
    "date_to"=>"年月日まで",

    'please_login_to_make_bets'=>'プレイするためにログインしてください',


    'friened_request_already_sent'=>'友人リクエスト送信済み',
    //Deposit Money
    'deposit_limit_not_verified'=>'2300ドル以上の送金にはあなたの個人認証を"口座設定"から行ってください!',
    'choose_card'=>'カードを選択する',
    'choose_payment_account'=>'支払い口座を選択する',
    'enter_cvc'=>'CVC番号を入れてください',
    "featured"=>"特別試合など",


    'submit'=>'提出する',
    'upload'=>'アップロード',

    'for_security'=>'セキュリティー上の理由から以下の書類のコピーを添付いただきますようお願い致します。',

    //Version new////////////////////


    "open_bets"=>"オープンベット",
    "no_open_bets"=>"まだ開かれた賭けはありません！",


    "received_bets"=>"受け取った賭け",
    "no_received_bets"=>"誰もまだプライベートベットをあなたに送っていません！",

    "min"=>"分",
    "unmatched"=>"比類のない",
    "unmatched_amount"=>"比類のない金額",
    "welcome"=>"ようこそ",
    "balance"=>"バランス",
    "where_is_the_money"=>"お金はどこですか？",
    "all_rights_reserved"=>"全著作権所有",
    "this_means_you_bet_back"=>"",
    "pair"=>"ペア",




    "there_are_no_markets_with_unmatched_money"=>"残念ながら、お金のある市場はありません!",


    "search"=>"サーチ",
    "bet_type"=>"ベットタイプ",


    "bet_status"=>"ベットステータス",
    "bet_made"=>"Bet Made",
    "partially_matched"=>"Partially Matched",
    "canceled_received_money"=>"Canceled Received Money Back",
    "partially_canceled"=>"Partly Canceled",
    "partially_canceled_lost"=>"Partly Canceled Lost",
    "partially_canceled_won"=>"Partly Canceled Won",
    "not_matched_returned_money"=>"Not Matched Returned Money",
    "private_rejected"=>"Private Rejected",
    "private_accepted"=>"Private Accepted",



    "market"=>"Market",
    "selection"=>"Selection",
    "bid_type"=>"Bid type",
    "bet_id"=>"Bet ID",
    "bet_placed"=>"Bet Placed",
    "odds_req"=>"Odds req.",

    "profit_loss"=>"Profit/loss",

    "betting_history_text"=>"All matched bets are displayed in aggregated format. Select a Bet ID for a detailed breakdown (for Matched unsettled bets only).",



    "username_or_email"=>"ユーザー名または電子メール",



    "betting_history"=>"ベットの歴史",


    "no_payment_options_for_currency"=>"We don't have payment options for your chosen CURRENCY",


    "expiration_date"=>"有効期限",


    'warning_gambling'=>'警告：賭けることは中毒性があります！',


    //Affiliates Texts
    'purchase'=>'購入',
    'to_get_affiliate_id_purchase'=>'アフィリエイトIDを取得するには、あなたの残高から1.000ユーロ購入してください。',
    'to_get_affiliate_id_purchase_500'=>'アフィリエイトIDを取得するには、あなたの残高から500ユーロ購入してください。',
    'to_get_affiliate_id_purchase_40'=>'アフィリエイトIDを取得するには、あなたの残高から40ユーロ購入してください。',
    'to_become_affiliate_terms_and_conds'=>'アフィリエイトになるには、規約および条件に同意しなければなりません。',
    'register_as_instructor'=>'インストラクターとして登録する',
    'register_as_affiliate'=>'アフィリエイトとして登録する',
    'register_as_governing_partner'=>'ガバニングパートナーとして登録する',
    'governing_partner'=>'ガバニングパートナー',
    'instructor'=>'インストラクター',
    'we_offer_protection_types'=>'ベットプラネットでのプレイに限度を儲けるいくつかの制限をご用意しました。',


    'time_out'=>'時間制限',
    'time_out_protection_text'=>'あなたの口座アクセスをどの程度に控えたいか選んでください。「時間制限」は、あなたがベットプラネット口座のアクセスをどのくらいに控えたいかを選ぶことができます。あなたが選んだ制限期間はサイトでのプレイができなくなります。あなたが選択した期間ベットプラネットサイトのすべてのゲーム使用がブロックされます。',

    'deposit_limits'=>'入金制限 ',
    'deposit_limits_protection_protection_text'=>'下のメニューを使うと、1日、週、月あたりいくら入金したいかを選ぶことができます。これらの制限は入金ページに記載されているメソッドによって提示される上限か最低限度について自由に設定できます。あなたの入金制限は、このメニューを使うといつでも変えることができます。ただし、制限を取り除いたり、増やしたりしたいときは７日の間お待ちいただくことになります。変更期間を考慮して変更してください。',


    'self_exculsion'=>'自己制御 ',
    'self_exculsion_protection_text'=>'自己制限機能は、６ヶ月間このサイトからあなたをブロックします。 万一、あなたの口座を不定期間閉鎖したい場合、support@bookiebot.com までメールでご連絡ください。この操作はどのような状況下でも保存できません。',

    'loss_limits'=>'負け制限',
    'loss_limits_protection_text'=>'下のメニューを使うと、1日、週、月の最大損失額を設定することができます。あなたの制限は、このメニューを使うといつでも変えることができます。ただし、制限を取り除いたり、増やしたりしたいときは７日の間お待ちいただくことになります。変更期間を考慮して変更してください。',

    'wager_limits'=>'支出制限',
    'wager_limits_protection_text'=>'下のメニューを使うと、1日、週、月の最大支出額を設定することができます。一度リミットをセットすると、Eメールで確認メールが届きます。あなたの支出額制限は、このメニューを使うといつでも変えることができます。ただし、制限を取り除いたり、増やしたりしたいときは７日の間お待ちいただくことになります。変更期間を考慮して変更してください。',


    'session_protection'=>'セッション制限',
    'session_protection_text'=>'下のメニューを使うと、時間制限ができます。この制限時間を超えると、システムからログアウトされ、再度ログインしてプレイを再開することが可能になります。あなたの時間制限は、このメニューを使うといつでも変えることができます。ただし、制限を取り除いたり、増やしたりしたいときは７日の間お待ちいただくことになります。変更期間を考慮して変更してください。注意：あなたがこの次ログインするまでは、ここでの変更は有効になりません。',


    'period'=>'期間',
    'per_day'=>'',
    'enter_account_password'=>'口座パスワードを入れる',
    'amount_in_minutes'=>'時間を分で入れる',
    'make_changes'=>'変更する',
    'friend_requests'=>'友人リクエスト',
    'you_don_have_pending_requests'=>'友人リクエスト',


    "you_dont_have_friends"=>"You don't have any fiends",

    "show_intro"=>"Show Tutorial",

    //Newwest
    "forgot_password"=>'パスワードをお忘れですか？',
    "register_now"=>'今すぐ登録',
    "slider_text"=>'口座を開設しよう！最高のベッティング エクスチェンジ マーケットにアクセスしよう！',
    'all_matches'=>"すべての試合",
    'by_clicking_below'=>'下のボタンをクリックすると、あなたは：',
    'confirm_18'=>'あなたは少なくとも18歳であることを確認してください',
    'terms_and_conds'=>'規約と条件',
    'cancel'=>'キャンセル',


    'play'=>'遊びます',
    'all_providers'=>'All Providers',
    'categories'=>'Categories',


    'new'=>'新しい',
    'classic_slots'=>'クラシックスロット',
    'lottery_games'=>'宝くじゲーム',
    'mini_games'=>'ミニゲーム',
    'other_games'=>'その他のゲーム',
    'popular_games'=>'人気ゲーム',
    'table_games'=>'テーブルゲーム',
    'top_slots'=>'トップスロット',
    'video_slots'=>'ビデオスロット',
    'video_poker'=>'ビデオポーカー',


    'terms'=>'私は、規約と条件を理解し、これに同意します。'



);

    
