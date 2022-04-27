<?php

namespace Epzuz\BitrixExchange\DTO\Order;

class Discount
{
    public string $name;

    public string $sum;

    public bool $discounted;

    public function __construct(\SimpleXMLElement $element)
    {
        $this->name = (string) $element->Наименование;
        $this->sum = (float) $element->Сумма;
        $this->discounted = (bool) $element->УчтеноВСумме;
    }
}