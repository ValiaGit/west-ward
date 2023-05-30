<?php
if (!defined("APP")) {
    die("No Access!");
}





class footer extends Module {


    public function init() {
        //Data Sent to module template
        $data = array();
        $page_model = Controller::loadModel("page");
        $data['secondary_menu_list'] = $page_model->getMenuList(4);

        $data['app_scripts'] = "";
        $data['app_scripts'] = readd(PUBLIC_DIR.'/_media/js/Betstock/App');
//        $data['app_scripts'] = "<script type=\"text/javascript\" src=\"/app/templates/default/view/_media/js/betstock.js\"></script>\n";


        //Header('Content-Type: application/javascript');

        return $this->output($data,"",true);
    }

}


function readd($path){
    $ret = '';
    if($handle = opendir($path)){
        while(false != ($entry = readdir($handle))){

            if ($entry != "." && $entry != ".." & $entry != 'app.php') {

                //Get Extension
                if(substr(strrchr($entry,'.'),1) == 'js')
                {
                    $file_path = ltrim(trim($path,'./').'/'.$entry,'/');
                    $file_path = explode('_media',$file_path);
                    $file_path = $file_path[1];

                    //                    echo file_get_contents($file_path)."\n\n\n";
                    $ret .= "<script type=\"text/javascript\" src=\"/app/templates/default/view/_media/$file_path\"></script>\n";
                }//read sub directory
                else{
                    $ret .= readd($path.'/'.$entry);
                }//end read sub
            }//end if

        }//end while

    }//end if
    return $ret;

}//end readd
?>