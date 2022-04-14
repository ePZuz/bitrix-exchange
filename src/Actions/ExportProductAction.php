<?php

namespace Epzuz\BitrixExchange\Actions;


use Epzuz\BitrixExchange\Interfaces\ProductInterface;

class ExportProductAction
{
    protected ProductInterface $product;

    public function __construct(ProductInterface $product)
    {
        $this->product = $product;
    }

    public function execute(){

    }
}