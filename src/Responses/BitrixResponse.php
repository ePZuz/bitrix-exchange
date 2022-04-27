<?php
namespace Epzuz\BitrixExchange\Responses;

use Epzuz\BitrixExchange\Exceptions\FailedBitrixRequestException;
use GuzzleHttp\Psr7\Response;

class BitrixResponse
{
    private Response $response;
    protected ?string $bitrixEncoding;

    public function __construct(Response $response)
    {
        $this->response = $response;
        $this->bitrixEncoding = config('exchange.bitrix_encoding');
    }

    /**
     * @throws FailedBitrixRequestException
     */
    public function getResponse(): bool|array
    {
        if ($this->response->getStatusCode() !== 200){
            throw new FailedBitrixRequestException();
        }
        $body = $this->response->getBody()->getContents();
        if ($this->needEncoding()){
            $body = iconv($this->bitrixEncoding, 'UTF-8', $body);
        }
        $body = explode(PHP_EOL, $body);
        if ($body[0] === 'failure'){
            throw new FailedBitrixRequestException($body[1]);
        }
        return $body;
    }

    protected function needEncoding(): bool
    {
        return $this->bitrixEncoding !== 'UTF-8';
    }
}