<?php

namespace App\Services\CoinGeckoApi\Api;

class Ping extends Api
{
    public function ping(): array
    {
        return $this->get('/ping');
    }
}
