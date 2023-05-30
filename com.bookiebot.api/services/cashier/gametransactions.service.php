<?php


if(!defined('APP')) {
    die();
}

class Gametransactions extends Service
{

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
            $typeClause = "AND pt.type = $type";
        }

        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            $db = $this->db;


            /**
            1 - Core To Game; Game CashIn
            2 - Game To Core; Game CashOut
            3 - Rollback Deposit
            4 - Rolback Withdraw
             */


            $qs = "
            SELECT
              pt.id,
              pt.transaction_unique_id,
              pt.provider_transactions_id,
              pt.transaction_time,
              pt.type,
              pt.status,
              pt.amount,
              pt.core_currencies_id,
              pt.game_id,
              pt.additional_data,
              INET_NTOA(pt.ip) as ip,
              
              p.provider_name,
              p.license_id
              
            FROM
              core_providers_transactions pt,
              core_providers p
            WHERE
              pt.core_users_id = $user_id
              
              $typeClause
              
              AND 
                pt.transaction_time BETWEEN '$from' AND '$to' 
              AND 
                p.id = pt.core_providers_id
              GROUP BY 
                pt.id 
              ORDER BY 
                pt.id 
              DESC
              
            ";

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