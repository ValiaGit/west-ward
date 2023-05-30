<?php

namespace App\Integrations\Vendors;



use App\Http\Controllers\LaunchController;
use App\Integrations\Constants\GISErrorCodes;

//Each Game Vendor Derives From This Class
//And Has Two Additional Methods
class GameVendorBase {


    /**
     * This method dynamically creates and returns Casino Integration Instance
     * Instance Come From Configuration Parameter
     * @param $provider_id
     * @param $secret
     * @return mixed
     */
    protected function getCasinoIntegrationInstance($provider_id,$secret) {

        //Get Defaulr Casino Instance
        $default_casino = config('app')['default_casino'];

        //Create Casino Integration Instance
        $CasinoClass = "App\\Integrations\\Casino\\$default_casino\\CasinoCore";

        //If Casino Implementation Doesn't exist Return False
        if(!class_exists($CasinoClass)) {
            
            //Todo Throw Exception Wrong Request Casino Inmplementation Not Found

            return false;
        }

        //Return Resolved Class Instance
        return resolve($CasinoClass,[$provider_id,$secret]);
    }


    /**
     * @param $casino_instance
     * @param $vendorType
     * @return bool|mixed
     */
    protected function getLimitHandlerInstance($casino_instance,$vendorType) {

        //Get Defaulr Casino Instance
        $default_casino = config('app')['default_casino'];

        //Create Casino Integration Instance
        if($vendorType == 'payment') {
            $LimitHandlerClass = "App\\Integrations\\Limits\\PayLimit";
        } else {
            $LimitHandlerClass = "App\\Integrations\\Limits\\GameLimit";
        }


        //If Casino Implementation Doesn't exist Return False
        if(!class_exists($LimitHandlerClass)) {

            //Todo Throw Exception Wrong Request Casino Inmplementation Not Found

            return false;
        }

        //Return Resolved Class Instance
        return resolve($LimitHandlerClass,[$casino_instance]);
    }




    /**
     * Method accepts URL with this format http://example.com?token={token}&gameId={gameiD}
     * And parameters array like this
     *
     * @param $url
     * @param $parameters
     * @return mixed
     */
    protected function populateURLWithParameters( $url, $parameters) {
        return LaunchController::populateURLWithParameters($url,$parameters);
    }


    /**
     * @param $userId
     * @param $currency
     * @return int
     */
    protected function grabBalance($userId,$currency) {
        if($this->CasinoCore) {
            $balanceResponse = $this->CasinoCore->getBalance($userId,$currency);
            if($balanceResponse['code'] == GISErrorCodes::SUCCESS) {
                return (float)$balanceResponse['data']['balance'];
            } else {
                //Log That we could not get balance
                return 0;
            }
        } else {
            return 0;
        }
    }


}
