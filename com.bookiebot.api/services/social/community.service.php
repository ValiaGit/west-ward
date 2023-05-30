<?php

if(!defined('APP')) {
    die();
}


use WideImage\WideImage;

class Community extends Service
{
    private $db;



    public function getAllCommunities($keyword=false) {

        $db = $this->db;
        global $config;

        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            $data = $db->rawQuery("SELECT
                                  IF(community.title='',competitors.title,community.title) as title,
                                  IF(community.title='',1,0) as is_title_competitor,
                                  community.id as community_id,
                                  has_community.core_users_id is_in_community,
                                  community.logo_path
                      FROM
                      social_community community

                      LEFT JOIN
                      betting_competitors competitors
                      ON competitors.id = community.betting_competitors_id

                      LEFT JOIN core_users_has_social_community has_community
                      ON has_community.core_users_id = $user_id AND has_community.social_community_id = community.id


                      WHERE
                      community.status = 1 GROUP BY community.id ORDER BY title ASC");

            foreach($data as &$row) {
                if($row['is_title_competitor'] == 1) {
                    $row['title'] = $this->getUnserializedTitle($row['title']);
                }
                $row['original_logo'] = $config['base_href']."/uploads/social/communities/original/".$row['logo_path'];
                $row['logo_path'] = $config['base_href']."/uploads/social/communities/thumb/".$row['logo_path'];
            }

            if(count($data)) {
                return array("code"=>10,"data"=>$data);
            } else {
                return array("code"=>60);
            }
        } else {
            return array("code"=>20);
        }

    }


