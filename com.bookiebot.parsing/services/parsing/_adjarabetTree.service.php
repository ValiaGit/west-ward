<?php

if (!defined('APP')) {
    die();
}


/**
 * Is Responsible For Betting Data To Get For Example How Many Bets Was Made On Certain Odd
 * Class Bets
 */
class _AdjarabetTree extends Service
{

    //Getting List Of Sport->Country->League
    private $treeUrl = "https://bookmakersapi.adjarabet.com/sportsbook/rest/public/sportbookTree?ln=en";

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

        $db = $this->db;

        $json = file_get_contents($this->treeUrl);
        $tree = json_decode($json,false);

        //echo "<pre>";
        //var_export( $tree->s );


        foreach ($tree->s as $sport) {
            if ( !isset($this->local_sports[$sport->id]) ) {
                continue;
            } else {
                $sport_id = $this->local_sports[$sport->id];
            }
            echo $sport_id.":".$sport->n." <br />";


            foreach ($sport->c as $country) {

                $db->where('code',$country->c);
                $db->where('betting_sport_id',$sport_id);
                $exists_c = $db->getOne("betting_category");

                if ( !$exists_c ) {
                    $insert_data = array(
                        "betting_sport_id"=>$sport_id,
                        "title"=>json_encode(array(
                            "BET" => $country->n,
                            'en'  => $country->n,
                            'ka'  => $country->n,
                            'de'  => $country->n,
                            'ja'  => $country->n,
                            'ru'  => $country->n,
                        )),
                        "code"=>$country->c
                    );
                    $exists_c_id = $db->insert('betting_category',$insert_data);
                } else {
                    $exists_c_id = $exists_c['id'];
                }

                echo " - - - - -  :".$country->c." <br />";



                foreach ($country->l as $league) {


                    $db->where('betting_category_id',$exists_c_id);
                    $db->where('BetradarTournamentID',$league->id);
                    $exists_t = $db->getOne("betting_tournament");

                    if ( !$exists_t ) {


                        $insert_data = array(
                            "betting_category_id"=>$exists_c_id,
                            "BetradarTournamentID" => $league->id,
                            "status" => 1,
                            "title"=>json_encode(array(
                                "BET" => $league->n,
                                'en'  => $league->n,
                                'ka'  => $league->n,
                                'de'  => $league->n,
                                'ja'  => $league->n,
                                'ru'  => $league->n,
                            )),
                        );
                        $exists_t_id = $db->insert('betting_tournament',$insert_data);
                        echo " - - - - -  - - - - - ".$exists_t_id.":".$league->n." <br />";
                    } else {
                        $exists_t_id = $exists_t['id'];
                    }


                }

            }

        }

    }

}
