<?php


if (!defined('APP')) {
    die();
}


class Categories extends Service
{


    /**
     * Get the array of categories for the left menu (Soccer->England->Premier League)
     * @return array
     */
    public function getCategoryList($intervalMinutes = false) {

        $data = $this->getData($intervalMinutes);
        $sorted = array();

        //iterate over nodes
        for($i=0;$i<count($data);$i++) {
            $currentNode = $data[$i];

            //Sport Id And Title
            $sid = (string) $currentNode['sId'];

            $sTitle = $this->getUnserializedTitle($currentNode['sTitle']);

            //Group Id And Title
            $gid = (int)$currentNode['cId'];

            $cTitle = $this->getUnserializedTitle($currentNode['cTitle']);


            //League Id And Title
            $lid = (int)$currentNode['tId'];
            $tTitle = $this->getUnserializedTitle($currentNode['tTitle']);



            if(isset($currentNode['oId'])) {
                $oid = (int)$currentNode['oId'];
                $oTitle = $this->getUnserializedTitle($currentNode['oTitle']);
            }


            //Save Sport Nodes
            if(!isset($sorted[$sid])) {
                $sorted[$sid] = array(
                    "n"=>$sTitle,
                    "i"=>$currentNode['sCode'],
                    "c"=>array()
                );
            }

            //Save Group Nodes
            if(!isset($sorted[$sid]['c'][$gid]) && $gid) {
                $sorted[$sid]['c'][$gid] = array(
                    'n'=>$cTitle,
                    "i"=>$currentNode['cCode'],
                    't'=>array()
                );
            }


            if(!isset($currentNode['user_fav_tournament'])) {
                $currentNode['user_fav_tournament'] = NULL;
            }
            //Save League Nodes
            if(!isset($sorted[$sid]['c'][$gid]['t'][$lid]) && $lid) {
                    $sorted[$sid]['c'][$gid]['t'][$lid] = array(
                        'n'=>$tTitle,
                        'f'=>(int)$currentNode['isFav'],
                        "uf"=>$currentNode['user_fav_tournament']!=NULL?true:false
                    );
            }

            if(isset($currentNode['oId'])) {
                $oid = (int)$currentNode['oId'];
                if(!isset($sorted[$sid]['c'][$gid]['t'][$oid]) && $oid) {
                    $sorted[$sid]['c'][$gid]['t'][$oid] = array(
                        'n'=>$oTitle,
                        "o"=>true,
                        "uf"=>$currentNode['user_fav_tournament']!=NULL?true:false,
                        'f'=>false
                    );
                }
            }
//            //Save Outright League Nodes


        }

        return $sorted;
    }


    /**
     * @return array
     */
    private function getData($intervalMinutes = false) {
        $db = $this->db;
//echo $intervalMinutes;
        $intervalString="";
        $intervalStringOutright="";
        if((int)$intervalMinutes) {
            $minutes = (int) $intervalMinutes;
            $intervalString.=" AND  betting_match.starttime < DATE_ADD(NOW(),INTERVAL $minutes MINUTE) ";
            $intervalStringOutright.=" AND  betting_outright.EventEndDate < DATE_ADD(NOW(),INTERVAL $minutes MINUTE) ";
        }


            $qs = "
                                  SELECT

                                    betting_sport.id as sId,
                                    betting_sport.title as sTitle,

                                    betting_sport.code as sCode,
                                    betting_category.id as cId,
                                    betting_category.code as cCode,
                                    betting_category.title as cTitle,

                                    betting_tournament.id as tId,
                                    betting_tournament.is_favourite as isFav,
                                    betting_tournament.title as tTitle,

                                    betting_outright.id as oId,
                                    betting_outright.title as oTitle

                                 FROM

                                     betting_sport

                                     INNER JOIN
                                       betting_category
                                     ON
                                       betting_category.betting_sport_id = betting_sport.id


                                     LEFT JOIN
                                        betting_outright
                                     ON
                                        betting_outright.betting_category_id = betting_category.id
                                        AND
                                        betting_outright.status = 1
                                        AND
                                        
                                        betting_outright.EventEndDate > NOW()
                                        $intervalStringOutright

                                     INNER JOIN
                                       betting_tournament
                                     ON
                                       betting_tournament.betting_category_id = betting_category.id
                                        AND
                                       betting_tournament.status = 1

                                     INNER JOIN
                                      betting_match
                                     ON
                                      betting_match.betting_tournament_id = betting_tournament.id
                                        AND
                                      betting_match.status = 1
                                        AND
                                      betting_match.starttime > NOW()
                                    $intervalString

                                WHERE
                                  betting_sport.status = 1
                                  ";
//        echo $qs;





        $data = array();
        $instance = $db->getSQLIInstance();
        $results = $instance->query($qs);
        echo $db->getLastError();
        if($results->num_rows) {
            while($row = mysqli_fetch_assoc($results)) {
                array_push($data,$row);
            }
        }


        //$result = $db->rawQuery($qs);



        return $data;
    }


    /**
     * @param $tournament_id
     * @return array
     */
    public function addFavTournament($tournament_id) {
        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            $db = $this->db;
            $inserted = $db->insert("core_users_has_betting_tournament_favorited",array("core_users_id"=>$user_id,"betting_tournament_id"=>$tournament_id));
//            echo $db->getLastError();

            if($inserted!==false) {
                return array("code"=>10);
            } else {
                return array("code"=>30);
            }
        } else {
            return array("code"=>40);
        }
    }

    /**
     * @param $tournament_id
     * @return array
     */
    public function removeFavTournament($tournament_id) {
        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            $db = $this->db;
            $db->where("core_users_id",$user_id);
            $db->where("betting_tournament_id",$tournament_id);
            $deleted = $db->delete("core_users_has_betting_tournament_favorited");
            if($deleted!==false) {
                return array("code"=>10);
            } else {
                return array("code"=>30);
            }

        } else {
            return array("code"=>40);
        }
    }


    /**
     * @return array
     */
    public function getUserFavTournaments() {
        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            $db = $this->db;
            $data = $db->rawQuery("SELECT t.title,t.id FROM betting_tournament t,core_users_has_betting_tournament_favorited hsf WHERE hsf.core_users_id = $user_id AND hsf.betting_tournament_id = t.id");
            foreach($data as &$fav_tournament_node) {
                $fav_tournament_node['title'] = $this->getUnserializedTitle($fav_tournament_node['title']);
            }
            return $data;
        }

        else {
            return array("code"=>20);
        }
    }
}


?>