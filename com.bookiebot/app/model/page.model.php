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


class Page_Model extends Model
{

    /**
    * Get List of pages by type
    * @param (int) $type
    * @return array
    */
    public function getmenulist($type) {
    	global $db;



        if(strpos($type, ",")>0) {
            $types_arr = explode(",",$type);

            foreach($types_arr as $cur_type) {
                $db->orWhere("type",(int)$cur_type);
            }
        } else {
            $type = (int)$type;
            $db->where("type",$type);
        }

//        $rslt = $db->rawQuery("ALTER TABLE website_pages ADD onclick VARCHAR(255)");
//        var_export($rslt);

        $db->where("parent_id",0);
        $db->where("status",1);
        $db->orderBy("priority","ASC");
        $data = $db->get("website_pages",null,"id,title,htaccess,controller,link,icon,parent_id,onclick");

        $length = count($data);
        for($i=0;$i<$length;$i++) {
            $data[$i]['title'] = $this->getUnserializedTitle($data[$i]['title']);
            $data[$i]['url'] = $this->getPageUrl($data[$i]);
            $data[$i]['children'] = $this->getChildren($data[$i]['id']);
        }

//        print_r($data);
    	return $data;
    }


    private function getChildren($page_id) {
        global $db;
        $page_id = (int)$page_id;
        $db->where("parent_id",$page_id);
        $db->where("status",1);
        $db->orderBy("priority","ASC");
        $data = $db->get("website_pages",null,"id,title,htaccess,controller,link,icon,parent_id,onclick");
        $length = count($data);
        for($i=0;$i<$length;$i++) {
            $data[$i]['title'] = $this->getUnserializedTitle($data[$i]['title']);
            $data[$i]['url'] = $this->getPageUrl($data[$i]);
        }
        return $data;
    }


    /**
     * @param $htaccess
     * @return array
     */
    public function get($htaccess) {
        global $db;
        global $lang;
        $page_id = $this->getIDByHtaccess($htaccess);
        $page_id = $page_id['id'];

        //Get Concrete page data from
        $db->where('id',$page_id);
        $page = $db->getOne("website_pages","id,title,parent_id,onclick");
        $page['title'] = json_decode($page['title'],true);
        $page['title'] = $page['title'][$lang];
        $page['cur_page_id'] = $page_id;
        return $page;
    }

    /**
    * Get page Id By Htaccess
    * @param (string) $htaccess
     * @return array
    **/
    private function getIDByHtaccess($htaccess) {
        global $db;
        $db->where("htaccess",$db->escape($htaccess));
        $data = $db->getOne("website_pages","id");
        return $data;
    }


    private function getPageUrl($page_item) {
        global $config;
        global $lang;

        $url = $config['base_href'];

        if(!empty($page_item['link'])) {
            if(strpos($page_item['link'], "{lang}")===false) {
                $url = $page_item['link'];
            } else {
                $url .= str_replace("{lang}", LANG, $page_item['link']);
            }
        } 


        else if(!empty($page_item['controller'])) {
                $url .= "/".LANG."/$page_item[controller]";
        } 


        else {
                $url .= "/".LANG."/page/show/$page_item[htaccess]";
        }
        
        if($page_item['htaccess'] == "index") {
            $url = $config['base_href']."/".LANG;
        }


        return $url;
    }


    private function getUnserializedTitle($serializedTitle) {
            global $lang;
            $titlearr = json_decode($serializedTitle,true);

            if(!isset($titlearr[LANG])) {
                $lang = "en";
            }
            return $titlearr[LANG];
    }


}