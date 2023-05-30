<?php


if(!defined('APP')) {
    die();
}



class Stats extends Service {


    /**
     * Get Statistics Of Current Logged in User
     * @return array
     */
    public function getUserStats() {
        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            $likes_data = $this->getTotalLikesAndDislikesOnSelfPosts($user_id);
            $likes_received = $likes_data['total_likes'];


            $bets = $this->getTotalBetsNumber($user_id);

            return array(
                'total_likes'=>$likes_received,
                'bets'=>$bets
            );
        }
        else {
            return array("code"=>40);
        }
    }


    /**
     * Returns Total Number of Likes And Dislikes User Got On His/Her Posts
     * @param $user_id
     * @return array
     */
    private function getTotalLikesAndDislikesOnSelfPosts($user_id) {
        $db = $this->db;
        $data = $db->rawQuery("
                                SELECT
                                    count(likes.core_users_id) as total_likes
                                FROM
                                    social_likes likes,
                                    social_posts posts
                                WHERE
                                    posts.core_users_id = ?
                                    AND
                                    likes.social_posts_id = posts.id
                                GROUP BY
                                    likes.core_users_id
                             ",array($user_id));
        return $data[0];
    }


    /**
     * @param $user_id
     * @return array
     */
    private function getTotalBetsNumber($user_id) {
        $db = $this->db;
        $data = $db->rawQuery("
                                SELECT
                                   COUNT(*) as bets_number
                                FROM
                                  betting_bets
                                WHERE
                                  core_users_id = ?
                             ",array($user_id));
        return $data[0]['bets_number'];
    }












}

?>