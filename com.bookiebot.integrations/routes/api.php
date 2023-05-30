<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/






$providers = config('routes');




/**
 * Iterate Over provider configurations
 */
foreach($providers as $namespace=>$provider_parameters) {

    //Get Provider NameSpace and Method Endpoints
    $request_type = $provider_parameters['request_type'];

    if(isset($provider_parameters['exposed'])) {
        $methods = $provider_parameters['exposed'];
        //Iterate Over Available Endpoints and Set Routes
        foreach($methods as $path=>$endpoint_data) {

            //Set URL eNDPOINT
            $final_path = strtolower($namespace)."/$path";

            //If Config Forced to set certain Endpoint We should use that
            if(isset($endpoint_data['forced_path'])) {
                $final_path = $endpoint_data['forced_path'];
            }


            $handler_class = isset($endpoint_data['handler_class'])?$endpoint_data['handler_class']:"";
            $handler_method = isset($endpoint_data['handler_method'])?$endpoint_data['handler_method']:"";


            //Check Request Type And Set Appropriate Route
            if($request_type == 'post') {
//                echo "$final_path<br/>";
                Route::post($final_path, [App\Http\Controllers\IntegrationController::class, 'handle'])->middleware("validator:$namespace,$path,$handler_class,$handler_method");
            }

            elseif($request_type == 'get') {
                Route::get($final_path, [App\Http\Controllers\IntegrationController::class, 'handle'] )->middleware("validatwor:$namespace,$path,$handler_class,$handler_method");
            }

        }
    }



    if(isset($provider_parameters['internal'])) {
        $internal_methods = $provider_parameters['internal'];
        //Iterate Over Available Endpoints and Set Routes
        foreach($internal_methods as $path=>$endpoint_data) {

            //Set URL eNDPOINT
            $final_path = strtolower($namespace)."/$path";

            //If Config Forced to set certain Endpoint We should use that
            if(isset($endpoint_data['forced_path'])) {
                $final_path = $endpoint_data['forced_path'];
            }


            //Set Handler Method And Class
            $handler_class = isset($endpoint_data['handler_class'])?$endpoint_data['handler_class']:"";
            $handler_method = isset($endpoint_data['handler_method'])?$endpoint_data['handler_method']:"";




            //Check Request Type And Set Appropriate Route
            if($request_type == 'post') {
                Route::post($final_path, [App\Http\Controllers\IntegrationController::class, 'handle'])->middleware("validator:$namespace,$path,$handler_class,$handler_method",'internal');
            }

            elseif($request_type == 'get') {
                Route::get($final_path, [App\Http\Controllers\IntegrationController::class, 'handle'])->middleware("validator:$namespace,$path,$handler_class,$handler_method",'internal');
            }

        }
    }





}



Route::get("launch", [App\Http\Controllers\LaunchController::class, 'handle']);


Route::get('test',[App\Http\Controllers\TestController::class, 'handle']);



