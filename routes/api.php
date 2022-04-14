<?php

use Illuminate\Support\Facades\Route;
use Epzuz\BitrixExchange\Controllers\ExchangeController;

Route::get('1c_exchange', [ExchangeController::class, 'exchange']);