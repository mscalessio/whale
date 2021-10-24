<?php

namespace App\Http\Controllers\Api\CoinGecko;

use App\Http\Controllers\Controller;
use App\Services\CoinGeckoApi\CoinGeckoClient;
use Illuminate\Support\Facades\Request;

class PingController extends Controller
{

    public function ping(CoinGeckoClient $coinGeckoApi)
    {
        return $coinGeckoApi->ping();
    }


}
