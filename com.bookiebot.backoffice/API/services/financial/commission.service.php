<?php


if(!defined('APP')) {
    die();
}


class Commission extends Service {



    public function getCommissions($skip = false, $pageSize = 10, $filter = array(), $from=false, $to = false) {

        $db = $this->db;

        $date_range_clause = "";
        if($from) {
            $date_range_clause .=" AND create_date>'$from' ";
        }
        if($to) {
            $date_range_clause .=" AND create_date<'$to' ";
        }


        $KendoClause = $this->ReturnKendoFilterClause($filter,true);



        $qs = "

        SELECT
          commissions.id,
          commissions.create_date as commissions__create_date,
          commissions.betting_matched_bets_id as commissions_betting_matched_bets_id,
          commissions.amount,
          commissions.winner_bet_id as commissions__winner_bet_id,
          commissions.loser_bet_id as commissions__loser_bet_id,


          winner_bet.core_users_id as winner_bet__core_users_id,
          winner_user.username as winner_username,

          winner_bet.bet_type as winner_bet_bet_type,
          winner_bet.bet_amount/100 as winner_bet_bet_amount,

          loser_bet.core_users_id as loser_bet__core_users_id,
          loser_user.username as loser_username,

          loser_bet.bet_type as loser_bet_bet_type,
          loser_bet.bet_amount/100 as loser_bet_bet_amount,


          matching_data.betting_pot_amount,
          matching_data.back_amount_in_pot,
          matching_data.lay_amount_in_pot





        FROM
          betting_commissions commissions,

          betting_bets winner_bet,
          betting_bets loser_bet,

          core_users loser_user,
          core_users winner_user,


          betting_matched_bets matching_data



        WHERE
         winner_bet.id = commissions.winner_bet_id
         AND
         loser_bet.id = commissions.loser_bet_id
         AND

         loser_user.id = loser_bet.core_users_id
         AND
         winner_user.id = winner_bet.core_users_id

         AND
         matching_data.id = commissions.betting_matched_bets_id



            $KendoClause
      ORDER BY commissions.create_date DESC

        LIMIT $pageSize OFFSET $skip
        ";


        $data = $db->rawQuery($qs);



        $total = $db->rawQuery("SELECT count(commissions.id) as cnt from betting_commissions commissions,
          betting_bets winner_bet,
          betting_bets loser_bet
        WHERE
         winner_bet.id = commissions.winner_bet_id
         AND
         loser_bet.id = commissions.loser_bet_id $KendoClause");



        $return = array("code"=>10,"data"=> $data,"total"=>$total[0]['cnt']);
        return $return;
    }


}