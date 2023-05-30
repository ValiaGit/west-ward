<?php




class Social extends Controller {

    public function init() {
        $data = array();
        global $needs_authentication;
        $needs_authentication = true;
        echo $this->render("social/index.tpl",$data);
    }


    public function friends() {
        $data = array();
        global $needs_authentication;
        $needs_authentication = true;

        echo $this->render("social/friends.tpl",$data);
    }


    public function communities() {
        $data = array();
        global $needs_authentication;
        $needs_authentication = true;

        echo $this->render("social/communities.tpl",$data);
    }



    public function messages() {
        $data = array();
        global $needs_authentication;
        $needs_authentication = true;

        echo $this->render("social/messages.tpl",$data);
    }


    public function community() {
        $data = array();
        global $needs_authentication;
        $needs_authentication = true;

        $community_id = (int) $_GET['intParam'];
        $data['community_id'] = $community_id;

        echo $this->render("social/community.tpl",$data);
    }



    public function user() {
        $data = array();
        global $needs_authentication;
        $needs_authentication = true;

        $user_id = $_GET['intParam'];
        if(!$user_id) {
            Action::redirect("");
        }
        echo $this->render("social/user.tpl",$data);

    }



}




?>