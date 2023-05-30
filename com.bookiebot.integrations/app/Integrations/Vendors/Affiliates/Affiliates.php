<?php

namespace App\Integrations\Affiliates;



use App\Integrations\Affiliates\Constants\Config;
use App\Integrations\Casino\CasinoCoreInterface;
use App\Integrations\Constants\GISErrorCodes;
use App\Integrations\Helpers\GISLogger;
use App\Integrations\Helpers\TokenGenerator;
use App\Integrations\Helpers\UUIDGenerator;
use App\Integrations\ResponderTrait;
use App\Integrations\Vendors\GameVendorBase;

use App\Models\Persistence;
use Illuminate\Http\Request;


class Affiliates extends GameVendorBase
{
    use ResponderTrait;

    /**
     * Instance For Communicating Casino Core
     * @var CasinoCoreInterface
     */
    protected $CasinoCore;


    /**
     *
     * @var Persistence
     */
    protected $Persistence;

    /**
     * @var GISLogger
     */
    private $Logger;

    /**
     * Constructor. - Inject GISLogger Implementation Details
     * BetConstruct constructor.
     * @param GISLogger $Logger
     */
    public function __construct(Persistence $Persistence, GISLogger $Logger)
    {

        $this->Logger = $Logger;


        $this->Persistence = $Persistence;

        //Inject Casino Core Instance
        $this->CasinoCore = $this->getCasinoIntegrationInstance(
            Config::PROVIDER(),
            Config::SECRET()
        );
    }


    /**
     * Authenticates a user in the game by Token (integration with iFrame).
     *
     * OperatorId , Token , PublicKey
     *
     * @SWG\POST(
     *     path="/api/affiliates/auth",
     *     summary="Authenticate User VIA token for Affiliates System",
     *     tags={"Affiliates"},
     *     description="Affiliates System Gets Token and then validates that token here",
     *
     *   @SWG\Parameter(
     *     in="formData",
     *     name="token",
     *     description="",
     *     required=true,
     *     default="XXXX-ZZZZZ-YYYYY",
     *     type="string"
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
     *
     * @param Request $request
     * @return mixed
     */
    public function auth(Request $request) {

        $token = $request->input('token');

        if(!$token) {
            return $this->respondError(GISErrorCodes::WRONG_REQUEST,"Token is missing in request");
        }

        try {
            $auth = $this->CasinoCore->auth($token);

            return $auth;
        }catch(\Exception $e) {
            return $this->respondError(GISErrorCodes::GENERAL_ERROR,"Something went wrong");
        }

    }

    /**
     * Deposit Money On Users Balances
     *
     * OperatorId , Token , PublicKey
     *
     * @SWG\POST(
     *     path="/api/affiliates/deposit",
     *     summary="Authenticate User VIA token for Affiliates System",
     *     tags={"Affiliates"},
     *     description="Deposit Money on users balances",
     *
     *   @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     description="Users list who should be awarded for affiliation activity",
     *     required=false,
     *     default="[
    {""user_id"":""11"",""amount"":""55""},
    {""user_id"":""44"",""amount"":""120""}
]",
     *     @SWG\Schema(
     *       type="json",
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
     *
     * @param Request $request
     * @return mixed
     */
    public function deposit(Request $request) {

        try {
            $data = $request->getContent();
            $users = \json_decode($data);

            if(!$users) {
                return $this->respondError(GISErrorCodes::WRONG_REQUEST,"Provided JSON is not valid");
            }



            return $users;
        }catch (\Exception $e) {
            return $this->respondError(GISErrorCodes::GENERAL_ERROR,"Something went wrong!");
        }

    }


}