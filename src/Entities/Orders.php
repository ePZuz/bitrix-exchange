<?php

namespace Epzuz\BitrixExchange\Entities;

use Epzuz\BitrixExchange\DTO\Order\Order;
use Epzuz\BitrixExchange\Exceptions\FailedBitrixRequestException;
use Epzuz\BitrixExchange\Responses\BitrixResponse;
use Epzuz\BitrixExchange\Service\BitrixService;

class Orders
{
    protected BitrixService $service;
    protected bool $isZip  = false;
    protected int $fileLimit;
    protected string $version;
    protected string $orderClass;

    public function __construct(BitrixService $service, string $orderClass)
    {
        $this->service = $service;
        $this->orderClass = $orderClass;
    }


    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Epzuz\BitrixExchange\Exceptions\FailedBitrixRequestException
     */
    public function import(): void
    {
        $this->initializeImport();
        $this->startImport();
        $this->completedImport();
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Epzuz\BitrixExchange\Exceptions\FailedBitrixRequestException
     */
    protected function initializeImport(): void
    {
        $sessionId = $this->service->getSessionId();
        $response = new BitrixResponse($this->service->getClient()->get("/bitrix/admin/1c_exchange.php?type=sale&mode=init&sessid=${sessionId}&version=yes"));
        $response = $response->getResponse();
        $this->isZip = explode('=', $response[0])[1] === 'yes';
        $this->fileLimit = explode('=', $response[1])[1];
        $this->version = explode('=', $response[3])[1];
    }

    /**
     * @throws FailedBitrixRequestException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function startImport(): void
    {
        $process = true;
        while ($process === true){
            $xml = $this->getXml();
            if (count($xml->xpath('Документ'))){
                foreach ($xml->xpath('Документ') as $item) {
                    $order = new Order($item);
                    $this->orderClass::fromExchange($order);
                }
            }else{
                $process = false;
            }
        }

    }

    /**
     * @throws FailedBitrixRequestException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function completedImport(): void
    {
        $sessionId = $this->service->getSessionId();
        $response = new BitrixResponse($this->service->getClient()->get("/bitrix/admin/1c_exchange.php?type=sale&mode=success&sessid=${sessionId}"));
        if ($response->getResponse()[0] !== 'success'){
            throw new FailedBitrixRequestException('Не завершен импорт!');
        }
    }

    /**
     * @throws FailedBitrixRequestException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function getXml(): \SimpleXMLElement|bool{
        $sessionId = $this->service->getSessionId();
        $version = $this->version;
        $response = $this->service->getClient()->get("/bitrix/admin/1c_exchange.php?type=sale&mode=query&sessid=${sessionId}&version=${version}");
        if ($response->getStatusCode() !== 200){
            throw new FailedBitrixRequestException();
        }
        return simplexml_load_string($response->getBody()->getContents());
    }
}