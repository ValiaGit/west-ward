<?php


if (!defined('APP')) {
    die();
}


/**
 *    This Class Handles Friends Management
 *   Send Requests, Approval and Listing
 **/
class Friends extends Service
{

    /**
     * Search For People in core_users
     * @param string $term
     * @return array
     */
    public function searchPeople($term = "")
    {
        if ($term == "") {
            $term = $_POST['term'];
        }
        //Check If User Is Logged In
        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            $db = $this->db;
            $keyword = "%" . $db->escape($term) . "%";
            $data = $db->rawQuery("
                                  SELECT
                                      id,
                                      CONCAT(core_users.first_name,' ',core_users.last_name) as fullname,
                                      gender
                                  FROM
                                    core_users
                                  WHERE
                                    first_name
                                  LIKE ? OR last_name LIKE ?", array($keyword, $keyword));
            if (count($data)) {
                foreach ($data as &$node) {
                    $node['avatar'] = $this->loadService("user/settings")->getUserImage($node['id'], "thumb", $node['gender']);
                    $friendship = $this->checkFriendShip($node['id']);
                    $node['is_friend'] = false;
                    if ($friendship['code'] == 10) {
                        $node['is_friend'] = true;
                    }

                }
                return array("code" => 10, "data" => $data);
            } else {
                return array("code" => 60);
            }

        } else {
            return array("code" => 20);
        }

    }


    /**
     * Get Friend Data How many bets made, what bets he/she won, what bets lost
     * @param int $friend_id
     * @return array
     */
    public function getFriend($friend_id = 0)
    {


        if ($friend_id == 0) {
            $friend_id = (int)$_POST['friend_id'];
        }

        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            $db = $this->db;

            //Check If Both Users Are Friends
            if (!$this->checkFriendShip($friend_id)) {
                return array("code" => 70);
            }

            $data = $db->rawQuery("
                                    SELECT
                                        COUNT(bets.id) as total_bets,
                                        CONCAT(users.first_name,' ',users.last_name) as fullname
                                    FROM
                                        core_users users
                                    LEFT JOIN
                                        betting_bets bets
                                    ON
                                        bets.core_users_id = users.id

                                    WHERE
                                        users.id = $friend_id
                                 ");
            return $data;

        } else {
            return array("code" => 40);
        }
    }


