<?php

namespace App\Integrations\BetConstruct;


use App\Integrations\Habanero\Constants\ErrorCodes;
use App\Integrations\Habanero\Constants\Config;
use App\Integrations\Constants\GISErrorCodes;
use App\Integrations\Vendors\GameVendorBase;

use Illuminate\Http\Request;


/**
 * All Habanero requests will pass through this method
 * This method Will Determine what is request type and will
 * Route requests to appropriate internal methods
 * @SWG\POST(
 *     path="/habanero/handle",
 *     summary="This is entry point for all Habanero Requests",
 *     tags={"Habanero"},
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
class Habanero extends GameVendorBase
{


    
}