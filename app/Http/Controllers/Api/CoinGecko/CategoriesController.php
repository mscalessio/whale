<?php

namespace App\Http\Controllers\Api\CoinGecko;

use App\Http\Controllers\Controller;
use App\Services\CoinGeckoApi\CoinGeckoClient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * @param CoinGeckoClient $coinGeckoClient
     * @return JsonResponse
     */
    public function list(CoinGeckoClient $coinGeckoClient): JsonResponse
    {
        return new JsonResponse($coinGeckoClient->categories()->getList());
    }

    /**
     * @param CoinGeckoClient $coinGeckoApi
     * @return JsonResponse
     */
    public function listMarket(Request $request, CoinGeckoClient $coinGeckoApi): JsonResponse
    {
        $request->validate([
            'order' => 'sometimes|required|string|in:market_cap_desc,market_cap_asc,name_desc,name_asc,market_cap_change_24h_desc,market_cap_change_24h_asc'
        ]);
        $params = $request->all();

        return new JsonResponse($coinGeckoApi->categories()->getListMarket($params));
    }
}
