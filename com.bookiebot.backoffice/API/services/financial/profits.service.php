<?php


if (!defined('APP')) {
    die();
}


class Profits extends Service
{

    private $license_mapping = array(
        1 => "MGA",
        2 => "Curacao"
    );


    /**
     *
     */
    public function getProfitsByLicense($from=false, $to = false)
    {

        $db = $this->db;

        if($from == "" || !$from) {
            $from = \Carbon\Carbon::now()->subMonth();
        }

        if($to == "" || !$to) {
            $to = \Carbon\Carbon::now()->addDay();
        }


        $query = "
            SELECT
                IF(tr.license_id=1,'MGA','CURACAO') as License,
                tr.TransactionProfit as profit
            FROM
            (
                SELECT
                    pr.license_id,
                    (
                        SUM(IF(trs.type=1,trs.amount,0)) - SUM(IF(trs.type=2,trs.amount,0))
                        
                    ) as TransactionProfit
                FROM 
                    core_providers_transactions trs, 
                    core_providers pr
                WHERE 
                    pr.id = trs.core_providers_id 
                    AND 
                        trs.transaction_time BETWEEN '$from' AND '$to' 
                GROUP BY 
                    pr.license_id
                order by 
                    TransactionProfit 
                desc
            ) tr
        ";


        $data = $db->rawQuery($query);


        return array(
            'period'=>$from." - ".$to,
            'data'=>$data
        );





    }


}