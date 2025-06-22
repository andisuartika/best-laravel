<?php

namespace App\Services;

use Midtrans\Config;

class MidtransService
{
    public static function config(): void
    {
        Config::$serverKey     = config('midtrans.server_key');
        Config::$isProduction  = config('midtrans.is_production', false);
        Config::$isSanitized   = true;
        Config::$is3ds         = true;
    }
}