    /**
     * @param int $betting_competitors_id
     * @return array
     */
    public function createCommunity($community_title = "")
    {


        if(!isset($_FILES['logo_path']) || !isset($_FILES['cover_path']) || !isset($_FILES['background_path'])) {
            return array("code"=>50);
        }

        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            $db = $this->db;
            $community_title = $db->escape($community_title);

            $logo = $_FILES['logo_path'];
            $logo_type = $logo['type'];

            $cover = $_FILES['cover_path'];
            $cover_type = $cover['type'];

            $background = $_FILES['background_path'];
            $background_type = $background['type'];


            if($logo['error']!==0 || $background['error']!==0 || $cover['error']!==0) {
                return array("code"=>50);
            }


            if(IFn::CheckImageType($logo_type) || IFn::CheckImageType($cover_type) || IFn::CheckImageType($background_type)) {


                $logo_tmp_file = $logo['tmp_name'];
                $exploded = explode(".",$logo['name']);
                $extension = end($exploded);
                $file_name = md5(time())."."."jpg";

                $original_folder = UPLOADS_DIR."social/communities/original/";
                $thumb_folder = UPLOADS_DIR."social/communities/thumb/";

                if(move_uploaded_file($logo_tmp_file,$original_folder.$file_name)) {
                    WideImage::load($original_folder.$file_name)->resize(140,140)->saveToFile($thumb_folder.$file_name);

                    $data = array(
                        "creator_user_id" => $user_id,
                        "title"=>$community_title,
                        "logo_path"=>$file_name,
                        "cover_path"=>$file_name

                    );


                    $insert_id = $db->insert("social_community", $data);
                    if ($insert_id !== false) {
                        return array("code" => 10);
                    } else {
                        echo $db->getLastError();
                        return array("code" => 70);
                    }

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
            return array("code"=>20);
        }


    }


    /**
     * Gets community_id as parameter and get public data of that community
     * @param int $community_id
     * @param int $competitor_id
     * @return array
     */
    public function getCommunity($community_id = 0, $competitor_id = 0)
    {

        if (!$community_id && $community_id != -1) {
            $community_id = (int)$_POST['community_id'];
        }
        global $config;
        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            $db = $this->db;


            /**
             * Gets Community By TeamID or By CommunityID
             */
            if ($competitor_id) {
                $clause = "community.betting_competitors_id = $competitor_id";
            } else {
                $clause = "community.id = $community_id";
            }


            $data = $db->rawQuery("
                                    SELECT
                                        community.id,
                                        community.logo_path,
                                        community.cover_path,
                                        community.betting_competitors_id as competitor_id,
                                        IF(community.title='',competitors.title,community.title) as title,
                                        IF(community.title='',1,0) as is_title_competitor
                                    FROM
                                        social_community community
                                        LEFT JOIN
                                        betting_competitors competitors
                                        ON
                                        community.betting_competitors_id = competitors.id
                                    WHERE
                                        $clause
                                 ");


            if (!count($data)) {
                return array("code" => 209);
            }
            $data = $data[0];
            $community_id = $data['id'];

            //Get Users In Community
            $data['users'] = $this->getUsersFromCommunity($community_id);
            $data['logo_path'] = $config['base_href']."/uploads/social/communities/thumb/".$data['logo_path'];
            //Unserialise Sport And Community Title

            if($data['is_title_competitor'] == 1) {
                $data['title'] = $this->getUnserializedTitle($data['title']);
            }


            $user_id_community = $this->isUserInCommunity($user_id, $community_id);

            //If User Is In Community He Has More Privileges So Query Is Different
            if ($user_id_community['code'] == 10) {

                if($data['competitor_id']) {
                    //Get Upcoming Matches For Community
                    $matches_service = $this->loadService("betting/matches");
                    $data['upcoming_matches_for_community'] = $matches_service->getUpcomingMatchesByTeamID($data['competitor_id'], 150);


                    //Get bets made against community competitor
                    $bets_service = $this->loadService("betting/bets");
                    $team_bets = $bets_service->getBetsStreamByTeamId($data['competitor_id']);
                    if ($team_bets) {
                        $data['team_bets'] = $team_bets;//Get Bets Data For Related Team ID
                    } else {
                        $data['team_bets'] = array();
                    }

                }



                //Get posts made in community
                $posts_service = $this->loadService("social/posts");
                $feed = $posts_service->getPostsByCommunity($community_id);
                if ($feed['code'] == 10) {
                    $data['feed'] = $feed['data'];//Gets Posts Posted In Community
                } else {
                    $data['feed'] = array();
                }





                $data['is_user_in_community'] = true;
            } else {

                $data['is_user_in_community'] = false;
            }


            return $data;
        } else {
            return array("code" => 40);
        }
    }


    /**
     * @param int $team_id
     * @return array
     */
    public function getCommunityByTeamId($team_id = 0)
    {
        if (!$team_id) {
            $team_id = (int)$_POST['team_id'];
        }

        if (!$team_id) {
            return array("code" => 50);
        }

        return $this->getCommunity(-1, $team_id);
    }


    /**
     * Get Users From Community
     * @param int $community_id
     * @param int $limit
     * @return array
     */
    public function getUsersFromCommunity($community_id = 0, $limit = 10)
    {

        if (!$community_id) {
            $community_id = (int)$_POST['community_id'];
        }

        if (isset($_POST['limit'])) {
            $limit = (int)$_POST['limit'];
        }

        $db = $this->db;

        if ($limit != -1) {
            $lim = " LIMIT $limit";
        }

        $data = $db->rawQuery("
                                SELECT
                                    users.id,
                                    CONCAT(users.first_name,' ',users.last_name) as fullname
                                FROM
                                    core_users_has_social_community community_user,
                                    core_users users
                                WHERE
                                    community_user.social_community_id = ?
                                    AND
                                    users.id = community_user.core_users_id
                                GROUP BY
                                    users.id
                                $lim
                                ", array($community_id));

        //Get Thumbnail Image On Every User
        $user_settings_service = $this->loadService("user/settings");
        foreach ($data as &$user) {
            $user['thumb'] = $user_settings_service->getUserImage($user['id'], "thumb");
        }
        return $data;
    }


    /**
     * When User Is Authenticated Can Join Some Communities
     * @param int $community_id
     * @return array
     */
    public function joinCommunity($community_id = 0)
    {

        if (!$community_id) {
            $community_id = (int)$_POST['community_id'];
        }

        //Check If Client Sent "community_id"
        if (!$community_id) {
            return array("code" => 50);
        }


        //Check If Community Exists
        $exists = $this->communityExists($community_id);
        if (!$exists) {
            return array("code" => 20, "errCode" => 206);
        }

        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            $db = $this->db;

            $data = array(
                "core_users_id" => $user_id,
                "social_community_id" => $community_id
            );

            $insert_id = $db->insert("core_users_has_social_community", $data);


            if ($insert_id !== false) {
                return array("code" => 10);
            } else {
                return array("code" => 70);
            }

        } else {
            return array("code" => 40);
        }
    }


    /**
     * If User Want To Leave Community
     * @param int $community_id
     * @return array
     */
    public function removeSelfFromCommunity($community_id = 0)
    {
        if (!$community_id) {
            $community_id = (int)$_POST['community_id'];
        }

        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            $db = $this->db;
            $db->where("core_users_id", $user_id);
            $db->where("social_community_id", $community_id);
            $delete = $db->delete("core_users_has_social_community");
            if ($delete) {
                return array("code" => 10);
            } else {
                return array("code" => 30);
            }
        } else {
            return array("code" => 40);
        }


    }


