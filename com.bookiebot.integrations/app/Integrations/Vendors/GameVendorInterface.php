<?php

namespace App\Integrations\Vendors;



use Illuminate\Http\Request;

interface GameVendorInterface {


    /**
     * This Method
     * @return mixed
     */
    public function auth(Request $request,$parameters = false);

    /**
     * @param Request $request
     * @return mixed
     */
    public function deposit(Request $request,$parameters = false);

    /**
     * @param Request $request
     * @return mixed
     */
    public function withdraw(Request $request,$parameters = false);


    /**
     * @param Request $request
     * @return mixed
     */
    public function rollback(Request $request,$parameters = false);
    
}
