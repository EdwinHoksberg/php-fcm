<?php

namespace Fcm\Laravel;

use Fcm\FcmClient;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array send(\Fcm\Request $request)
 */
class Fcm extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return FcmClient::class;
    }
}
