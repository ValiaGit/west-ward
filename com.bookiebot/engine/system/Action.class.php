<?php
if (!defined("APP")) {
    die("Dont have Access");
}
if(!function_exists('str_getcsv')) {
    function str_getcsv($input, $delimiter = ',', $enclosure = '"') {

        if( ! preg_match("/[$enclosure]/", $input) ) {
            return (array)preg_replace(array("/^\\s*/", "/\\s*$/"), '', explode($delimiter, $input));
        }

        $token = "##"; $token2 = "::";
        //alternate tokens "\034\034", "\035\035", "%%";
        $t1 = preg_replace(array("/\\\[$enclosure]/", "/$enclosure{2}/",
                "/[$enclosure]\\s*[$delimiter]\\s*[$enclosure]\\s*/", "/\\s*[$enclosure]\\s*/"),
            array($token2, $token2, $token, $token), trim(trim(trim($input), $enclosure)));

        $a = explode($token, $t1);
        foreach($a as $k=>$v) {
            if ( preg_match("/^{$delimiter}/", $v) || preg_match("/{$delimiter}$/", $v) ) {
                $a[$k] = trim($v, $delimiter); $a[$k] = preg_replace("/$delimiter/", "$token", $a[$k]); }
        }
        $a = explode($token, implode($token, $a));
        return (array)preg_replace(array("/^\\s/", "/\\s$/", "/$token2/"), array('', '', $enclosure), $a);

    }
}


/**
 * Class Action. Routes GET parameters To Concrete Controllers
 */
class Action
{


    public static function handle($data)
    {
        $controller = @$data['controller'];


        if (strpos($controller, "_")) {
            $controller = str_replace("_", "/", $controller);
        }

        $method = @$data['method'];
        $param = isset($_GET['stringParam']) ? @$_GET['stringParam'] : (int)@$_GET['intParam'];
        $folder = false;
        if(isset($_GET['folder'])) {
            $folder = $_GET['folder'];
        }

        self::route($controller, $method, $param, $folder);
    }


    /**
     *
     * Routs Actions To Specified Controller
     *
     *
     * @param string route. (index or user/register)
     * @param string method.(Name of controller method "login" for example for users controller);
     * @param string parameters.Comma separated parameters that will be passed to selected controller method (exmpl. ntest004,test1234);
     * @return void
     */
    public static function route($controller, $method = false, $parameters = "",$folder = false)
    {


        global $config;

        //If Route Was Requested, for specified controller
        if ($controller) {

            if($folder) {
                //If controller file doesnt exist
                if (!file_exists(CONTROLLER_DIR . "/$folder/$controller.controller.php")) {
                    Action::redirect("");
                }

                require_once CONTROLLER_DIR . "/$folder/$controller.controller.php";
            }

            else {
                //If controller file doesnt exist
                if (!file_exists(CONTROLLER_DIR . "/$controller.controller.php")) {
                    Action::redirect("");
                }

                require_once CONTROLLER_DIR . "/$controller.controller.php";
            }


            //Class Title
            $exploded = explode("/", $controller);
            $lastPiece = end($exploded);
            $Classtitle = ucfirst($lastPiece);

            //Initialize Controller
            if (class_exists($Classtitle)) {

                $clasObject = new $Classtitle();

                //If We want to call some method of controller
                if ($method) {
                    if (method_exists($clasObject, $method)) {

                        if ($parameters == "") {
                            $POST = array_values($_POST);
                            $params = implode(",", $POST);
                            $response = call_user_func_array(array($clasObject, $method), str_getcsv($params));
                        } else {

                            $params = $parameters;
                            $response = call_user_func_array(array($clasObject, $method), str_getcsv($params));

                        }

                    } else {
                        Action::redirect("");
                    }


                } //If concrete method isnt requested than init() method is called by default
                else {
                    if (method_exists($clasObject, "init")) {
                        $clasObject->init();
                    } else {
                        Action::redirect("");
                    }
                }

            } else {
                Action::redirect("");
            }

        } //Default Route
        else {

            //If controller file doesnt exist
            if (!file_exists(CONTROLLER_DIR . "/$config[default_contrtoller].controller.php")) {
                Action::redirect("");
            }

            //Require Requested Controller Class
            require_once CONTROLLER_DIR . "/$config[default_contrtoller].controller.php";

            //Class Title
            $Classtitle = ucfirst($config['default_contrtoller']);

            //Initialize Controller
            if (class_exists($Classtitle)) {

                $clasObject = new $Classtitle();
                if (method_exists($clasObject, "init")) {
                    $clasObject->init();
                } else {
                    Action::redirect("");
                }
            }
        }


    }


    /**
     * Redirects route
     * @param string route (main/main or main/category)
     * @return void
     */
    public static function redirect($route, $status = 302)
    {
        global $config;
        header('Status: ' . $status);
        header("Location: $config[base_href]/" . LANG . "/$route");
    }




}


?>