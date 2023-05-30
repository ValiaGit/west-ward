<?php
if (!defined("APP")) {
    die("No Access!");
}





class topmenu extends Module {


    /**
    *   
    *   
    **/
    public function init() {

        global $config;
        $data = array();


        //Load pages model and get main menu items
        $page_model = Controller::loadModel("page");

        $data['main_menu_list'] = $page_model->getMenuList(1);//Main,Social Parts
        $data['user_menu_list'] = $page_model->getMenuList(2);//Account Menu



        //Avalilable Languages for language selector
        $data['langs'] = $config['langs'];

        return $this->output($data,"",true);
    }





}

