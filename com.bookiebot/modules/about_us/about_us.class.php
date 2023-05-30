<?php
if(!defined("APP")) {
    die("No Access!");
}





class about_us extends Module {


    /**
     *
     *
     **/
    public function init() {

        $data = array();

        global $lang;

        $file_path = MODULES_DIR."about_us/langfiles/$lang.html";

        if(file_exists($file_path)) {
            $content = file_get_contents($file_path);
        } else {
            $content = file_get_contents(MODULES_DIR."about_us/langfiles/en.html");
        }

        $data['content'] = $content;
        return $this->output($data,"",false);
    }





}

