<?php

if(!defined("APP")) {
    die("No Access!");
}



/**
 * Real Estate Controller
 */
class User extends Controller {

    private $data = array();

    public function __construct(){
        parent::__construct();
        $this->_getUserMenu();
    }


    public function register() {
        if(isset($_GET['ajax'])) {
            echo $this->render("user_ajax/register.tpl",$this->data);
        } else {
            echo $this->render("user/register.tpl",$this->data);
        }
    }


    public function withdraw() {
        $this->_requireAuth();
        $providers = $this->loadModel("providers")->getList(2);
        $this->data['providers'] = $providers;
        echo $this->render("user/withdraw.tpl",$this->data);
    }


    public function balance_management() {
        $this->_requireAuth();
        $data['method'] = @$_GET['method'];
        $providers = $this->loadModel("providers")->getList(1);
        $this->data['providers'] = $providers;
        echo $this->render("user/deposit.tpl",$this->data);
    }


    public function deposit() {
        $this->_requireAuth();

        $providers = $this->loadModel("providers")->getList(1);
        $this->data['providers'] = $providers;

        echo $this->render("user/deposit.tpl",$this->data);
    }

    public function transfer_history() {
        $this->_requireAuth();

        echo $this->render("user/transfers_history.tpl",$this->data);
    }


    public function card_details() {
        $this->_requireAuth();

        echo $this->render("user/card_details.tpl",$this->data);
    }


    public function settings() {
        $this->_requireAuth();
        $countries = $this->loadModel("countries");

        $this->data['countries'] = $countries->getList();
        echo $this->render("user/settings.tpl",$this->data);
    }

    public function rewards() {
        $this->_requireAuth();
        echo $this->render("user/rewards.tpl",$this->data);
    }

    public function protection() {
        $this->_requireAuth();
        echo $this->render("user/protection.tpl",$this->data);
    }


    public function betting_history() {
        $this->_requireAuth();
        echo $this->render("user/betting_history.tpl",$this->data);
    }


    public function card_management() {
        $this->_requireAuth();
        echo $this->render("user/card_management.tpl",$this->data);
    }

    public function transfers_history() {
        $this->_requireAuth();
        echo $this->render("user/transfers_history.tpl",$this->data);
    }


    public function transfer_history_games() {
        $this->_requireAuth();
        echo $this->render("user/transfers_history_games.tpl",$this->data);
    }


    public function access_log() {
        $this->_requireAuth();
        echo $this->render("user/access_log.tpl",$this->data);

    }


    private function _getUserMenu() {
        $page_model = Controller::loadModel("page");
        $this->data['user_menu_list'] = $page_model->getMenuList(2);
    }


    private function _requireAuth() {
        global $needs_authentication;
        $needs_authentication = true;
    }



    public function notifications() {
        $this->_requireAuth();
        echo $this->render("user/notifications.tpl",$this->data);
    }



}
