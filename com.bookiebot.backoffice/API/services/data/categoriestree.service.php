<?php


if (!defined('APP')) {
    die();
}


class Categoriestree extends Service
{


    /**
     * Get the array of categories for the left menu (Soccer->England->Premier League)
     * @return array
     */
    public function getCategoryList($toDate = "") {
        $data = $this->getData($toDate);
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



            //Save League Nodes
            if(!isset($sorted[$sid]['c'][$gid]['t'][$lid]) && $lid) {
                $sorted[$sid]['c'][$gid]['t'][$lid] = array(
                    'n'=>$tTitle,
                    'f'=>(int)$currentNode['isFav']
                );
            }

            if(isset($currentNode['oId'])) {
                $oid = (int)$currentNode['oId'];
                if(!isset($sorted[$sid]['c'][$gid]['t'][$oid]) && $oid) {
                    $sorted[$sid]['c'][$gid]['t'][$oid] = array(
                        'n'=>$oTitle,
                        "o"=>true,
                        'f'=>false
                    );
                }
            }
//            //Save Outright League Nodes


        }

        return $sorted;
    }

    /**
     * @param $category_id
     * @return array
     */
    private function getOutrightByCategoryId($category_id) {
        $category_id = (int) $category_id;
        $db = $this->db;

        $db->where("betting_category_id",$category_id);
        $outright = $db->get("betting_outright",null,"id,title");



        $return = array();
        foreach($outright as $cur_out) {
            $return[$cur_out['id']] = array(
                "title"=>$this->getUnserializedTitle($cur_out['title'])
            );
        }
        return $return;
    }


    /**
     * @return array
     */
    private function getData() {
        $db = $this->db;

        $result = $db->rawQuery("
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


                                     INNER JOIN
                                       betting_tournament
                                     ON
                                       betting_tournament.betting_category_id = betting_category.id
                                        AND
                                       betting_tournament.status = 1




                                WHERE
                                  betting_sport.status = 1

                                  ");



        return $result;
    }



}


?>