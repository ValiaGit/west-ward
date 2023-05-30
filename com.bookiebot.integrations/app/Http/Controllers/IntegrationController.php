<?php

namespace App\Http\Controllers;

use App\Integrations\Constants\GISErrorCodes;
use App\Integrations\ResponderTrait;
use Illuminate\Http\Request;


class IntegrationController extends Controller
{

    use ResponderTrait;

    public function handle(Request $request)
    {


        $path = $request['path'];
        $namespace = $request['namespace'];
        $handlerClass = $request['handlerClass'];
        $handlerMethod = $request['handlerMethod'];


        if($handlerClass) {
            $ProviderHandler = "\\App\\Integrations\\$namespace\\$handlerClass";
        } else {
            $ProviderHandler = "\\App\\Integrations\\$namespace\\$namespace";
        }


        $handler = resolve($ProviderHandler);



        //If Request Want Specific Method Call On Implementation Class
        if($handlerMethod) {
            if(method_exists($handler,$handlerMethod)) {
                //Call Function With Params
                return $handler->$handlerMethod($request);
            }
        } else {
            if(method_exists($handler,$path)) {
                return $handler->$path($request);
            }
        }


        //Handler Not Dound Exception
        return $this->respondError(
            GISErrorCodes::WRONG_REQUEST,
            'Request was not handleed by system',
            null,
            GISErrorCodes::WRONG_REQUEST
        );


    }
}
