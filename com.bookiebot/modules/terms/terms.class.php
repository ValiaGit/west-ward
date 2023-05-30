<?php
if (!defined("APP")) {
    die("No Access!");
}





class terms extends Module {


    /**
    *   
    *   
    **/
    public function init() {

        $data = array();

        global $lang;

        $file_path = MODULES_DIR."terms/langfiles/$lang.html";

        if(file_exists($file_path)) {
            $content = file_get_contents($file_path);
        } else {
            $content = file_get_contents(MODULES_DIR."terms/langfiles/en.html");
        }

        $data['content'] = $content;
        return $this->output($data,"",false);
    }





}

