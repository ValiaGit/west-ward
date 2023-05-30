<?php


if(!defined('APP')) {
    die();
}

class Transactions extends Service {


    /**
     * Returns List Of Transactions By Date For Current Logged in User
     * @param int $from
     * @param int $to
     * @return array
     */
    public function getTransactionsList($from = 0,$to = 0,$type = 0) {
        if(!$from && !$to) {
            $from = $_POST['from'];
            $to = $_POST['to'];
        }



        if(empty($from) || empty($to) || !$from || !$to) {
            return array("code"=>50);
        }

        $type = (int)$type;
        $typeClause = "";
        if($type) {
            $typeClause = "AND money_transactions.type = $type";
        }

        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            $db = $this->db;

            $qs = "
                SELECT
                     money_providers.title as pTitle,


                     money_transactions.transaction_date as dt,
                     money_transactions.amount,
                     money_transactions.cut_amount,
                     money_transactions.commission,
                     money_transactions.type,
                     money_transactions.transfer_type,
                     money_transactions.status,


                     money_transactions.transaction_unique_id as uid,
                     money_accounts.Pan,
                     money_accounts.account_type,
                     money_accounts.BankAccount

                FROM
                  money_transactions
                  
                  
                LEFT JOIN
                  money_accounts
                ON
                  money_transactions.money_accounts_id = money_accounts.id
                  
                  
                INNER JOIN
                  money_providers
                ON
                 money_providers.id = money_transactions.money_providers_id
                WHERE
                  money_transactions.core_users_id = $user_id

                  $typeClause
                  AND
                  money_transactions.status IN (1,2,3,4,5)
                  AND
                  money_transactions.transaction_date BETWEEN '$from' AND '$to' GROUP BY money_transactions.id ORDER BY money_transactions.id DESC
            ";
//            echo $qs;
            $data = $db->rawQuery($qs);
            if(!count($data)) {
                return array("code"=>60);
            }
            return array("code"=>10,"data"=>$data);
        }
        else {
            return array("code"=>40);
        }


    }




}



?>