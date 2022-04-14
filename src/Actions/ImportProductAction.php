<?php

class ImportProductAction
{
    protected ProductInterface $product;

    public function __construct(ProductInterface $product)
    {
        $this->product = $product;
    }

    public function execute(){

    }
}