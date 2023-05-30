<?php


class Gametransactions extends Service
{


    /**
     * @param bool $fromDate
     * @param bool $toDate
     * @param bool $type
     * @param bool $user_id
     * @param bool $provider_id
     * @param bool $transaction_id
     * @param bool $status ;
     *                      0 - Initialization,
     *                      1 - Confirmation,
     *                      2 - Rejection,
     *                      3 - Not Payed
     * @return array
     */
    public function getTransactionsList($skip = false, $pageSize = 10, $filter = array())
    {


        $db = $this->db;


        $clause = $this->ReturnKendoFilterClause($filter, true);


        $skip = (int)$skip;
        $pageSize = (int)$pageSize;


        $qs = "
              select
                transactions.id as transactions__id,
                transactions.transaction_unique_id as transactions__transaction_unique_id,
                transactions.amount as transaction_amount,
                transactions.transaction_time as transactions__transaction_time,
                transactions.status as transactions__status,
                transactions.type as transactions__type,#1 - Core To Game; Game CashIn2 - Game To Core; Game CashOut,3 - Rollback Deposit,4 - Rolback Withdraw
                
                
                users.id as users__id,
                users.username as username,
                
                providers.id as providers__id,
                providers.provider_name as provider_title,
                providers.license_id as providers__license_id,
                
                currency.iso_code as currency_iso_code,
                currency.name as currency_name
                
                
                
              from
                core_providers_transactions transactions,
                core_currencies currency,
                core_users users,
                core_providers providers
              where
                transactions.core_users_id = users.id
                AND transactions.core_providers_id = providers.id
                AND transactions.core_currencies_id = currency.id
                
                $clause
               GROUP BY transactions.id
                ORDER BY
                  transactions.id
                DESC
                LIMIT $pageSize OFFSET $skip
        ";


//        echo $qs;
        $total = 0;
        $data = array();
        $instance = $db->getSQLIInstance();
        if ($result = $instance->query($qs)) {


            if($result2 = $instance->query("SELECT COUNT(*) as cnt FROM core_providers_transactions WHERE id>0 $clause")) {
                while ($row2 = mysqli_fetch_assoc($result2)) {
                    $total = $row2['cnt'];
                }
            }

            while ($row = mysqli_fetch_assoc($result)) {
                array_push($data, $row);
            }
        }


        return array("code" => 10, "data" => $data, "total" => $total);

    }


    public function getTransactionDetails() {

    }


}