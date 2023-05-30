<?php


if(!defined('APP')) {
    die();
}


class Transactions extends Service {


    /**
     * @param bool $fromDate
     * @param bool $toDate
     * @param bool $type
     * @param bool $user_id
     * @param bool $provider_id
     * @param bool $transaction_id
     * @param bool $status;
     *                      0 - Initialization,
     *                      1 - Confirmation,
     *                      2 - Rejection,
     *                      3 - Not Payed
     * @return array
     */
    public function getTransactionsList($skip = false, $pageSize = 10, $filter = array()) {


        $db = $this->db;


        $clause = $this->ReturnKendoFilterClause($filter, true);


        $skip = (int)$skip;
        $pageSize = (int)$pageSize;




        $qs = "
                SELECT

                    transactions.id as transactions__id,
                    transactions.transaction_unique_id as transactions_transaction_unique_id,
                    transactions.bank_transaction_id as transactions_bank_transaction_id,

                    transactions.amount as transactions_amount,
                    transactions.commission as transactions_commission,
                    transactions.cut_amount as transactions_net_amount,

                    transactions.status as transactions__status,
                    transactions.bank_status as transactions_bank_status,

                    transactions.type as transactions__type,
                    transactions.ip as transactions_ip,
                    transactions.is_manual_adjustment as transactions__is_manual_adjustment,

                    DATE_FORMAT(transactions.transaction_date, '%Y-%m-%dT%TZ') as transactions__transaction_date,
                    transactions.bank_transaction_date as transactions_bank_transaction_date,

                    CONCAT(users.first_name ,' ',users.last_name) as users_fullname,
                    users.id as users__id,

                    accoount.Pan as account_pan,
                    accoount.account_type as account_account_type,
                    accoount.BankName as account_bankname,
                    accoount.BankAccount as account_bankaccount,
                    accoount.Payee as account_payee,
                    accoount.BankCode as account_bankcode,
                    accoount.SwiftCode as account_swiftcode,

                    providers.title as provider_title

                FROM
                  money_transactions transactions

                INNER JOIN
                money_providers providers
                ON
                providers.id = transactions.money_providers_id

                INNER JOIN
                core_users users
                ON
                users.id = transactions.core_users_id

                INNER JOIN
                money_accounts accoount
                ON
                accoount.id = transactions.money_accounts_id



               $clause
               GROUP BY transactions.id
                ORDER BY
                  transactions.id
                DESC
                LIMIT $pageSize OFFSET $skip
        ";


        $data = array();
        $instance = $db->getSQLIInstance();
        if($result = $instance->query($qs)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $row['transactions__is_manual_adjustment'] = (int)$row['transactions__is_manual_adjustment'];

                if($row['transactions__is_manual_adjustment']) {
                    $row['account_pan'] = "";
                }

                array_push($data,$row);
            }
        }


        return array("code"=>10,"data"=>$data,"total"=>10);

    }


    /**
     * @param $transaction_id
     * @return array
     */
    public function updateTransactionAsCompleted($transaction_id) {
        $db = $this->db;
        $transaction_id = (int)$transaction_id;


        if(!$transaction_id) {
            return array("code"=>30,"msg"=>"Transaction Id is wrong");
        }

        $db->where('id',$transaction_id);
        $update = $db->update('money_transactions',array('status'=>1));
        if($update !== false) {
            $this->saveLog("Wire Transfer transaction was marked as completed!, TransactionId: $transaction_id");
            return array("code"=>10,"msg"=>"Transaction Was Updated Success fully");
        } else {
            return array("code"=>20,"msg"=>"Cant update at the moment!");
        }
    }


    /**
     * @param $transaction_id
     */
    public function cancelTransaction($transaction_id) {
        $db = $this->db;
        $transaction_id = (int)$transaction_id;


        if(!$transaction_id) {
            return array("code"=>30,"msg"=>"Transaction Id is wrong");
        }


        $db->startTransaction();



        $db->where('id',$transaction_id);
        $transaction_details = $db->getOne('money_transactions','core_users_id,amount,money_providers_id');
        if($transaction_details) {

            if($transaction_details['money_providers_id']!=2) {
                return array("code"=>20,"msg"=>"Only wire transfer can be cancel manually!");
            }

            $users_id = $transaction_details['core_users_id'];
            $amount = $transaction_details['amount'];

            $db->where('id',$users_id);
            $update_user_balance = $db->update('core_users',array('balance'=>$db->inc($amount)));



            $db->where('id',$transaction_id);
            $update = $db->update('money_transactions',array('status'=>2,'is_manual_adjustment'=>1));


            if($update !== false && $update_user_balance!==false) {
                $db->commit();
                $this->saveLog("Wire Transfer Transaction=$transaction_id, Was Canceled And Returened Money=$amount Back on Users=$users_id Account.");
                return array("code"=>10,"msg"=>"Transaction Was Updated Success fully");
            } else {
                $db->rollback();
                return array("code"=>20,"msg"=>"Cant update at the moment!");
            }


        } else {
            return array("code"=>20,"msg"=>"Cant update at the moment!");
        }



    }

}

