<?php
namespace Epzuz\BitrixExchange\Interfaces;

interface ProductInterface
{
    public function toExchange(): array;
    public function fromExchange(): array;
}