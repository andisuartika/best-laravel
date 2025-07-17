<?php

namespace App\Services;

use Midtrans\Snap;
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


    public function getSnapToken(array $params): string
    {
        $this->config();

        return Snap::getSnapToken($params);
    }
}
