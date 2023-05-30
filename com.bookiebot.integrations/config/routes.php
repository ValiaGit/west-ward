<?php


return [


    /**
     * Implement Betsoft Endpoints
     */
    "Betsoft" => [

        'type' => 'http',
        'request_type' => 'get',


        /*
         * This Paths Are Exposed For Public use
         */
        'exposed' => [

            "auth" => [
                'validation' => [
                    'query' => [
                        "token", "hash"
                    ]
                ]
            ],

            "getUserInfo" => [
                'validation' => [
                    'query' => [
                        "userId", "hash"
                    ]
                ]
            ],

            "depositOrWithdraw" => [
                'validation' => [
                    'query' => [
                        "userId",
                        "roundId",
                        "gameId",
                        "isRoundFinished",
                        "hash",
                        "gameSessionId"
                    ]
                ]
            ],

            "refund" => [

            ]
        ]

    ],

    /**
     * Implement Playson Endpoints
     */
    "Playson" => [

        'type' => 'http',
        'request_type' => 'post',

        /*
         * This Paths Are Exposed For Public use
         */
        'exposed' => [

            "handle" => []
        ],


        'internal' => [
            'addBonus' => [
                'handler_class' => 'Bonuses',
                'validation' => [
                    'query' => 'userId,bonusId'
                ]
            ]
        ]

    ],


    "BetConstruct" => [

        'type' => 'http',
        'request_type' => 'post',

        /*
         * This Paths Are Exposed For Public use
         */
        'exposed' => [

            "Authentication" => [],
            "GetBalance" => [],
            "Withdraw" => [],
            "Deposit" => [],
            "WithdrawAndDeposit" => [],
            "Rollback" => [],
            'RefreshToken'=>[]
        ]

    ],


    "Affiliates" => [

        'type' => 'http',
        'request_type' => 'post',

        /*
         * This Paths Are Exposed For Public use
         */
        'exposed' => [

            "auth" => [],
            "deposit" => []
        ]

    ],


    "BcSport" => [
        'type' => 'http',
        'request_type' => 'post',

        /*
         * This Paths Are Exposed For Public use
         */
        'exposed' => [

            "GetClientDetails" => [],
            "GetClientBalance" => [],
            "BetPlaced" => [],
            "BetResulted" => [],
            "Rollback" => [],
            "GetBonusDetails" => [],
            "BonusSetStatus" => [],
        ]
    ]


];