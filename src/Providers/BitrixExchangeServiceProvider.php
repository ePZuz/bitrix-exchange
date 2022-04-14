<?php

namespace Epzuz\BitrixExchange\Providers;

use Illuminate\Support\ServiceProvider;

class BitrixExchangeServiceProvider extends ServiceProvider
{
    public function boot(){
        if ($this->app->runningInConsole()){
            $this->publishes([
                __DIR__ . '/../../config/exchange.php' => config_path('exchange.php'),
            ]);
        }
    }
}