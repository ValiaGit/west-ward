<?php
if (!defined("APP")) {
    die("No Access!");
}





class accountsubmenu extends Module {


    public function init() {
        //Data Sent to module template
        $data = array();
        $method = @$_GET['method'];
        $data['method'] = $method;

        $page_model = Controller::loadModel("page");
        $data['user_menu_list'] = $page_model->getMenuList(2);
        return $this->output($data,"",true);
    }

}


?>