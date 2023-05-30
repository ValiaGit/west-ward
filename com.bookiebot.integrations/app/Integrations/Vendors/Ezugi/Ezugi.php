<?php

namespace App\Integrations\Ezugi;


use App\Integrations\Ezugi\Constants\ErrorCodes;
use App\Integrations\Ezugi\Constants\Config;
use App\Integrations\Constants\GISErrorCodes;
use App\Integrations\Vendors\GameVendorBase;

use Illuminate\Http\Request;


class Ezugi extends GameVendorBase
{


    /**
     * Requests Authenticates User in Casino Core and returns User Data
     *
     * @SWG\POST(
     *     path="/Ezugi/auth",
     *     summary="This is entry point for authenticating users in Ezugi Slots",
     *     tags={"Ezugi"},
     *     description="",
     *
     *   @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     description="Created user object",
     *     required=false,
     *     default="",
     *     @SWG\Schema(
     *       type="xml",
     *       @SWG\Items()
     *     )
     *   ),
     *
     *
     *
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(ref="#/definitions/successModel")
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid request parameters",
     *         @SWG\Schema(ref="#/definitions/errorModel")
     *     ),
     * )
     * @param Request $request
     * @return mixed|string
     */
    public function auth() {
        return false;
    }


    /**
     * Requests Authenticates User in Casino Core and returns User Data
     *
     * @SWG\POST(
     *     path="/Ezugi/debit",
     *     summary="This is entry point for authenticating users in Ezugi Slots",
     *     tags={"Ezugi"},
     *     description="",
     *
     *   @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     description="Created user object",
     *     required=false,
     *     default="",
     *     @SWG\Schema(
     *       type="xml",
     *       @SWG\Items()
     *     )
     *   ),
     *
     *
     *
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(ref="#/definitions/successModel")
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid request parameters",
     *         @SWG\Schema(ref="#/definitions/errorModel")
     *     ),
     * )
     * @param Request $request
     * @return mixed|string
     */
    public function debit() {

    }


    /**
     * Requests Authenticates User in Casino Core and returns User Data
     *
     * @SWG\POST(
     *     path="/Ezugi/rollback",
     *     summary="This is entry point for authenticating users in Ezugi Slots",
     *     tags={"Ezugi"},
     *     description="",
     *
     *   @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     description="Created user object",
     *     required=false,
     *     default="",
     *     @SWG\Schema(
     *       type="xml",
     *       @SWG\Items()
     *     )
     *   ),
     *
     *
     *
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(ref="#/definitions/successModel")
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid request parameters",
     *         @SWG\Schema(ref="#/definitions/errorModel")
     *     ),
     * )
     * @param Request $request
     * @return mixed|string
     */
    public function rollback() {

    }


    /**
     * Requests Authenticates User in Casino Core and returns User Data
     *
     * @SWG\POST(
     *     path="/Ezugi/credit",
     *     summary="This is entry point for authenticating users in Ezugi Slots",
     *     tags={"Ezugi"},
     *     description="",
     *
     *   @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     description="Created user object",
     *     required=false,
     *     default="",
     *     @SWG\Schema(
     *       type="xml",
     *       @SWG\Items()
     *     )
     *   ),
     *
     *
     *
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(ref="#/definitions/successModel")
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid request parameters",
     *         @SWG\Schema(ref="#/definitions/errorModel")
     *     ),
     * )
     * @param Request $request
     * @return mixed|string
     */
    public function credit() {

    }

    
}