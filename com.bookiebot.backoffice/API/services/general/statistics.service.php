<?php

if(!defined('APP')) {
    die();
}


use Carbon\Carbon;

class Statistics extends Service
{

    /**
     * @param bool $from - 2015-05-24 01:25:02
     * @param bool $to - 2015-05-28 01:25:02
     * @param bool $by = "DAY","WEEK","MONTH","YEAR"
     * @return array
     */
    public function getStatistics($from = false, $to = false, $by = false)
    {
        $db = $this->db;

        if($from == "") {
            $from = Carbon::now()->subWeek();
        }

        if($to == "") {
            $to = Carbon::now()->addDay();
        }



        $by_available = array("DAY","WEEK","MONTH","YEAR");
        if(!in_array($by,$by_available)) {
            $by = "DAY";
        }
        //Returns
        //1 - Deposits
        //2 - Withdrawals
        //3 - Bets
        //4 - Matched Bets
        $this->from = $from;
        $this->to = $to;
        $this->by = $by;




        return array(

            "deposits_amount" => $this->transactions(1),

            "withdrawals_amount" => $this->transactions(2),

            "bets_amount" => $this->bets_amount(),
            "bets_count" => $this->bets_count(),

            "matched_bets_amount" => $this->matched_bets_amount(),
            "matched_bets_count" => $this->matched_bets_count(),

            "canceled_bets_amount" => $this->canceled_bets_amount(),
            "canceled_bets_count" => $this->canceled_bets_count(),

            "user_registration_count" => $this->user_registration_count(),

            "social_posts_count" => $this->social_posts_count(),

            "total_data" => array(

                "users"=>$this->total_users(),

                "deposits_amount"=>$this->total_deposits(),
                "deposits_count"=>$this->total_deposits_count(),

                "withdrawals_amount"=>$this->total_withdrawals(),
                "withdrawals_count"=>$this->total_withdrawals_count(),

                "bets_count"=>$this->total_bets_count(),
                "bets_amount"=>$this->total_bets_amount(),

                "matched_bets_count"=>$this->total_matched_bets_count(),
                "matched_bets_amount"=>$this->total_matched_bets_amount(),

                "total_unmatched_amount"=>$this->total_unmatched_amount()

            )
        );

    }


    /*******
     * @return mixed
     */
    private function total_users() {
        $db = $this->db;
        $data = $db->rawQuery("SELECT COUNT(*) as cnt FROM core_users");
        return $data[0]['cnt'];
    }


    private function total_deposits() {
        $db = $this->db;
        $data = $db->rawQuery("SELECT SUM(amount)/100 as cnt FROM money_transactions WHERE type=1 AND status=1");
        return $data[0]['cnt'];
    }
    private function total_deposits_count() {
        $db = $this->db;
        $data = $db->rawQuery("SELECT COUNT(*) as cnt FROM money_transactions WHERE type=1 AND status=1");
        return $data[0]['cnt'];
    }

    private function total_withdrawals() {
        $db = $this->db;
        $data = $db->rawQuery("SELECT SUM(amount)/100 as cnt FROM money_transactions WHERE type=2 AND status=1");
        return $data[0]['cnt'];
    }

    private function total_withdrawals_count() {
        $db = $this->db;
        $data = $db->rawQuery("SELECT COUNT(*) as cnt FROM money_transactions WHERE type=2 AND status=1");
        return $data[0]['cnt'];
    }

