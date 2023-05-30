<?php


if(!defined('APP')) {
    die();
}


class Laundring extends Service {


    /**
     * @param bool|false $skip
     * @param bool|false $take
     * @param array $filter
     */
    public function getLaundringData($skip = false,$pageSize = 10,$filter = array()) {
        $db = $this->db;

        $skip = (int)$skip;
        $pageSize = (int)$pageSize;

        $KendoClause = $this->ReturnKendoFilterClause($filter,true);


        $qs = "SELECT
                                    winner.id as winner__id,
                                    winner.username as winner__username,


                                    loser.id as loser__id,
                                    loser.username as loser__username,


                                    laundring.amount,
                                    laundring.is_suspect as laundring__is_suspect,
                                    laundring.transfer_date as laundring__transfer_date
                              FROM
                                laundring_transfer_between_users laundring,
                                core_users winner,
                                core_users loser
                              WHERE
                                winner.id = laundring.winer_user
                                AND loser.id = laundring.loser_user

                                $KendoClause

                              GROUP BY laundring.id ORDER BY laundring.transfer_date DESC LIMIT $pageSize OFFSET $skip";


        $data = $db->rawQuery($qs);


        try {
            $total = $db->rawQuery("
SELECT
  count(*) as cnt
FROM
        laundring_transfer_between_users laundring,
        core_users winner,
        core_users loser
WHERE
winner.id = laundring.winer_user
                                AND loser.id = laundring.loser_user

$KendoClause
");


            $total = $total[0]['cnt'];
        } catch(Exception $e) {
            $total = 0;
        }


        return array(
            "data"=>$data,
            "total"=>$total
        );

    }


}