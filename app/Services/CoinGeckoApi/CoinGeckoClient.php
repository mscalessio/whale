<?php

namespace App\Services\CoinGeckoApi;

use App\Services\CoinGeckoApi\Api\Categories;
use App\Services\CoinGeckoApi\Api\Coins;
use App\Services\CoinGeckoApi\Api\Ping;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Exception;

class CoinGeckoClient
{
    protected const BASE_URI = 'https://api.coingecko.com';
    /**
     * @var Client
     */
    private $client;

    /** @var ResponseInterface|null */
    protected $lastResponse;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri'        => self::BASE_URI,
            'timeout'         => 30,
            'allow_redirects' => false,
            //'proxy'           => '192.168.16.1:10'
        ]);
    }

    public function getHttpClient(): Client
    {
        return $this->client;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function ping(): array
    {
        return (new Ping($this))->ping();
    }

    public function coins(): Coins
    {
        return new Coins($this);
    }

    public function categories(): Categories
    {
        return new Categories($this);
    }

    /**
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function setLastResponse(ResponseInterface $response): ResponseInterface
    {
        return $this->lastResponse = $response;
    }

    /**
     * @return ResponseInterface|null
     */
    public function getLastResponse(): ?ResponseInterface
    {
        return $this->lastResponse;
    }
}
