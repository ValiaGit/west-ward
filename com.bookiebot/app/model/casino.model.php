<?php
/**
 * Created by JetBrains PhpStorm.
 * User:
 * Date: 10/23/13
 * Time: 4:15 PM
 * To change this template use File | Settings | File Templates.
 */
if (!defined("APP")) {
    die("No Access");
}


class Casino_Model extends Model
{

    public function get_list($data) {
    	global $db;

        if( is_int( $data['cat'] ) ){
            $db->join("casino_games_has_cats hc", "g.id=hc.casino_games_id", "LEFT");
            $db->where("hc.casino_games_cats_id", $data['cat']);
        }

        if ( is_int( $data['prov'] ) ) {
            $db->where("g.casino_games_providers_id",$data['prov']);
        }

        $db->where("g.is_mobile",$data['is_mobile']);
        $resp['games'] = $db->get("casino_games g",$data['lim'],"g.*");

        if ( count( $resp['games'] ) == 0 ) {
            if ( is_int( $data['prov'] ) ) {
                $db->where("g.casino_games_providers_id",$data['prov']);
            }
            $db->where("g.is_mobile",$data['is_mobile']);
            $resp['games'] = $db->get("casino_games g",$data['lim'],"g.*");
        }


        // return cats by Provider
        if ( is_int( $data['prov'] ) ) {
            $db->join("casino_games_has_cats HC", "HC.casino_games_id = GS.id", "LEFT");
            $db->where("GS.casino_games_providers_id", $data['prov']);
            $db->orderBy("HC.casino_games_cats_id","asc");
            $cats = $db->get("casino_games GS",null,"DISTINCT(HC.casino_games_cats_id) AS cat_id");

            //$resp['cats_by_prov'] = array_column($cats, 'cat_id'); Is not working on server php version

            $resp['cats_by_prov'] = [];
            foreach ($cats as $key => $value) {
                $resp['cats_by_prov'][] = $value['cat_id'];
            }
        } else {
            $resp['cats_by_prov'] = null;
        }

    	return $resp;
    }

    public function get_game($external_id) {
    	global $db;

        $db->where("external_id",$external_id);
        $game = $db->getOne("casino_games",null,"*");

    	return $game;
    }


}
