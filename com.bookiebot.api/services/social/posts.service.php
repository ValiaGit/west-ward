<?php


if(!defined('APP')) {
    die();
}


use WideImage\WideImage;
/**
 *	This Class Handles Friends Management
 *   Send Requests, Approval and Listing
 **/
class Posts extends Service {

    /**
     * @param int $page
     * @param int $per_page
     * @param int $post_id
     * @param int $community_id
     * @return array
     */
    public function getFriendsFeed($page = 1, $per_page = 30, $post_id = 0, $community_id = 0) {
        global $config;

        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            $db = $this->db;

            if(isset($_POST['page'])) {
                $page = (int) $_POST['page'];
            }
            if(isset($_POST['per_page'])) {
                $per_page = (int) $_POST['per_page'];
            }

            $clause = "";
            if($post_id) {
                $clause .= " AND post.id = $post_id ";
            }
            if($per_page != 1) {
                $community_id = (int)$community_id;
                $clause .= " AND post.social_community_id = $community_id ";
            }


            $qs = "

                                    SELECT

                                        post.id as post_id,
                                        post.core_users_id,
                                        post.content,
                                        post.post_date,
                                        post.image,
                                        post.type,
                                        IF(core_users.name_privacy = 1,CONCAT(core_users.first_name,' ' ,core_users.last_name),core_users.nickname ) as fullname,
                                        core_users.gender,
                                        core_users.first_name,
                                        core_users.last_name,
                                        COUNT(DISTINCT(likes.social_posts_id)) as likes_number,
                                        COUNT(DISTINCT(comments.social_posts_id)) as comments_number

                                    FROM
                                        core_users,
                                        social_posts post


                                    LEFT JOIN
                                        social_friendship f
                                    ON
                                        post.core_users_id = f.core_user_friend
                                        AND
                                        f.status = 1



                                    LEFT JOIN
                                        social_likes likes
                                    ON
                                        post.id = likes.social_posts_id


                                    LEFT JOIN
                                        social_comments comments
                                    ON
                                        post.id = comments.social_posts_id


                                    WHERE
                                        (
                                            f.core_user_id = $user_id
                                              OR
                                            post.core_users_id = $user_id
                                        )
                                        AND
                                        core_users.id = post.core_users_id
                                    $clause
                                    GROUP BY
                                      post.id

                                    ORDER BY
                                      post.post_date
                                    DESC

                                  ";

            $data = $db->rawQuery($qs);

            if(count($data)) {

                $comments_service = $this->loadService("social/comments");
                //For Every Post Get Related Comments
                foreach($data as $index=>$odd) {
                    $user_id = $data[$index]['core_users_id'];
                    $filename = sha1($user_id."thumb");

                    $setting_service = $this->loadService("user/settings");


                    //Get User AVatars
                    $avatar = $setting_service->getUserImage($user_id,"thumb",$data[$index]['gender']);
                    $big_avatar = $setting_service->getUserImage($user_id,"original",$data[$index]['gender']);

                    $data[$index]['avatar'] = $avatar;
                    $data[$index]['big_avatar'] = $big_avatar;

                    //Get Post Image
                    $data[$index]['image_original'] = $config['base_href']."/uploads/social/posts/original/".$data[$index]['image'];
                    $data[$index]['image_thumb'] = $config['base_href']."/uploads/social/posts/thumb/".$data[$index]['image'];


                    $data[$index]['comments'] = $comments_service->getCommentsByPostId($data[$index]['post_id']);
                }


                return array("code"=>10,"data"=>$data,"server"=>APP_ID);
            }
            else {
                return array("code"=>60);
            }
        }

