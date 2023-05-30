<?php

if(!defined("APP")) {
	die("No Direct Access!");
}


use Hashids\Hashids;

class IFn {

    /**
     * @param $user_id
     * @return string
     */
    public static function encodeUserIdToAffiliateID($user_id) {
        global $config;
        $hashids = new Hashids($config['affiliates_hash_id_sault'],6,'abcdefghijkmnpqrstuvwxyz23456789');
        return $hashids->encode($user_id);
    }

    /**
     * @param $affiliate_id
     * @return array
     */
    public static function decodeAffiliateIdToUserId($affiliate_id) {
        global $config;
        $hashids = new Hashids($config['affiliates_hash_id_sault'],6,'abcdefghijkmnpqrstuvwxyz23456789');
        if(!count($affiliate_id));
		//  return false;
        return $hashids->decode($affiliate_id)[0];
    }


	

	
	public static function deleteDir($dirPath) {
	    if (! is_dir($dirPath)) {
	        throw new InvalidArgumentException("$dirPath must be a directory");
	    }
	    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
	        $dirPath .= '/';
	    }
	    $files = glob($dirPath . '*', GLOB_MARK);
	    foreach ($files as $file) {
	        if (is_dir($file)) {
	            self::deleteDir($file);
	        } else {
	            unlink($file);
	        }
	    }
	    rmdir($dirPath);
	}
	
	/**
	 * Detects OS Of Client And Returns Value
	 * @param
	 * @return string OS
	 */
	public static function Detect() {
			$user_agent = $_SERVER['HTTP_USER_AGENT'];
			$os_platform = "WAP";
			
			/**
			 * Iphone
			 */
			if (preg_match('/iphone/i', $user_agent) || preg_match('/ipod/i', $user_agent)) {
				$os_platform = "iPhone";
			} 
			
			/**
			 * Android
			 */
			else if (preg_match('/android/i', $user_agent)) {
				$os_platform = "Android";
			} 
			
			/**
			 * Blackberry
			 */
			else if (preg_match('/blackberry/i', $user_agent)) {
				$os_platform = "BlackBerry";
			}
			
			/**
			 * Ipad
			 */
			else if (preg_match('/ipad/i', $user_agent)) {
				$os_platform = "iPad";
			}
			
			
			/**
			 * PDA
			 */
			else if (preg_match('/webos/i', $user_agent) || preg_match('/SymbianOS/i', $user_agent) || preg_match('/Windows Phone OS/i', $user_agent) || preg_match('/Windows CE/i', $user_agent) || preg_match('/MeeGo/i', $user_agent) || preg_match('/bada/i', $user_agent) || preg_match('/Opera Mobi/i', $user_agent)) {
				$os_platform = "PDA";
			}
			
			
			/**
			 * pc
			 */
			else if (preg_match('/windows nt 6.2/i', $user_agent) || preg_match('/windows nt 6.1/i', $user_agent) || preg_match('/windows nt 6.0/i', $user_agent) || preg_match('/windows nt 5.2/i', $user_agent) || preg_match('/windows nt 5.1/i', $user_agent) || preg_match('/windows xp/i', $user_agent) || preg_match('/windows nt 5.0/i', $user_agent) || preg_match('/macintosh|mac os x/i', $user_agent) || preg_match('/mac_powerpc/i', $user_agent) || preg_match('/linux/i', $user_agent)) {
				$os_platform = "PC";
			}
			
			return $os_platform;
	}


	/**
	 * @param $link
	 * @return boolean
	 */
	public static function ParseYoutube($link) {
		$query = parse_url($link, PHP_URL_QUERY);
		$vars = array();
		parse_str($query, $vars);
		if(isset($vars['v']) && $vars['v'] != "") {
			return $vars['v'];
		} else {
			return false;
		}
	}
	
	
	
	/**
	 * Check Upload File Type
	 */
	public static function CheckImageType($file_type) {
		switch ($file_type) {
			case 'image/jpeg':
            case 'image/png':
            case 'image/gif':
				return true;
				// break;
			default:
				return false;
				// break;
		}
	}



	/**
	 * Dump Var
	 */
	public static function d($var) {
		echo "<pre>";
			print_r($var);
		echo "</pre>";
	}


    /**
     * Check if Current Page is "Active"
     * @param $url
     *
     * @return bool
     */
    public static function isActive( $url ) {
        $absolute_url = "http" . (isset($_SERVER['HTTPS']) ? 's' : '') . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
        //return strpos($absolute_url, $url) !== false;
        return $absolute_url == $url;
    }

}

