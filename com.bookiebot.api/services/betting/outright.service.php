<?php



if(!defined('APP')) {
    die();
}

class Outright extends Service {


    public function getOutrightTournament($outright_id = 0) {

        if(!$outright_id) {
            $outright_id = (int) $_POST['outright_id'];
        }


        $db = $this->db;


        $outright = $db->rawQuery("
            SELECT

              outright.title as outright_title,
              sport.title as sport_title,
              category.title as category_title,

              outright_odds.id as odd_id,
              outright_odds.title as odd_title


            FROM
              betting_outright outright

            INNER JOIN
              betting_sport sport
            ON
              sport.id = outright.betting_category_betting_sport_id

            INNER JOIN
              betting_category category
            ON
              category.id = outright.betting_category_id


            LEFT JOIN
              betting_outright_odds outright_odds
            ON
              outright_odds.betting_outright_id = outright.id



            WHERE
              outright.id = $outright_id
              AND
              outright.EventEndDate > NOW()
        ");



        $outright_data = array(
            "data"=>array()
        );

       foreach($outright as &$value) {

           $odd_title = $this->getUnserializedTitle($value['odd_title']) ? $this->getUnserializedTitle($value['odd_title']) : $value['odd_title'];

           $bets_service = $this->loadService("betting/bets");


//           print_r($value);
           $bet_data = $bets_service->getOddsDataByOutrightOddId($value['odd_id']);
            //print_r($bet_data);
           array_push($outright_data['data'],array(
                "id"=>$value['odd_id'],
                "p"=>1,
                "n"=>$odd_title,
                "i"=>false,
                "l"=>$bet_data['availableLays'],
                "b"=>$bet_data['availableBacks']
           ));

       }

       return $outright_data;

    }



}