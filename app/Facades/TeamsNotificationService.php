<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \App\TeamsNotificationService
 */
class TeamsNotificationService extends Facade
{
    // Teamsへの通知発火処理
    protected static function getFacadeAccessor(): string
    {
        return \App\TeamsNotificationService::class;
    }
}
