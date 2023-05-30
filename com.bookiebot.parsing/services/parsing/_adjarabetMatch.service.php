<?php

if (!defined('APP')) {
    die();
}


/**
 * Is Responsible For Betting Data To Get For Example How Many Bets Was Made On Certain Odd
 * Class Bets
 */
class _AdjarabetMatch extends Service
{

    //Getting List Of Sport->Country->League
    private $sportUrl = "https://bookmakersapi.adjarabet.com/sportsbook/rest/public/sportMatches?ln=en&id=";

    private $local_sports = array(
        27 => 371, // soccer
        30 => 375, // basketball
        29 => 372, // tennis
        36 => 392, // ice hockey
        43 => 379, // rugby
        37 => 387, // handball
        //77 => 403, // boxing
    );

    public function process() {


        foreach ($this->local_sports as $remote => $local) {
            $this->parse_sport($remote);
        }

    }

    private function parse_sport($sport_id) {
        $db = $this->db;
        $sport_local_id = $this->local_sports[$sport_id];

        $json = file_get_contents($this->sportUrl.$sport_id);
        $sport = json_decode($json,false);

        echo "<pre>";
        //var_export( $sport );

        //die();

        foreach ( $sport AS $tournament_id => $tournament ) {

            echo PHP_EOL."Tournament id: ".$tournament_id.PHP_EOL;

            foreach ($tournament as $match) {

                $match_id = $match->id;
                $match_start_date = $match->sd;

                $favorite = $match->f;

                $competitor_h_name = $match->h;
                $competitor_h_id = $match->hId;
                $competitor_a_name = $match->a;
                $competitor_a_id = $match->aId;

                /*
                * Set Competitors
                */
                // set Home Competitor
                $db->where('BetradarCompetitorId',$competitor_h_id);
                $db->where('betting_sport_id',$sport_local_id);
                $exists_h = $db->getOne("betting_competitors");

                if ( !$exists_h ) {
                    $insert_data = array(
                        "BetradarCompetitorId"=>$competitor_h_id,
                        "betting_sport_id"=>$sport_local_id,
                        "title"=>json_encode(array(
                            "BET" => $competitor_h_name,
                            'en'  => $competitor_h_name,
                            'ka'  => $competitor_h_name,
                            'de'  => $competitor_h_name,
                            'ja'  => $competitor_h_name,
                            'ru'  => $competitor_h_name,
                        )),
                    );
                    $competitor_h_local_id = $db->insert('betting_competitors',$insert_data);
                } else {
                    $competitor_h_local_id = $exists_h['id'];
                }

                // set Away Competitor
                $db->where('BetradarCompetitorId',$competitor_a_id);
                $db->where('betting_sport_id',$sport_local_id);
                $exists_a = $db->getOne("betting_competitors");

                if ( !$exists_a ) {
                    $insert_data = array(
                        "BetradarCompetitorId"=>$competitor_a_id,
                        "betting_sport_id"=>$sport_local_id,
                        "title"=>json_encode(array(
                            "BET" => $competitor_a_name,
                            'en'  => $competitor_a_name,
                            'ka'  => $competitor_a_name,
                            'de'  => $competitor_a_name,
                            'ja'  => $competitor_a_name,
                            'ru'  => $competitor_a_name,
                        )),
                    );
                    $competitor_a_local_id = $db->insert('betting_competitors',$insert_data);
                } else {
                    $competitor_a_local_id = $exists_a['id'];
                }


                /*
                * Check Tournament
                */
                $db->where('BetradarTournamentId',$tournament_id);
                $exists_t = $db->getOne("betting_tournament");

                if ( !$exists_t ) {
                    continue;
                }

                /*
                * Set Match
                */
                $db->where('BetradarMatchId',$match_id);
                $db->where('betting_tournament_id',$exists_t['id']);
                $db->where('betting_sport_id',$sport_local_id);
                $exists_m = $db->getOne("betting_match");

                if ( !$exists_m ) {
                    $insert_data = array(
                        "BetradarMatchId"=>$match_id,
                        "betting_tournament_id"=>$exists_t['id'],
                        "betting_sport_id"=>$sport_local_id,
                        "betting_category_id"=>$exists_t['betting_category_id'],
                        "betting_competitors_id"=>$competitor_h_local_id,
                        "betting_competitors_id1"=>$competitor_a_local_id,
                        "starttime"=> date("Y-m-d H:i:s", strtotime($match_start_date)),
                        "type"=>1,
                        "status"=>1,
                        "top"=>$favorite
                    );
                    $match_local_id = $db->insert('betting_match',$insert_data);



                    if ( $match_local_id ) {
                        echo " (Match Added - $match_local_id )";

                        $odds = $db->insertMulti('betting_match_odds',array(
                            array(
                                'betting_match_id' => $match_local_id,
                                'betting_odds_id'  => 508,
                                'status'           => 1
                            ),
                            array(
                                'betting_match_id' => $match_local_id,
                                'betting_odds_id'  => 509,
                                'status'           => 1
                            ),
                        ));

                        if ( !$odds ) {
                            $db->where('id', $match_local_id);
                            $db->delete('betting_match');
                        }





                    } else {
                        var_export( $db->getLastError() );
                        echo " vcadet magram Matchi ver davamatet :( ";
                    }

                } else {
                    $match_local_id = $exists_h['id'];
                }



                //var_export($match);
                //break;
            }



            //var_export($tournament);

            //break;
        }
    }

}
