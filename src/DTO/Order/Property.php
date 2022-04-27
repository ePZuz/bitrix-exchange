<?php
namespace Epzuz\BitrixExchange\DTO\Order;

class Property
{
    public string $name;

    public string $value;

    public function __construct(\SimpleXMLElement $element)
    {
        $this->name = (string) $element->Наименование;
        $this->value = (string) $element->Значение;
    }
}