<?php

if (!defined('APP')) {
    die();
}


class Bankaccounts extends Service
{


    /**
     * Add New Card To Users Account
     * @param $card_type - 1 Credit/DebitCard, 2 - Personal Account
     * @param $card_number
     * @param $expiry_month
     * @param $expiry_year
     * @return array|mixed
     */

    /**
     *
     */
    public function addBankAccount($provider_id, $bank_name, $bank_account, $bank_code, $payee, $swift_code, $country_id) {
        $db = $this->db;
        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            $data_to_insert = array(
                "core_users_id"=>$user_id,
                "money_providers_id"=>$provider_id,
                "IssuerCountry"=>$country_id,
                "account_type"=>2,
                "BankName"=>$bank_name,
                "BankAccount"=>$bank_account,
                "BankCode"=>$bank_code,
                "Payee"=>$payee,
                "SwiftCode"=>$swift_code
            );

            $inserted = $db->insert("money_accounts",$data_to_insert);
            if($inserted) {
                return array("code"=>10,"msg"=>"Bank account was saved successfully");
            } else {
                return array("code"=>30,"msg"=>"cant save new bank account");
            }


        } else {
            return array("code"=>40,"msg"=>"session expired please relogin");
        }


    }

    /**
     * @param $card_id
     * @return array
     */
    public function deleteAccount($account_id) {
        $account_id = (int)$account_id;
        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            $db = $this->db;
            $db->where("core_users_id",$user_id);
            $db->where("id",$account_id);
            $delete = $db->update("money_accounts",array("IsDeleted"=>1));
            if($delete!==false) {
                return array("code"=>10);
            } else {
                echo $db->getLastError();
                return array("code"=>30);
            }

        } else {
            return array("code"=>20);
        }
    }

    /**
     * @return array
     */
    public function getMyBankAccounts($all = false) {
        $user_data = $this->checkUserAccess();

        if ($user_data) {
            $user_id = $user_data['id'];
            $cls = "AND accounts.account_type = 2";
            if($all) {
                $cls = "";
            }
            $db = $this->db;
            $data = $db->rawQuery("
                                    SELECT
                                      accounts.id as account_id,
                                      accounts.AddDate,
                                      accounts.Type,
                                      accounts.Pan,


                                      accounts.account_type,
                                      accounts.BankName,
                                      accounts.BankAccount,
                                      accounts.Payee,
                                      accounts.BankCode,
                                      accounts.SwiftCode,


                                      left_money.amount as active_amount
                                    FROM
                                      money_accounts accounts
                                      LEFT JOIN
                                      money_user_deposits_left_in_system left_money
                                      ON
                                      left_money.money_accounts_id = accounts.id
                                    WHERE
                                    accounts.core_users_id = $user_id
                                    AND
                                    accounts.IsDeleted = 0
                                    $cls
                                    ORDER BY id DESC
                                ");

            if(count($data)) {
                return array("code"=>10,"data"=>$data);
            } else {
                return array("code"=>60);
            }

        } else {
            return array("code"=>20);
        }
    }




}