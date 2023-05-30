<?php



if (!defined("APP")) {
	die();
}


class Guard {
	
		public static function clean(&$data,$noSlashes = false) {
			
			if (is_array($data)) {
				foreach ($data as $key => $value) {
					$data[$key] = Guard::clean($value);

				}
			} else {
				$data = stripslashes(mysql_real_escape_string($data));
				
			}
			return $data;
		}

}



?>