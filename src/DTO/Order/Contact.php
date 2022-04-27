<?php

namespace Epzuz\BitrixExchange\DTO\Order;

class Contact
{
    public string $type;
    public string $value;

    public function __construct(\SimpleXMLElement $element)
    {
        $this->type = (string) $element->Тип;
        $this->value = (string) $element->Значение;
    }
}