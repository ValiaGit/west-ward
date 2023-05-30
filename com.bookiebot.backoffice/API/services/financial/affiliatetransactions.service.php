<?php


class Affiliatetransactions extends Service
{


    /**
     * @param bool $skip
     * @param int $pageSize
     * @param array $filter
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
                transactions.amount as transaction_amount,
                transactions.created_at as transactions__transaction_time,
                transactions.type as transactions__type,
                
                users.id as users__id,
                users.username as username
                
                
              
              from
                money_affiliate_transactions transactions,
                core_users users
              where
                transactions.user_id = users.id
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


            if($result2 = $instance->query("SELECT COUNT(*) as cnt FROM money_affiliate_transactions WHERE id>0 $clause")) {
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


    /**
     *
     */
    public function getTransactionDetails() {

    }


}