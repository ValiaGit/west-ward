<?php


if(!defined('APP')) {
    die();
}


class Liabilities extends Service {



    public function getLiabilities() {

        $db = $this->db;

        $total = 0;


        //User Balances
        $qs = "SELECT SUM(balance)/100 as balances FROM core_users";
        $balances_sum = $db->rawQuery($qs);
        if(count($balances_sum)) {
            try {
                if($balances_sum[0]['balances']) {
                    $total+=$balances_sum[0]['balances'];
                }
            }catch(Exception $e) {

            }

        }

        //Wire Transfers Waitting To Be Sent To Users
        $qs = "SELECT SUM(cut_amount)/100 as total_amount_sent FROM money_transactions WHERE status = 5";
        $wire_sum = $db->rawQuery($qs);
        if(count($wire_sum)) {
            try {
                if($wire_sum[0]['total_amount_sent']) {
                    $total+=$wire_sum[0]['total_amount_sent'];
                }
            }catch(Exception $e) {

            }

        }


        $return = array("code"=>10,"total"=>$total);



        return $return;
    }


}