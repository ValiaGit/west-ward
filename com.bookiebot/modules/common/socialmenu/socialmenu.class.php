<?php
if (!defined("APP")) {
    die("No Access!");
}





class socialmenu extends Module {


    public function init() {

        global $config;
        global $lang;

        //Data Sent to module template
        $data = array();

        //Get Profile Pages List
        $pages_model = Controller::loadModel("page");
        $profile_pages_list = $pages_model->getMenuList(5);
        $data['list'] = $profile_pages_list;


        return $this->output($data,"",true);
    }

}


?>