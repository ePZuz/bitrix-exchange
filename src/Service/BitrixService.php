<?php
namespace Epzuz\BitrixExchange\Controllers\Services;

use Epzuz\BitrixExchange\Helpers\HttpClient;

class BitrixService
{
    private HttpClient $http;

    public function __construct()
    {
        $this->http = new HttpClient();
    }

}