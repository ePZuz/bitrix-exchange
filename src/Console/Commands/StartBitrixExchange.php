<?php
namespace Epzuz\BitrixExchange\Console\Commands;

use Epzuz\BitrixExchange\Service\BitrixService;

class StartBitrixExchange extends \Illuminate\Console\Command
{
    protected $signature = 'exchange:orders';

    protected $description = 'Start bitrix import orders';

    protected BitrixService $service;

    public function __construct()
    {

        $this->service = new BitrixService();
        parent::__construct();
    }

    /**
     * @throws \Epzuz\BitrixExchange\Exceptions\FailedBitrixRequestException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle(): int
    {
        $this->service->orders()->import();
        return 0;
    }
}