    /**
     * Get Term from $_POST or as parameter and returns array of friends which contain term in their full name
     * @param string $term
     * @return array
     */
    public function searchFriends($term = "")
    {
        //Check If User Is Logged In
        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            $db = $this->db;
            if ($term == "") {
                $term = $_POST['term'];
            }
            $keyword = "%" . $db->escape($term) . "%";

            $data = $db->rawQuery("
                                    SELECT
                                           core_users.id,
                                           CONCAT(core_users.first_name,' ' ,core_users.last_name) as fullname,
                                           core_users.first_name,
                                           core_users.last_name,
                                           core_users.gender
                                    FROM
                                           core_users,
                                           social_friendship
                                    WHERE
                                           (core_users.first_name LIKE ? OR core_users.last_name LIKE ?)
                                           AND
                                           core_users.id = social_friendship.core_user_friend
                                           AND
                                           social_friendship.core_user_id = ?
                                           AND
                                           social_friendship.status = ?
                                    ",
                array(
                    $keyword,
                    $keyword,
                    $user_id,
                    1
                ));
            if (count($data)) {

                foreach ($data as &$node) {
                    $node['avatar'] = $this->loadService("user/settings")->getUserImage($node['id'], "thumb", $node['gender']);
                }

                return array("code" => 10, "data" => $data);
            } else {
                return array("code" => 60);
            }
        } else {

            return array("code" => 20);
        }

    }


    /**
     * Get List Of Current User Friends
     **/
    public function getMyFriendsList()
    {
        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            $data = $this->db->rawQuery("
                                          SELECT
                                            core_users.id,
                                            core_users.first_name,
                                            core_users.last_name,
                                            CONCAT(core_users.first_name,' ' ,core_users.last_name) as fullname,
                                            core_users.gender
                                          FROM
                                            social_friendship,
                                            core_users
                                          WHERE
                                               social_friendship.core_user_id = ?
                                               AND
                                               social_friendship.core_user_friend = core_users.id
                                               AND
                                               social_friendship.status = 1
                                           GROUP BY
                                                core_users.id
                                          ", array($user_id));

            if (count($data)) {
                foreach ($data as &$node) {
                    $node['avatar'] = $this->loadService("user/settings")->getUserImage($node['id'], "thumb", $node['gender']);
                }

                return array("code" => 10, "data" => $data);

            } else {
                return array("code" => 60);
            }

        } else {
            return array("code" => 40);
        }
    }


    /**
     * Send Friend Request
     * Client Should send current logged in user_id and friend_id to which we send request
     **/
    public function sendFriendRequest($friend_id = false)
    {

        //Request should come friend_id to which we
        if (!$friend_id) {
            return array("code" => 50);
        }

        //Get Ids of sender and requester
        $receiver_user_id = (int)$friend_id;
        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $sender_user_id = $user_data['id'];

            $db = $this->db;
            if ($receiver_user_id == $sender_user_id) {
                return array("code" => 20, "errCode" => 204);
            }


            //Check If Receiver User Exists
            $db->where("core_user_id", $sender_user_id);
            $db->where("core_user_friend", $receiver_user_id);
            $request_exists = $db->getOne("social_friendship", "1");
            if (!$request_exists) {
                $db->where("id", (int)$receiver_user_id);
                if ($db->getOne("core_users", "1")) {

                    //Insert Sender
                    $insert1 = $db->insert("social_friendship", array("core_user_id" => $sender_user_id, "core_user_friend" => $receiver_user_id, "status" => 0, "receiver_id" => $receiver_user_id));
                    //Insert Receiver
                    $insert2 = $db->insert("social_friendship", array("core_user_id" => $receiver_user_id, "core_user_friend" => $sender_user_id, "status" => 0, "receiver_id" => $receiver_user_id));
                    if ($insert1 && $insert2) {
                        return array("code" => 10);
                    } else {
                        return array("code" => 30);
                    }

                } else {
                    return array("code" => 20, "errCode" => 202);
                }
            } else {
                return array("code" => 20, "msg" => $this->lang['friened_request_already_sent']);
            }


        } //If User Isn't Authorized
        else {
            return array("code" => 20, "errCode" => 40);
        }
    }


    /**
     *    Approve Friend Request Which Someone Send To Current User
     *   Parameters request_id and user_id (POST)
     **/
    public function approveReceivedRequest($request_id = 0)
    {


        if(!$request_id) {
            $request_id = (int)$_POST['request_id'];
        }

        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];


            $db = $this->db;
            $data = $db->rawQuery("SELECT core_user_id,core_user_friend FROM social_friendship WHERE receiver_id=? AND status=0 AND core_user_id=? AND id=?", array($user_id, $user_id, $request_id));
            if ($data) {

                $update = $db->rawQuery("UPDATE social_friendship SET status=1 WHERE core_user_id=? OR core_user_friend=?", array($user_id, $user_id));

                if ($update !== false) {
                    return array("code" => 10);
                } else {
                    return array("code" => 30);
                }

            } else {
                return array("code" => 20, "errCode" => 205);
            }
        } //User Wast Authorized
        else {
            return array("code" => 20, "errCode" => 40);
        }
    }


    /**
     * If someone sent friend request but i don't approve i remove
     * @param int $request_id
     * @return array
     */
    public function removeReceivedRequest($request_id = 0)
    {

        if (!$request_id) {
            $request_id = (int)$_POST['request_id'];
        }

        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            //User Can Delete Request If He Is Receiver Only
            $checkIsReceiverOfRequest = $this->checkIsReceiverOfRequest($user_id, $request_id);
            if ($checkIsReceiverOfRequest) {
                $db = $this->db;
                $sender_id = $checkIsReceiverOfRequest['sender_id'];


                $delete = $db->rawQuery("
                                            DELETE FROM
                                                social_friendship
                                            WHERE
                                                status = 0
                                                AND
                                                (
                                                    #delete where receiver
                                                    (
                                                        social_friendship.core_user_friend = ?
                                                        AND
                                                        social_friendship.core_user_id = ?
                                                    )
                                                    OR
                                                    #delete where sender
                                                    (
                                                        social_friendship.core_user_friend = ?
                                                        AND
                                                        social_friendship.core_user_id = ?
                                                    )
                                                )
                                                ", array($user_id, $sender_id, $sender_id, $user_id));
                if ($delete !== false) {
                    return array("code" => 10);
                } else {
                    return array("code" => 30);
                }
            } else {
                return array("code" => 70);
            }

        } else {
            return array("code" => 40);
        }


    }

    /**
     * User can delete friends
     * @param int $friend_id
     * @return array
     */
    public function deleteFriend($friend_id = 0)
    {

        if (!$friend_id) {
            $friend_id = (int)$_POST['friend_id'];
        }

        $friendship = $this->checkFriendShip($friend_id);

        //check if friendship exists
        if ($friendship['code'] == 10) {
            $user_id = $friendship['data']['user_id'];


            $db = $this->db;

            $delete = $db->rawQuery("
                                        DELETE FROM
                                            social_friendship
                                        WHERE
                                            (
                                              core_user_id = $user_id
                                                AND
                                              core_user_friend = $friend_id
                                            )
                                            OR
                                            (
                                              core_user_id = $friend_id
                                                AND
                                              core_user_friend = $user_id
                                            )
                                    ");
            if ($delete!==false) {
                return array("code" => 10);
            } else {
                return array("code" => 30);
            }
        } else {
            return array("code" => 70);
        }


    }


    /**
     *    Client side calls this service to get all
     * requests sent to current logged in user
     **/
    public function getReceivedRequests()
    {

        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $logged_user = $user_data['id'];

            $db = $this->db;

            $db->where("receiver_id", $logged_user);
            $db->where("status", 0);
            $db->where("seen", 0);
            $db->update("social_friendship", array("seen" => 1));

            $data = $db->rawQuery("
                                    SELECT
                                           friendship.id as request_id,
                                           friendship.send_date,
                                           users.first_name,
                                           users.last_name,
                                           IF(users.name_privacy = 1,CONCAT(users.first_name,' ' ,users.last_name),users.nickname ) as fullname,
                                           users.id as user_id,
                                           users.gender
                                    FROM
                                           core_users users,
                                           social_friendship friendship
                                    WHERE
                                           friendship.receiver_id = ?
                                           AND
                                           friendship.core_user_friend != ?
                                           AND
                                           users.id = friendship.core_user_friend
                                           AND
                                           friendship.status = 0
                                    GROUP BY
                                          friendship.id
                                    ",
                array($logged_user, $logged_user));

            $result_final = array();
            for ($i = 0; $i < count($data); $i++) {

                $data[$i]['avatar'] = $this->loadService("user/settings")->getUserImage($data[$i]['user_id'],"thumb",$data[$i]['gender']);
                if ($i % 2 == 0) $result_final[] = $data[$i];
            }


            return $result_final;
        }
    }

    /**
     * Gets Count Of Unseen Requests For Notifications Service
     * @param $user_id
     * @return array
     */
    public function getUnSeenRequestsCount($user_id)
    {
        $db = $this->db;
        $data = $db->rawQuery("SELECT (COUNT(id)/2) as cnt FROM social_friendship WHERE seen=0 AND receiver_id=$user_id AND status=0");
        return $data[0]['cnt'];
    }


    /**
     * When User Opens Requests Page I should check requests as seen
     * @return array
     */
    private function changeAllUnseenRequestsAsSeen()
    {
        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            $db = $this->db;
            $update = $db->rawQuery("
                                    UPDATE
                                      social_friendship
                                    SET
                                      seen = 1
                                    WHERE
                                        receiver_id=?
                                      AND
                                        seen = 0
                                      AND
                                        status != 1
                                ", array($user_id));
            var_export($update);
        } else {
            return array("code" => 40);
        }
    }


    /**
     * Check If id of provided user is friend for current logged in user
     * @param $friend_user_id
     * @return array
     */
    public function checkFriendShip($friend_user_id = 0,$status = 1)
    {
        if (!$friend_user_id) {
            $friend_user_id = (int)$_POST['friend_user_id'];
        }
        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            $db = $this->db;
            $data = $db->rawQuery("SELECT 1 FROM social_friendship WHERE core_user_id = $user_id AND core_user_friend = $friend_user_id AND status = $status");
            if (count($data)) {
                return array("code" => 10, "data" => array("user_id" => $user_id, "friend_id" => $friend_user_id));
            } else {
                return array("code" => 20);
            }

        } else {
            return array("code" => 40);
        }

    }


    /**
     * Check if user is receiver of certain request
     * @param $user_id
     * @param $request_id
     * @return bool
     */
    private function checkIsReceiverOfRequest($user_id, $request_id)
    {
        $user_id = (int)$user_id;
        $request_id = (int)$request_id;

        $db = $this->db;
        $db->where("id", $request_id);
//        $db->where("receiver_id", array("!=",$user_id));
        $db->where ("receiver_id", $user_id, '<=>');
        $db->where("status", 0);
        $is_receiver = $db->getOne("social_friendship", "core_user_id as sender_id");

        if ($is_receiver) {
            return $is_receiver;
        } else {
            return false;
        }
    }


}


?>