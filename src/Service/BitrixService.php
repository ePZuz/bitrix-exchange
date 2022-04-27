<?php

namespace Epzuz\BitrixExchange\Service;

use Epzuz\BitrixExchange\Configs\BitrixConfig;
use Epzuz\BitrixExchange\Entities\Orders;
use Epzuz\BitrixExchange\Exceptions\FailedBitrixRequestException;
use Epzuz\BitrixExchange\Helpers\HttpClient;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

class BitrixService
{

    protected string $bitrixSessionId;

    protected string $phpSessionId;

    protected HttpClient $http;

    protected BitrixConfig $bitrixConfig;


    /**
     * @throws FailedBitrixRequestException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function __construct(BitrixConfig $config)
    {
        $this->bitrixConfig = $config;
        $this->http = $this->createClient();
        $this->receiveSessionId();
    }

    #[ArrayShape(['Authorization' => "string[]", 'Cookie' => "mixed"])]
    protected function getHeaders(): array
    {
        $headers = [
            'Authorization' => ['Basic ' . $this->bitrixConfig->getAuthKey()],
        ];
        if (!empty($this->phpSessionId) && !empty($this->bitrixSessionId)){
            $sessionId = $this->phpSessionId;
            $headers['Cookie'] = ["PHPSESSID=${sessionId}"];
        }
        return $headers;
    }

    protected function createClient(): HttpClient
    {
        return new HttpClient([
            'base_uri' => $this->bitrixConfig->getUrl(),
            'headers' => $this->getHeaders()
        ]);
    }


    #[Pure]
    public function orders(string $orderClass): Orders
    {
        return new Orders($this, $orderClass);
    }

    /**
     * @throws FailedBitrixRequestException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function receiveSessionId(): void
    {
        $result = $this->http->get('/bitrix/admin/1c_exchange.php?type=sale&mode=checkauth');
        if ($result->getStatusCode() === 200){
            $body = $result->getBody()->getContents();
            $response = explode(PHP_EOL, $body);
            if ($response[0] !== 'success'){
                throw new FailedBitrixRequestException();
            }
            $this->phpSessionId = $response[2];
            $this->bitrixSessionId = explode('=', $response[3])[1];
            $this->http = $this->createClient();
        }
    }

    public function getSessionId(): string
    {
        return $this->bitrixSessionId;
    }

    public function getClient(): HttpClient
    {
        return $this->http;
    }

}