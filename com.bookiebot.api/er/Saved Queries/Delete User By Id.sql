set @user_id = 116;

delete from old_used_passwords where core_users_id=@user_id;
delete from core_security_answers where core_users_id=@user_id;
delete from core_email_confirmations where core_users_id=@user_id;
delete from core_accesslog where core_users_id=@user_id;
delete from core_logofflog where core_users_id=@user_id;
delete from core_providers_tokens where core_users_id=@user_id;
delete from core_users where id=@user_id;