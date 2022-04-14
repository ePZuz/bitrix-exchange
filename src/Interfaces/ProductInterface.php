<?php

interface ProductInterface
{
    public function toExchange(): array;
    public function fromExchange(): array;
}