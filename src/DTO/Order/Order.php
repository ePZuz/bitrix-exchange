<?php
namespace Epzuz\BitrixExchange\DTO\Order;

use Carbon\Carbon;
use Illuminate\Support\Collection;

class Order
{
    public int $id;

    public int $number;

    public ?Carbon $date;

    public ?string $operation;

    public ?string $role;

    public ?string $currency;

    public ?string $exchangeRate;

    public ?float $sum;

    public ?string $time;

    public ?string $comment;

    public ?Collection $properties;

    public ?Collection $products;

    public ?Collection $partners;


    public function __construct(\SimpleXMLElement $document)
    {
        $this->id = (int) $document->Ид;
        $this->number = (int) $document->Номер;
        $this->date = Carbon::parse((string) $document->Дата);
        $this->operation = (string) $document->ХозОперация;
        $this->role = (string) $document->Роль;
        $this->currency = (string) $document->Валюта;
        $this->exchangeRate = (string) $document->Курс;
        $this->sum = (float) $document->Сумма;
        $this->time = (string) $document->Время;
        $this->comment = (string) $document->Комментарий;
        if ($document->Контрагенты->count() > 0){
            $this->partners = collect();
            foreach ($document->Контрагенты as $partner) {
                $this->partners[] = new Partner($partner->Контрагент);
            }
        }
        if ($document->Товары->count() > 0){
            $this->products = collect();
            foreach ($document->Товары as $product) {
                $this->products[] = new Product($product->Товар);
            }
        }

        if ($document->ЗначенияРеквизитов->count() > 0){
            $this->properties = collect();
            foreach ($document->ЗначенияРеквизитов->ЗначениеРеквизита as $property) {
                $this->properties[] = new Property($property);
            }
        }
    }
}