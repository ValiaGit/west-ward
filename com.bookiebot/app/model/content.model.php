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


class Content_Model extends Model
{

    /**
    *   @param (int) $page_id - the id of page which content we want
    **/
    public function getContent($page_id)
    {
    	global $langN;
    	global $db;



    	$page_id = (int)$page_id;
        $qs = "
                        SELECT
                            website_content.*
                        FROM
                            website_pages_has_website_content,
                            website_content
                        WHERE
                            website_pages_has_website_content.website_pages_id = $page_id
                            AND
                            website_content.id = website_pages_has_website_content.website_content_id
                        GROUP BY
                            website_content.id
                      ";


        $data = array();
        $instance = $db->getSQLIInstance();
        if($result = $instance->query($qs)) {
            while($row = mysqli_fetch_assoc($result)) {
                array_push($data,$row);
            }
        }


        if(count($data)) {
            return $data[0];
        } else {
            return false;
        }

    }




}