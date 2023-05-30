<?php


if(!defined('APP')) {
    die();
}



/**
*	This Class Handles Friends Management 
*   Send Requests, Approval and Listing
**/
class Messaging extends Service {


    /**
     * Send Message To Friend, Checks if receiver is friend and send message
     * @param int $friend_id
     * @param int $message_content
     * @return array
     */
    public function sendMessage($friend_id = 0,$message_content = 0) {
        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            $db = $this->db;

            //If Not Provided Data Internally Provide From Service POST
            if(!$friend_id && !$message_content) {
                $friend_id = (int) $_POST['friend_id'];
                $message_content = $db->escape($_POST['content']);
            }

            if($message_content == '') {
                return array("code"=>50);
            }

            $friendship = $this->loadService("social/friends")->checkFriendShip($friend_id);
            if($friendship['code'] == 10) {

                $data = array(
                    "core_users_sender"=>$user_id,
                    "core_users_receiver"=>$friend_id,
                    "content"=>$message_content
                );

                $insert_id = $db->insert("social_messages",$data);
                if($insert_id) {
                    return array("code"=>10);
                } else {
                    return array("code"=>20);
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
     * Delete Message If belongs to logged in user
     * @param int $message_id
     * @return array
     */
    public function deleteMessage($message_id = 0) {
            if(!$message_id) {
                $message_id = (int) $_POST['message_id'];
            }

        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];


            $db = $this->db;
                    $db->where("id",$message_id);
                    $db->where("core_users_sender",$user_id);
                    $del = $db->delete("social_messages");
                    if($del) {
                        return array("code"=>10);
                    } else {
                        return array("code"=>70);
                    }

            }

            else {
                return array("code"=>40);
            }


	}


    /**
     * @param int $friend_id
     * @return array
     */
    public function deleteConversationWithFriend($friend_id = 0) {
        if(!$friend_id) {
            $friend_id = (int) $_POST['friend_id'];
        }

        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];


            $db = $this->db;

            $delete = $db->rawQuery("
                                      DELETE FROM
                                          social_messages
                                      WHERE
                                        (
                                          core_users_sender = $friend_id
                                            AND
                                          core_users_receiver = $user_id
                                        )
                                        OR
                                        (
                                          core_users_sender = $user_id
                                            AND
                                          core_users_receiver = $friend_id
                                        )
                                        ");
            if($delete!==false) {
                return array("code"=>10);
            } else {
                return array("code"=>20);
            }

        } else {
            return array("code"=>20);
        }


    }


    /**
     * Get The List Of Friends User Had Conversation With
     * @return array
     */
    public function getFriendsWithIHadConversation() {
        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];


            $db = $this->db;
            $data = $db->rawQuery("
                                    SELECT
                                        users.id as friend_id,
                                        CONCAT(users.first_name,' ',users.last_name) as fullname
                                    FROM
                                        social_messages messages,
                                        core_users users
                                    WHERE
                                          users.id = IF(
                                                messages.core_users_sender = $user_id,
                                                messages.core_users_receiver,
                                                messages.core_users_sender
                                          )
                                          AND
                                          (
                                              messages.core_users_sender = $user_id
                                                OR
                                              messages.core_users_receiver = $user_id
                                          )
                                    GROUP BY
                                      users.id
                                    ");

            //Iterate Over Friends I had conversation and set avatar
            foreach($data as &$friend_node) {
                $friend_node['avatar'] = $this->loadService("user/settings")->getUserImage($friend_node['friend_id'],"thumb");
            }
            return $data;

        }
        else {
            return array("code"=>40);
        }
	}


    /**
     * Gets Friend Id as parameter and returns feed of messaging with that friend
     * @param int $friend_id
     * @return array
     */
    public function getMessagesByFriend($friend_id = 0) {
        if(!$friend_id) {
            $friend_id = (int) $_POST['friend_id'];
        }

        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            $db = $this->db;

            $data = $db->rawQuery("
                                    SELECT
                                        messages.id,
                                        messages.send_date,
                                        messages.content,
                                        messages.status,
                                        core_users.id as sender_user_id,
                                        CONCAT(core_users.first_name,' ',core_users.last_name) as fullname
                                    FROM
                                        social_messages messages,
                                        core_users
                                    WHERE
                                        (
                                            #Messages where current user is sender and friend receiver
                                            (
                                                messages.core_users_sender = $user_id
                                                AND
                                                messages.core_users_receiver = $friend_id
                                            )
                                            OR
                                            #Messages where current user is receiver adn friend sender
                                            (
                                                messages.core_users_sender = $friend_id
                                                AND
                                                messages.core_users_receiver = $user_id
                                            )
                                        )
                                        AND
                                            core_users.id = messages.core_users_sender
                                        GROUP BY
                                            messages.id
                                            ORDER BY  messages.id ASC
                                        ");
            foreach($data as &$message) {
                $message['avatar'] = $this->loadService("user/settings")->getUserImage($message['sender_user_id'],"thumb");
            }
            return $data;
        }
        else {
            return array("code"=>40);
        }

	}


    /**
     * Check if message belongs to current logged in user
     * @param $user_id
     * @param int $message_id
     * @return bool
     */
    private function messageBelongsToUser($user_id,$message_id = 0) {
        if(!$message_id) {
            $message_id = (int) $_POST['message_id'];
        }

        $db = $this->db;
        $message_id = (int)$message_id;

        $db->where("id",$message_id);
        $db->where("core_users_sender",$user_id);
        return count($db->getOne("social_messages","1"));
    }


    /**
     * @param int $user_id
     * @return array
     */
    public function getUnseenMessagesCount($user_id = 0) {
        $user_id = (int)$user_id;
        if(!$user_id) {
            return  array("code"=>50);
        }

        $db = $this->db;
        $data = $db->rawQuery("SELECT COUNT(*) as msg_count FROM social_messages WHERE core_users_receiver=$user_id AND status=0");
        return $data[0]['msg_count'];
    }



}



?>