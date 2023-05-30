<?php


if(!defined('APP')) {
    die();
}

class Comments extends Service {

    /**
     * Add Comment To Certain Posts
     * @param int $post_id
     * @return array
     */
    public function addComment($post_id = false,$content = false) {

        if(!$post_id || !$content) {
            return array("code"=>20);
        }



        $post_id = (int)$post_id;
        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            $hasAccessToComment = $this->hasAccessToAddComment($post_id,$user_id);
            if($hasAccessToComment) {
                $db = $this->db;
                $content = $db->escape($content);

                $data = array (
                    "social_posts_id" => $post_id,
                    "core_users_id" => $user_id,
                    "content" => $content
                );
                $id = $db->insert('social_comments', $data);
                if($id) {
                    return array("code"=>10);
                }
                else {
                    return array("code"=>30);
                }
            }
            else {
                return array("code"=>70);
            }
        }

        else {
            return array("code"=>40);
        }

    }


    /**
     * Delete Comment User Added Or Post Belongs To User
     * @param int $comment_id
     * @return array
     */
    public function deleteComment($comment_id = 0) {

        if(!$comment_id) {
            $comment_id = (int) $_POST['comment_id'];
        }

        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            $hasAccessToDeleteComment = $this->hasAccessToDeleteComment($comment_id,$user_id);
            if($hasAccessToDeleteComment) {
                $db = $this->db;

                $db->where('id', $db->escape($comment_id));

                if($db->delete('social_comments')) {
                    return array("code"=>10);
                }

                else {
                    return array("code"=>30);
                }

            } else {
                return array("code"=>70);
            }
        }

        else {
            return array("code"=>40);
        }

    }


    /**
     * @param int $post_id
     * @param int $page
     * @param int $per_page
     * @return array
     */
    public function getCommentsByPostId($post_id = 0,$page = 1,$per_page = 10) {
            global $config;
            if(!$post_id) {
                $post_id = (int) $_POST['post_id'];
            }
        $post_id = (int)$post_id;

            if(isset($_POST['page'])) {
                $page = (int) $_POST['page'];
            }
        $page = (int)$page;
            if(isset($_POST['per_page'])) {
                $per_page = (int) $_POST['per_page'];
            }
        $per_page = (int)$per_page;


            $from_limit = ($page - 1) * $per_page;
            $to_limit = $from_limit+$per_page;



        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user = $user_data['id'];

                $db = $this->db;

                $data = $db->rawQuery("
                                        SELECT
                                            comments.id as comment_id,
                                            comments.core_users_id as user_id,
                                            comments.adddate,
                                            comments.content,
                                            IF(users.name_privacy = 1,CONCAT(users.first_name,' ' ,users.last_name),users.nickname ) as fullname
                                            
                                        FROM
                                            social_comments comments,
                                            core_users users
                                        WHERE
                                            comments.social_posts_id = ?
                                            AND
                                            users.id = comments.core_users_id
                                        ORDER BY
                                          comments.id
                                        ASC
                                        LIMIT $from_limit,$to_limit
                                        ",
                                        array(
                                            $post_id
                                        ));
                foreach($data as $index=>$comment) {
                    $user_id = $data[$index]['user_id'];
                    $filename = sha1($user_id."thumb");
                    $settings_service = $this->loadService("user/settings");

                    $data[$index]['avatar'] = $settings_service->getUserImage($user_id,"thumb");
                }
                return $data;
            }

            else {
                return array("code"=>40);
            }

    }



    /**
     * Return Boolean true If User Has Access to delete comment
     * @param $comment_id
     * @param $user_id
     * @return bool
     */
    private function hasAccessToDeleteComment($comment_id,$user_id) {
        $comment_id = (int) $comment_id;
        $user_id = (int) $user_id;

        $db = $this->db;
        $data = $db->rawQuery("SELECT 1 FROM social_comments comments WHERE comments.core_users_id = ? AND comments.id=?",array($user_id,$comment_id));
        return count($data);
    }


    /**
     * Check If User Can Post Comment On Provided Posts
     * Can post on self or friends posts
     * @param $post_id
     * @param $user_id
     * @return bool
     */
    private function hasAccessToAddComment($post_id,$user_id) {

        $post_id = (int) $post_id;
        $user_id = (int) $user_id;

        $db = $this->db;
        $data = $db->rawQuery("
                                SELECT
                                    1
                                FROM
                                  social_posts posts
                                WHERE
                                  posts.id = ?
                                  AND
                                  (
                                        posts.core_users_id IN (
                                            select
                                                core_user_friend
                                            from
                                                social_friendship
                                            where
                                                core_user_id = ?
                                        )
                                        OR
                                        posts.core_users_id = ?
                                  )
        ",array($post_id,$user_id,$user_id));

        return count($data);
    }


}




?>