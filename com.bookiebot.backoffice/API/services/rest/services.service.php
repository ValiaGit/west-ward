<?php


class Services extends Service {


    /**
     * @return array
     */
    function getServices() {
        $return = array();
        $di = new RecursiveDirectoryIterator(SERVICE_DIR);

        $i=1;
        foreach (new RecursiveIteratorIterator($di) as $filename => $file) {
            try {
                if($file->getFilename() == "." || $file->getFilename() == "..") {
                    continue;
                }

                $pi = pathinfo($filename);

                $dir_name = $pi['dirname'];
                $folder = explode("services/",$dir_name);
                $folder = $folder[1];

                $service_name = $pi['filename'];
                $service_name = explode(".",$service_name);
                $service_name = $service_name[0];



                if($folder.".".$service_name == "rest.services" || $folder == "parsing") {
                    continue;
                }
                $methods = $this->getMethods($folder."/".$service_name);

                array_push($return,array(
                    "id"=>$i,
                    "service"=>$folder.".".$service_name,
                    "methods"=>$methods
                ));

                $i++;
            } catch(Exception $e) {
                echo $e->getMessage();
            }


        }


        return $return;
    }


    /**
     * @param $service
     * @return array
     */
    function getMethods($service) {

        $serviceObject = $this->loadService($service);
        $return = array();

        try {
            $methods = get_class_methods($serviceObject);
            for($i=0;$i<count($methods);$i++) {
                $method = $methods[$i];
                $r = new ReflectionMethod($serviceObject, $method);
                $params = $r->getParameters();
                $comments = $r->getDocComment();

                foreach($params as &$param) {
                    $param = (array)$param;
                }
                if($method == "__construct" || $method == "loadService" || $method == "checkUserAccess" || $method == "getUnserializedTitle") {
                    continue;
                }
                array_push($return,array(
                    "name"=>$method,
                    "comments"=>$comments,
                    "parameters"=>$params
                ));
            }
        }catch(Exception $e) {
            echo $e->getMessage();
        }


        return $return;
    }


}