        else {
            return array("code"=>40);
        }
    }


    /**
     * Get Feed Inside A Community
     * @param int $community_id
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function getPostsByCommunity($community_id = 0,$page = 1,$limit = 10) {
        return $this->getFriendsFeed($page,30,0,$community_id);
    }



    /**
     * Gets All Posts Posted By Specified User Id Which is Friend of current user
     * @param int $friend_id
     * @return array
     */
    public function getPostsByFriendId($friend_id = 0) {

        if($friend_id == 0) {
            $friend_id = (int) $_POST['friend_id'];
        }

        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            $db = $this->db;

        }
        else {
            return array("code"=>40);
        }


    }



    /**
     *	Post Feed Node
     **/
    public function addPost($content = 0,$image = 0,$community_id = 0) {

        if(!$content && !$image) {
            $content = $_POST['content'];
            $image = "";
        }


        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            $db = $this->db;



            if($community_id) {
                $communities = $this->loadService("social/community")->isUserInCommunity($user_id,$community_id);
                if($communities['code']!=10) {
                    return array("code"=>50);
                }
            }

            $content = $db->escape($content);

            if(empty($content) && !$image) {
                return array("code"=>50);
            }


            $type = 1;
            if($image) {
                $type = 2;
            }

            $data = array(
                "core_users_id"=>$user_id,
                "content"=>$content,
                "image"=>$image,
                "type"=>$type,
                "social_community_id"=>$community_id
            );

            $inserted_feed_id = $db->insert("social_posts",$data);
            if($inserted_feed_id) {
                return array("code"=>10,"data"=>array("posted_id"=>$inserted_feed_id,"content"=>$content,"image"=>$image));
            } else {
                return array("code"=>30);
            }

        }

        else {
            return array("code"=>40);
        }
    }


    /**
     * @param int $content
     * @param int $community_id
     * @return array
     *
     */
    public function addImagePost($content = 0, $community_id=0) {
        global $config;
        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];


            $db = $this->db;

            $image = $_FILES['image'];
            $content = $db->escape($_POST['content']);
            $community_id = (int) $db->escape(@$_POST['community_id']);
