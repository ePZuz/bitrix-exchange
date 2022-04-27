<?php
namespace Epzuz\BitrixExchange\Interfaces;

use Epzuz\BitrixExchange\DTO\Order\Order;

interface ProductInterface
{
    public function toExchange(): array;
    public static function fromExchange(Order $order);
}