<?php
namespace Epzuz\BitrixExchange\DTO\Order;

use Illuminate\Support\Collection;

class Partner
{
    public string $id;

    public ?string $title;

    public ?string $fullTitle;

    public ?string $lastName;

    public ?string $name;

    public ?string $address;

    public ?string $role;

    /**
     * @var Collection<Contact>|null
     */
    public ?Collection $contacts;

    public function __construct(\SimpleXMLElement $element)
    {
        $this->id = (string) $element->Ид;
        $this->title = (string) $element->Наименование;
        $this->fullTitle = (string) $element->ПолноеНаименование;
        $this->lastName = (string) $element->Фамилия;
        $this->name = (string) $element->Имя;
        $this->address = (string) $element->АдресРегистрации->Представление;
        $this->role = $element->Роль;
        if ($element->Контакты->count() > 0){
            $this->contacts = collect();
            foreach ($element->Контакты as $contact) {
                $this->contacts[] = new Contact($contact->Контакт);
            }
        }
    }
}