//            if(!$content) {
//                return array("code"=>50);
//            }
            $type = $image['type'];

            if($image['error']!==0) {
                return array("code"=>50);
            }

            if(IFn::CheckImageType($type)) {


                $tmp_file = $image['tmp_name'];
                $exploded = explode(".",$image['name']);
                $extension = end($exploded);

                $file_name = md5(time()).".".$extension;

                $original_folder = UPLOADS_DIR."social/posts/original/";
                $thumb_folder = UPLOADS_DIR."social/posts/thumb/";


                //If We Uploaded Original
                if(move_uploaded_file($tmp_file,$original_folder.$file_name)) {
                    WideImage::load($original_folder.$file_name)->resize(403)->saveToFile($thumb_folder.$file_name);
                    return $this->addPost($content,$file_name,$community_id);
                }
                else {
                    return array("code"=>104);
                }

            }
            else {
                return array("code"=>103);
            }


        }


        else {
            return array("code"=>40);
        }
    }



    /**
     * Checks if user can delete post and after that deletes all data to that post
     * @param int $post_id
     * @return array
     */
    public function deletePost($post_id = 0) {
        if(!$post_id) {
            $post_id = (int) $_POST['post_id'];
        }
        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            $db = $this->db;

            //Check If Post Belongs To Current User
            if($this->postBelongsToUser($user_id,$post_id)) {


                $this->deletePostImage($post_id);

                //Delete From Community
                $db->where("social_posts_id",$post_id);
                $db->delete("social_community_has_social_posts");


                //Delete Comments
                $db->where("social_posts_id",$post_id);
                $db->delete("social_comments");

                //Delete Likes
                $db->where("social_posts_id",$post_id);
                $db->delete("social_likes");




                //Delete Message
                $db->where("id",$post_id);
                $db->where("core_users_id",$user_id);
                $del = $db->delete("social_posts");
                if($del !== false) {
                    return array("code"=>10);
                } else {
                    return array("code"=>30);
                }
            } else {
                return array("code"=>20,"errCode"=>208);
            }


        }
        else {
            return array("code"=>40);
        }
    }



    /**
     * Delete Related Image For Post
     * @param $post_id
     * @return array
     */
    private function deletePostImage($post_id) {
        $post_id = (int)$post_id;
        $db = $this->db;
        $db->where("id",$post_id);
        $image = $db->getOne("social_posts","image");
        $image = $image['image'];
        if(!strlen($image)) {
            // return false;
        }
        $path = ROOT_DIR."/".$image;

        if(file_exists($path)) {
            unlink($path);
        }
    }


    /**
     *	Post Feed In Community Provide Community Id
     *  And post will be added in community
     **/
    public function addPostInCommunity($community_id = 0,$content = 0) {

        $db = $this->db;

        //If Invoked From Client Service
        if(!$community_id && !$content) {
            $community_id = (int) $_POST['community_id'];
            $content = $db->escape($_POST['content']);
        }

        //Wrong Request
        if($community_id == 0 || empty($content)) {
            return array("code"=>50);
        }


        //Chek User Has Access
        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            $community_service = $this->loadService("social/community");
            $communityExists = $community_service->communityExists($community_id);
            $isUserInCommunity = $community_service->isUserInCommunity($user_id,$community_id);

            if($communityExists && $isUserInCommunity['code'] == 10) {

                $data = array(
                    "core_users_id"=>$user_id,
                    "content"=>$content,
                    "is_community"=>1
                );

                $insert_post_id = $db->insert("social_posts",$data);
                if($insert_post_id) {
                    $insert_post_in_community = $db->insert("social_community_has_social_posts",
                        array(
                            "social_posts_id"=>$insert_post_id,
                            "social_community_id"=>$community_id
                        )
                    );
                    if($insert_post_in_community!==false) {
                        return array("code"=>10);
                    } else {
                        echo $db->getLastError();
                        return array("code"=>30);
                    }
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
     * When user likes post the post has to be refreshed so this
     * method will be called to get live data for that post
     * @param int $post_id
     * @return array
     */
    public function refreshPostDetails($post_id = 0) {
        if(!$post_id) {
            $post_id = (int) $_POST['post_id'];
        }

        $db = $this->db;

        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            return $this->getFriendsFeed(1,1,$post_id);
        }

        else {
            return array("code"=>40);
        }

    }


    /**
     * Like Some Posts
     */
    public function like() {

        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            $db = $this->db;
            $post_id = (int) $_POST['post_id'];

            $post_exists = $this->postExists($post_id);

            //Check If Post To Like Exists
            if($post_exists) {

                //Check If User Hasnt Already Liked
                $hasLiked = $this->hasLiked($post_id,$user_id);
                //If Hasnt Liked Like
                if(!$hasLiked) {

                    $data = array(
                        "social_posts_id"=>$post_id,
                        "core_users_id"=>$user_id,
                    );

                    $like_id = $db->insert("social_likes",$data);
                    if($like_id!==false) {
                        return array("code"=>10);
                    } else {
                        return array("code"=>30);
                    }
                }
                //If Liked Than Remove Like
                else {
                    $db->where("social_posts_id",$post_id);
                    $db->where("core_users_id",$user_id);
                    $del = $db->delete("social_likes");
                    if($del) {
                        return array("code"=>10);
                    } else {
                        return array("code"=>30);
                    }
                }

            }

            else {
                return array("code"=>207);
            }


        } else {
            return array("code"=>40);
        }
    }




    /**
     * Check if provided post exists in database
     * @param $post_id
     * @return array
     */
    private function postExists($post_id) {
        $db = $this->db;
        $post_id = (int) $post_id;
        $db->where("id",$post_id);
        $data = $db->getOne("social_posts","1");
        return $data;
    }

    /**
     * Check If User Has Already Liked Post
     * @param $post_id
     * @param $user_id
     * @return array
     */
    private function hasLiked($post_id,$user_id) {
        $db = $this->db;

        $post_id = (int) $post_id;
        $user_id = (int) $user_id;

        $db->where("social_posts_id",$post_id);
        $db->where("core_users_id",$user_id);
        $exists = $db->getOne("social_likes","1");
        return $exists;
    }





    /**
     * Check If Post Belongs To Provided User
     * @param $user_id
     * @param $post_id
     * @return array
     */
    private function postBelongsToUser($user_id,$post_id) {
        $user_id = (int) $user_id;
        $post_id = (int) $post_id;
        $db = $this->db;
        $db->where("id",$post_id);
        $db->where("core_users_id",$user_id);

        return $db->getOne("social_posts","1");
    }




}



?>