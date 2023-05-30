<?php

namespace App\Integrations\BetConstruct\Constants;


class TransactionTypes
{

    const TIP = -9;
    const JOIN_TOURNAMENT = -4;
    const CREATE_SIT = -2;
    const STANDART_BET = -1;
    const STANDART_DO_BET_WIN = 0;
    const STANDART_WIN = 1;
    const WIN_ON_SKILL_GAME_TABLE = 2;
    const TOURNAMENT_WIN = 3;
    const UNREGISTER_FROM_TOURNAMENT = 4;
    const CASHBACK_BONUS = 9;


    const TYPES_REVERSED = [
        -9 => 'TIP',
        -4 => 'JOIN_TOURNAMENT',
        -2 => 'CREATE_SIT',
        -1 => 'STANDART_BET',
        0 => 'STANDART_DO_BET_WIN',
        1 => 'STANDART_WIN',
        2 => 'WIN_ON_SKILL_GAME_TABLE',
        3 => 'TOURNAMENT_WIN',
        4 => 'UNREGISTER_FROM_TOURNAMENT',
        9 => 'CASHBACK_BONUS'
    ];

}