    /**
     * Returns list of communities in which user is separated
     * @return array
     */
    public function getMyCommunitiesList()
    {
        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            $db = $this->db;

            $data = $db->rawQuery("
                                    SELECT
                                        social_community.id,
                                        IF(social_community.title='',betting_competitors.title,social_community.title) as title,
                                        IF(social_community.title='',1,0) as is_title_competitor
                                    FROM
                                        core_users_has_social_community

                                        INNER JOIN
                                        social_community
                                        ON
                                        social_community.id = core_users_has_social_community.social_community_id

                                        LEFT JOIN
                                        betting_competitors
                                        ON
                                        betting_competitors.id = social_community.betting_competitors_id




                                        WHERE
                                        core_users_has_social_community.core_users_id = ?
                                      ORDER BY title ASC
                                    ", array($user_id));

            foreach($data as &$row) {
                if($row['is_title_competitor'] == 1) {
                    $row['title'] = $this->getUnserializedTitle($row['title']);
                }
                $row['user_num'] = $this->getUsersCountByCommunity($row['id']);
            }


            return $data;

        } else {
            return array("code" => 40);
        }
    }


    /**
     * @param int $community_id
     * @return int]
     */
    private function getUsersCountByCommunity($community_id = 0)
    {
        $db = $this->db;

        $data = $db->rawQuery("
                                SELECT
                                  COUNT(1) as cnt
                                FROM
                                  core_users_has_social_community
                                WHERE
                                  core_users_has_social_community.social_community_id = ?
                              ", array($community_id));
        $data = $data[0];

        if(isset($data['cnt'])) {
            return $data['cnt'];
        }
        else {
            return 0;
        }

    }


    /**
     * Check If User Is In Community
     * @param int $user_id
     * @param int $community_id
     * @return array
     */
    public function isUserInCommunity($user_id = 0, $community_id = 0)
    {

        if (!$user_id && !$community_id) {
            $user_id = $_POST['user_id'];
            $community_id = $_POST['community_id'];
        }


        $db = $this->db;
        $user_id = (int)$db->escape($user_id);
        $community_id = (int)$db->escape($community_id);

        $db->where('core_users_id', $user_id);
        $db->where('social_community_id', $community_id);
        $row = $db->getOne("core_users_has_social_community", "1");

        if ($row) {
            return array("code" => 10);
        } else {
            return array("code" => 20);
        }

    }


    /**
     * Check If Provided Community Exists
     * @param $community_id
     * @return array
     */
    public function communityExists($community_id)
    {
        if (!$community_id) {
            return false;
        }
        $db = $this->db;
        $db->where("id", (int)$community_id);
        $get = $db->getOne("social_community", "1");
        return $get;
    }


    /**
     * Send term to this method and it will search every community with provided term
     * @param string $term
     * @return array
     */
    public function searchCommunity($term = "")
    {
        if ($term == "") {
            $term = $_POST['term'];
        }

        //Term can't be empty or shorter than 4 chars
        if (empty($term) || strlen($term) < 4) {
            return array("code" => 50);
        }


        //Check If User Is Logged In
        $user_data = $this->checkUserAccess();
        if ($user_data) {
            $user_id = $user_data['id'];

            $db = $this->db;
            $keyword = "%" . $db->escape($term) . "%";
            $data = $db->rawQuery("
                                    SELECT

                                        community.id as community_id,
                                        competitors.id as competitor_id,
                                        competitors.title as competitor_title,

                                        sport.code,
                                        sport.title as sport_title

                                    FROM

                                        betting_competitors competitors,
                                        social_community community,
                                        betting_sport sport

                                    WHERE

                                        competitors.title LIKE ?
                                          AND
                                        community.betting_competitors_id = competitors.id
                                          AND
                                        sport.id = competitors.betting_sport_id

                                    ", array($keyword));
            foreach ($data as &$community) {
                $is_in_community = $this->isUserInCommunity($user_id, $community['community_id']);
                $community['isjoined'] = $is_in_community['code'] == 10 ? true : false;
                $community['competitor_title'] = $this->getUnserializedTitle($community['competitor_title']);
                $community['sport_title'] = $this->getUnserializedTitle($community['sport_title']);
            }
            return $data;
        } else {
            return array("code" => 20);
        }


    }


}