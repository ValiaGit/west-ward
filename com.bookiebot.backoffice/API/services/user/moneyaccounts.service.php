<?php


if(!defined('APP')) {
    die();
}


class Moneyaccounts extends Service
{


    /**
     * @param int $user_id
     * @return array
     *      identity_type; 1 - Passport
    2 - Driving License
    3 - Personal Card
     */
    public function getMoneyAccounts($users_id = 0) {

        $user_id = (int) $users_id;

        $db = $this->db;
        $clause = " AND money_accounts.core_users_id = $user_id ";

        $qs = "
                SELECT
                  money_accounts.*,
                  money_providers.title as money_provider_title
                FROM
                  money_accounts,
                  money_providers,
                  core_users
                WHERE
                  money_accounts.money_providers_id = money_providers.id
                  AND
                  money_accounts.IsDeleted = 0
                  AND
                  core_users.id = money_accounts.core_users_id
                  $clause
                  GROUP BY money_accounts.id
            ";


//        echo $qs;

        $data = $db->rawQuery($qs);



        return array("code"=>10,"data"=>$data);
    }


    /**
     * @param int $document_id
     * @return array
     */
    public function verifyMoneyAccount($account_id = 0) {
        if(!$account_id) {
            return array("code"=>50);
        }

        $db = $this->db;

        $db->where("id",$account_id);
        $update = $db->update("money_accounts",array(
            "ConfirmationStatus"=>1
        ));


        if($update) {

            $this->saveLog("User money account was verified: AccountId:$account_id");
            return array("code"=>10);
        } else {
            return array("code"=>20);
        }
    }


    /**
     * @param int $document_id
     * @return array
     */
    public function unVerifyMoneyAccount($account_id = 0) {
        if(!$account_id) {
            return array("code"=>50);
        }

        $db = $this->db;

        $db->where("id",$account_id);
        $update = $db->update("money_accounts",array(
            "ConfirmationStatus"=>0
        ));


        if($update) {
            $this->saveLog("User money account was un verified: AccountId:$account_id");
            return array("code"=>10);
        } else {
            return array("code"=>20);
        }
    }

}