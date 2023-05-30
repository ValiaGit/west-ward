<?php

if(!defined("APP")) {
    die("No Access!");
}



/**
 * Real Estate Controller
 */
class Page extends Controller {

    /**
     * Initilization of real estate main controller
     */
    public function show() {

        //Data To Be Sent To Tpl
        $data = array();
        
        $page = $this->loadModel("page")->get($_GET['stringParam']);
        $content = $this->loadModel("content")->getContent($page['id']);

        if($content) {

            if($content['type'] == 2) {
                $module_name = $content['module_name'];
                $module = Module::load($module_name);
                $page['content'] = $module->init();

            } else {
                $page['content'] = $content;
            }

        } else {
            $page['content'] = "";
        }

        $data['page'] = $page;


        echo $this->render("page.tpl",$data);

    }
}



