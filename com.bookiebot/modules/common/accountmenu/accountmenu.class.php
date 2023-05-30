<?php
if(!defined("APP")) {
    die("No Access!");
}





class accountmenu extends Module {


    public function init() {
        //Data Sent to module template
        $data = array();

        $page_model = Controller::loadModel("page");
        $data['user_menu_list'] = $page_model->getMenuList(2);
        $data['method'] = @$_GET['method'];

        return $this->output($data,"",true);
    }

}


?>