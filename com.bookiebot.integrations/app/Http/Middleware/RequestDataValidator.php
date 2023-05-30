<?php

namespace App\Http\Middleware;

use App\Integrations\Constants\GISErrorCodes;
use App\Integrations\ResponderTrait;
use Closure;

class RequestDataValidator
{

    use ResponderTrait;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  $namespace - This is game provider name (Ezugi,Netent and etc...)
     * @param  $path - This is path which will be key For all route Config params. e.g auth,deposit,withdraw
     * @param  $handlerClass - This sets Handler Class under $namespace - For Exmaple Ezugi can have two classes Bonuses, Ezugi, FreeSpins and each class can be executed on different endpoints
     * @param  $handlerMethod - Method which will be executed on Request: e.g: addBonus, addFreeSpins
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $namespace, $path, $handlerClass, $handlerMethod)
    {
        //Get Configuration For Routes
        $routes = config("routes");


        //Set Some Variables On Reuqest Object to pass next Controller
        $request['path'] = $path;
        $request['namespace'] = $namespace;
        $request['handlerClass'] = $handlerClass;
        $request['handlerMethod'] = $handlerMethod;


        //Check Config Parameters for current endpoint
        if (isset($routes[$namespace])) {

            //Route Config Parameters
            $parameters = $routes[$namespace];


            //Check Concrete Parameters For Current Endpoint
            if(isset($parameters['exposed'])) {
                $exposed_paths = $parameters['exposed'];
                if (isset($exposed_paths[$path])) {

                    $path_params = $exposed_paths[$path];

                    //Get Validation Rules
                    if (isset($path_params['validation'])) {
                        $rules = $path_params['validation'];

                        //If Validation Rules Passed succesfully
                        if($this->validate($request,$rules)) {
                            return $next($request);
                        }

                        //If Validation Didn't pass
                        else {
                            //This method will retrn message that request was wrong and validation didn't pass routing
                            return $this->sendRequestValidationError($namespace,$handlerClass);
                        }


                    }


                }
            }


            //Check Concrete Parameters For Current Endpoint
            if(isset($parameters['internal'])) {
                $exposed_paths = $parameters['internal'];
                if (isset($exposed_paths[$path])) {

                    $path_params = $exposed_paths[$path];

                    //Get Validation Rules
                    if (isset($path_params['validation'])) {
                        $rules = $path_params['validation'];



                        //If Validation Rules Passed succesfully
                        if($this->validate($request,$rules)) {
                            return $next($request);
                        }

                        //If Validation Didn't pass
                        else {
                            //This method will retrn message that request was wrong and validation didn't pass routing
                            return $this->sendRequestValidationError($namespace,$handlerClass);
                        }


                    }


                }
            }


        }


        return $next($request);
    }


    /**
     * Accepts Request Object And Validation Rules
     * To Check if provided request complies against rules
     * @param $request
     * @param $rules
     * @return bool
     */
    private function validate($request,$rules) {



        //Get Method Name Of Request
        $method = $request->method();


        if($method == 'POST') {

            //If Validation Is Set on Raw JSON Data
            if(isset($rules['raw']) && count($rules['raw'])) {
                try {


                    $data_as_array = json_decode($request->getContent(),true);
                    $mandatory_params = $rules['raw'];


                    //Iterate Over Mandatory Param Names And Check if they exist in request
                    foreach($mandatory_params as $param_to_be_present) {
                        if(!isset($data_as_array[$param_to_be_present])) {
                            return false;
                        }
                    }

                }catch(Exception $e) {
                    return false;
                }
            }
        }


        if(isset($rules['query'])) {
            $mandatory_query_params = $rules['query'];
            return $this->CheckValidity($mandatory_query_params,$request);
        }

        return true;


    }


    /**
     * Function Gets Two Arguments Mandaatory Params Defined By Config and Actual passed params
     * Then function checks if all mandatory params are in request params and return true or false.
     * @param $mandatory_param_names
     * @param $request
     * @return bool
     * @internal param $actual_params
     */
    private function CheckValidity($mandatory_param_names, $request) {


        /**
         * Iterate Over Mndatory Params and check that each of them are present in actual request params
         */
        if(gettype($mandatory_param_names) == 'array') {
            if(count($mandatory_param_names)) {
                foreach($mandatory_param_names as $rule_param) {
                    //If Request Params Doesnt include Any Mandatory Param Request is Invalid
                    if(!$request->has($rule_param)) {
                        return false;
                    }
                }
            }

        }


        return true;
    }




    /**
     * If Game Vendor Class Has Special Error Validator Call that method to return response
     * Otherwise we return JSON with some error data contained
     */
    private function sendRequestValidationError($namespace,$handlerClass) {

        //Get Handler Class Namespace
        if($handlerClass) {
            $ProviderHandler = "\\App\\Integrations\\$namespace\\$handlerClass";
        } else {
            $ProviderHandler = "\\App\\Integrations\\$namespace\\$namespace";
        }

        //Instantiate Handler GameVendor Class
        $handler = resolve($ProviderHandler);

        //If Nanler Instance Found
        if($handler) {
            //If Game Vendor Handler Class Has respondError Class
            if(method_exists($handler,'respondVendorWrongRequest')) {
                //Send Error Message From Game Vendor Class
                return $handler->respondVendorWrongRequest(GISErrorCodes::WRONG_REQUEST);
            }
        }


        //If No Specific Handler Send General Wrong Request JSON Response
        return $this->respondError(
            GISErrorCodes::WRONG_REQUEST,
            "Wrong Request",
            null,
            GISErrorCodes::WRONG_REQUEST
        );
    }



}
