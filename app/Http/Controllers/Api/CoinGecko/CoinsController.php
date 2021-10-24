<?php

namespace App\Http\Controllers\Api\CoinGecko;

use App\Http\Controllers\Controller;
use App\Services\CoinGeckoApi\CoinGeckoClient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class CoinsController extends Controller
{
    /**
     * List all supported coins id, name and symbol (no pagination required)
     * @param CoinGeckoClient $coinGeckoApi
     * @return JsonResponse
     */
    public function list(CoinGeckoClient $coinGeckoApi): JsonResponse
    {
        return new JsonResponse($coinGeckoApi->coins()->getList());
    }

    /**
     * List all supported coins price, market cap, volume, and market related data
     * @param Request $request
     * @param CoinGeckoClient $coinGeckoApi
     * @return JsonResponse
     */
    public function markets(Request $request, CoinGeckoClient $coinGeckoApi): JsonResponse
    {
        $request->validate([
            'vs_currency' => 'required|string',
            'ids' => 'sometimes|required|string',
            'category' => 'sometimes|required|string',
            'order' => 'sometimes|required|string|in:market_cap_desc,gecko_desc,gecko_asc,market_cap_asc,market_cap_desc,volume_asc,volume_desc,id_asc,id_desc',
            'per_page' => 'sometimes|required|numeric|between:1,250',
            'page' => 'sometimes|required|numeric',
            'sparkline' => 'sometimes|required|boolean',
            'price_change_percentage' => 'sometimes|required|string'
        ]);

        $params = $request->all();
        $currency = Arr::pull($params, 'vs_currency');
        $data = $coinGeckoApi->coins()->getMarkets($currency, $params);
        return new JsonResponse($data);
    }

    /**
     * Get current data (name, price, market, ... including exchange tickers) for a coin.
     * IMPORTANT:
     * Ticker object is limited to 100 items, to get more tickers, use `/coins/{id}/tickers`
     * Ticker `is_stale` is `true` when ticker that has not been updated/unchanged from the exchange for a while.
     * Ticker `is_anomaly` is `true` if ticker's price is outliered by our system.
     * You are responsible for managing how you want to display these information (e.g. footnote, different background, change opacity, hide)
     */
    public function show(Request $request, $id, CoinGeckoClient $coinGeckoClient)
    {
        $request->validate([
            'localization' => 'sometimes|required|boolean',
            'tickers' => 'sometimes|required|boolean',
            'market_data' => 'sometimes|required|boolean',
            'community_data' => 'sometimes|required|boolean',
            'developer_data' => 'sometimes|required|boolean',
            'sparkline' => 'sometimes|required|boolean',
        ]);

        $params = $request->all();
        $data = $coinGeckoClient->coins()->getCoin($id, $params);
        return new JsonResponse($data);
    }
}
