<?php
namespace Epzuz\BitrixExchange\Helpers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class HttpClient
{

    protected Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @throws GuzzleException
     */
    public function get(string $url, array $params = []): \Psr\Http\Message\ResponseInterface
    {
        return $this->client->request("GET", $url, $params);
    }

    /**
     * @throws GuzzleException
     */
    public function post(string $url, array $params = []): \Psr\Http\Message\ResponseInterface
    {
        return $this->client->request("POST", $url, $params);
    }
}