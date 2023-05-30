<?php

namespace App\Integrations\Limits;



use App\Integrations\Casino\CasinoCoreInterface;

class PayLimit {

    /**
     * @var CasinoCoreInterface
     */
    private $casino_core;

    public function __construct($CasinoCoreImplementation)
    {
        $this->casino_core = $CasinoCoreImplementation;
    }


    public function check($userId,$amount) {



        return [
            'I was called',
            'data'=>$this->casino_core->getUserInfo($userId)
        ];




    }

}