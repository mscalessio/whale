<?php

namespace App\Services\CoinGeckoApi\Api;

class Categories extends Api
{
    /**
     * @return array
     * @throws Exception
     */
    public function getList(): array
    {
        return $this->get('/coins/categories/list');
    }

    public function getListMarket(array $params = []): array
    {
        return $this->get('/coins/categories', $params);
    }
}