    private function total_bets_count() {
        $db = $this->db;
        $data = $db->rawQuery("SELECT COUNT(*) as cnt FROM betting_bets bets");
        return $data[0]['cnt'];
    }
    private function total_bets_amount() {
        $db = $this->db;
        $data = $db->rawQuery("SELECT
                SUM(
                      CASE WHEN bets.bet_type = 1
                      THEN
                        (bets.bet_amount*bets.bet_odd) - bets.bet_amount
                      ELSE
                        bets.bet_amount
                      END
                )/100 as cnt FROM betting_bets bets
        ");
        return $data[0]['cnt'];
    }

    private function total_matched_bets_count() {
        $db = $this->db;
        $data = $db->rawQuery("SELECT COUNT(*) as cnt FROM betting_matched_bets");
        return $data[0]['cnt'];
    }

    private function total_matched_bets_amount() {
        $db = $this->db;
        $data = $db->rawQuery("SELECT SUM(betting_pot_amount)/100 as cnt FROM betting_matched_bets");
        return $data[0]['cnt'];
    }


    private function total_unmatched_amount()  {
        $db = $this->db;
        $data = $db->rawQuery("SELECT SUM(unmatched_amount) as cnt FROM betting_bets bets WHERE status IN (0,2)");
        return $data[0]['cnt'];
    }

    /*******
     * @return mixed
     */



    /**
     * @param $type
     * @return array
     */
    private function transactions($type)
    {

        $db = $this->db;

        $qs = "
            SELECT
              SUM(amount) as sum,
              DATE(transaction_date) as date
            FROM
              money_transactions transactions
            WHERE
              transactions.type = $type
              AND
              transactions.status = 1
              AND transactions.transaction_date BETWEEN '$this->from' AND '$this->to'
            GROUP BY
               $this->by(transactions.transaction_date)
          ORDER BY
            transactions.transaction_date DESC
        ";



        $data = $db->rawQuery($qs);

        return $data;
    }


    /**
     * @return array
     */
    private function bets_amount()
    {
        $db = $this->db;
        $data = $db->rawQuery("SELECT
                                  SUM(bets.bet_amount) as sum,
                                  DATE(bets.bets_date) as date
                                FROM
                              betting_bets bets
                              WHERE
                              bets.bets_date BETWEEN '$this->from' AND '$this->to'
                                GROUP BY
                                  $this->by(bets.bets_date)
                              ORDER BY
                                bets.bets_date DESC
                                  ");
        return $data;
    }

    /**
     * @return array
     */
    private function bets_count()
    {
        $db = $this->db;
        $data = $db->rawQuery("SELECT
                                  COUNT(*) as sum,
                                  DATE(bets.bets_date) as date
                                FROM
                              betting_bets bets
                              WHERE bets.bets_date BETWEEN '$this->from' AND '$this->to'
                                GROUP BY
                                   $this->by(bets.bets_date)
                              ORDER BY
                                bets.bets_date DESC
                                  ");
        return $data;
    }


    /**
     *
     */
    private function matched_bets_amount()
    {
        $db = $this->db;

        $data = $db->rawQuery("
           SELECT
                                  SUM(matched_bets.betting_pot_amount) as sum,
                                  SUM(matched_bets.lay_amount_in_pot) as lay_sum,
                                  SUM(matched_bets.back_amount_in_pot) as back_sum,
                                  DATE(matched_bets.matching_time) as date
                                FROM
                              betting_matched_bets matched_bets,
                              betting_bets bets
                              WHERE
                                matched_bets.matching_time BETWEEN '$this->from' AND '$this->to'
                                GROUP BY
                                   $this->by(matched_bets.matching_time)
                              ORDER BY
                                matched_bets.matching_time DESC

        ");

        return $data;
    }

    /**
     * @return array
     */
    private function matched_bets_count()
    {
        $db = $this->db;

        $data = $db->rawQuery("
            SELECT
                                  COUNT(*) as sum,
                                  DATE(matched_bets.matching_time) as date
                                FROM
                              betting_matched_bets matched_bets
                              WHERE matched_bets.matching_time BETWEEN '$this->from' AND '$this->to'
                                GROUP BY
                                   $this->by(matched_bets.matching_time)
                              ORDER BY
                                matched_bets.matching_time DESC

        ");

        return $data;
    }




    private function canceled_bets_amount()
    {
        $db = $this->db;

        $data = $db->rawQuery("
            SELECT
                                  SUM(canceled_bets.returned_amount) as sum,
                                  DATE(canceled_bets.cancel_time) as date
                                FROM
                              betting_bet_cancelations canceled_bets
                              WHERE canceled_bets.cancel_time BETWEEN '$this->from' AND '$this->to'
                                GROUP BY
                                   $this->by(canceled_bets.cancel_time)
                              ORDER BY
                                canceled_bets.cancel_time DESC

        ");

        return $data;
    }


    private function canceled_bets_count()
    {
        $db = $this->db;

        $data = $db->rawQuery("
            SELECT
                                  COUNT(*) as sum,
                                  DATE(canceled_bets.cancel_time) as date
                                FROM
                              betting_bet_cancelations canceled_bets
                              WHERE canceled_bets.cancel_time BETWEEN '$this->from' AND '$this->to'
                                GROUP BY
                                   $this->by(canceled_bets.cancel_time)
                              ORDER BY
                               canceled_bets.cancel_time DESC

        ");

        return $data;
    }


    private function user_registration_count() {
        $db = $this->db;

        $data = $db->rawQuery("
            SELECT
                                  COUNT(*) as sum,
                                  DATE(users.registration_date) as date
                                FROM
                              core_users users
                              WHERE users.registration_date BETWEEN '$this->from' AND '$this->to'
                                GROUP BY
                                   $this->by(users.registration_date)
                              ORDER BY
                               users.registration_date DESC

        ");

        return $data;
    }


    private function social_posts_count() {
        $db = $this->db;

        $data = $db->rawQuery("
            SELECT
                                  COUNT(*) as sum,
                                  DATE(posts.post_date) as date
                                FROM
                              social_posts posts
                              WHERE posts.post_date BETWEEN '$this->from' AND '$this->to'
                                GROUP BY
                                   $this->by(posts.post_date)
                              ORDER BY
                               posts.post_date DESC

        ");

        return $data;
    }



}