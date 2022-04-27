<?php

namespace Epzuz\BitrixExchange\Providers;

use Epzuz\BitrixExchange\Console\Commands\StartBitrixExchange;
use Illuminate\Support\ServiceProvider;

class BitrixExchangeServiceProvider extends ServiceProvider
{
    public function boot(){
        if ($this->app->runningInConsole()){

//            $this->commands([
//                StartBitrixExchange::class,
//            ]);

//            $this->publishes([
//                __DIR__ . '/../../config/exchange.php' => config_path('exchange.php'),
//            ]);
        }
    }
}