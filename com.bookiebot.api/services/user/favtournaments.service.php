<?php



class Favtournaments extends Service {


    public function addFavorite($tournament_id) {
        $tournament_id = (int)$tournament_id;
        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            $db = $this->db;
            $insert = $db->insert("core_users_has_betting_tournament_favorited",array(
                "core_users_id"=>$user_id,
                "betting_tournament_id"=>$tournament_id
            ));
            if($insert!==false) {
                return array("code"=>10);
            } else {

                return array("code"=>30);
            }
        } else {
            return array("code"=>40);
        }
    }


    public function removeFavorite($tournament_id) {
        $tournament_id = (int)$tournament_id;
        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            $db = $this->db;
            $db->where("core_users_id",$user_id);
            $db->where("betting_tournament_id",$tournament_id);
            $delete = $db->delete("core_users_has_betting_tournament_favorited");
            if($delete!==false) {
                return array("code"=>10);
            } else {
                return array("code"=>30);
            }
        } else {
            return array("code"=>40);
        }
    }



}