<?php
//ini_set("display_errors",0);
//
//class Services extends Service {
//
//
//    /**
//     * @return array
//     */
//    function getServices() {
//        $return = array();
//        $di = new RecursiveDirectoryIterator(SERVICE_DIR);
//
//        $i=1;
//        foreach (new RecursiveIteratorIterator($di) as $filename => $file) {
//
//            if($file->getFilename() == "." || $file->getFilename() == "..") {
//                continue;
//            }
//
//            $pi = pathinfo($filename);
//            if($pi['extension'] == "DS_Store") {
//                continue;
//            }
//
//
//            $dir_name = $pi['dirname'];
//
//            $folder = explode("services/",$dir_name);
//            $folder = $folder[1];
//
//            $service_name = $pi['filename'];
//            $service_name = explode(".",$service_name);
//            $service_name = $service_name[0];
//
//
//            $methods = $this->getMethods($folder."/".$service_name);
//            if($folder.".".$service_name == "rest.services") {
//                continue;
//            }
//
//            array_push($return,array(
//                "id"=>$i,
//                "service"=>$folder.".".$service_name,
//                "methods"=>$methods
//            ));
//            $i++;
//        }
//
//
//
//        return $return;
//    }
//
//
//    /**
//     * @param $service
//     * @return array
//     */
//    function getMethods($service) {
//        $serviceObject = $this->loadService($service);
//        $return = array();
//
//        $methods = get_class_methods($serviceObject);
//
//        if($methods) {
//            foreach($methods as $method) {
//                $r = new ReflectionMethod($serviceObject, $method);
//                $params = $r->getParameters();
//                $comments = $r->getDocComment();
//
//                foreach($params as &$param) {
//                    $param = (array)$param;
//                }
//
//                if($method == "__construct" || $method == "loadService" || $method == "checkUserAccess" || $method == "getUnserializedTitle") {
//                    continue;
//                }
//                array_push($return,array(
//                    "name"=>$method,
//                    "parameters"=>$params,
//                    "comments"=>$comments
//                ));
//            }
//
//        }
//
//        return $return;
//    }
//
//
//}