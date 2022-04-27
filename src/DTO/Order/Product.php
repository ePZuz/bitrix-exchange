<?php
namespace Epzuz\BitrixExchange\DTO\Order;

use Illuminate\Support\Collection;

class Product
{
    public string $id;

    public ?int $catalogId;

    public ?string $name;

    public ?string $measureUnit;

    public ?float $price;

    public ?float $quantity;

    public ?float $sum;

    public ?Collection $discounts;

    public ?Collection $properties;

    public function __construct(\SimpleXMLElement $element)
    {
        $this->id = (string) $element->Ид;
        $this->catalogId = (int) $element->ИдКаталога;
        $this->name = (string) $element->Наименование;
        $this->measureUnit = (string) $element->БазоваяЕдиница;
        $this->price = (float) $element->ЦенаЗаЕдиницу;
        $this->quantity = (float) $element->Количество;
        $this->sum = (float) $element->Сумма;
        if ($element->Скидки->count() > 0){
            $this->discounts = collect();
            foreach ($element->Скидки as $discount) {
                $this->discounts[] = new Discount($discount->Скидка);
            }
        }
        if ($element->ЗначенияРеквизитов->count() > 0){
            $this->properties = collect();
            foreach ($element->ЗначенияРеквизитов->ЗначениеРеквизита as $property) {
                $this->properties[] = new Property($property);
            }
        }
    }
}