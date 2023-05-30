<?php

namespace App\Http\Controllers;


use App\Integrations\Helpers\TokenGenerator;
use App\Integrations\Helpers\UIDSecurity;
use App\Models\Persistence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class TestController extends Controller
{
    public function handle(Request $request,Persistence $persistence)
    {

            $save = $persistence->persist("asdasdasfasdkasgdywjedsd",[1,2,3,4,5,6,7,7]);


            var_export($save);


        $edit = $persistence->edit("asdasdasfasdkasgdywjedsd",[0000000]);

        var_export($edit);
        echo "1";


    }



    /**
     * Sample Of Token eneration and retrieval
     */
    private function TokenGenerationAndValidation()
    {
        $DataToSend = [
            'OperatorId'=>481,
            'PlayerId'=>1,
            'UserName'=>'shako',
            'Currency'=>'EUR',
            'UserIP'=>null,
            'TotalBalance'=>0
        ];

        $token = TokenGenerator::generateToken($DataToSend);

        echo $token;


        $validated = TokenGenerator::validateToken("xbXvi9R4yNZ4QOkXgazwi8ZpvjM6b{s2}dhS2aIjEX9kkl6LgOSeBOd1jMjGPeh{s1}QO0MqkiT1NA8AHyS7fnnyThUmYGJzMrsF9RhnTjSiYcT56mxsF3gLG1hGaMLk8eFveLw6dHdKHu6xr8duXB0RqHtXzYndi{s1}h{s1}q5e8UeZ3hMBC6Y8S{s2}540JgwFLnXys2Z43dyV{s2}rbdgy8Y6KqUa6ngW3pg==");
        print_r($validated);
    }

}