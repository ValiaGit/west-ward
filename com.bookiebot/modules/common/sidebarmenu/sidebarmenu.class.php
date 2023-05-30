<?php
if (!defined("APP")) {
    die("No Access!");
}





class sidebarmenu extends Module {


    /**
     *
     *
     **/
    public function init() {

        global $config;
        $data = array();

        //Load pages model and get main menu items
        $page_model = Controller::loadModel("page");

        $data['sidebar_menu'] = $page_model->getMenuList("3,4");//Static Pages(About,Faq, etc...)

        //Avalilable Languages for language selector
        $data['langs'] = $config['langs'];

        return $this->output($data,"",true);
    }





}

