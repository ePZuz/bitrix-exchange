<?php

namespace Epzuz\BitrixExchange\Configs;

class BitrixConfig
{
    protected string $url;
    protected string $authKey;
    protected string $encoding;

    public function __construct($url, $authKey)
    {
        $this->url = $url;
        $this->authKey = $authKey;
    }

    public static function fromAuthKey($url, $authKey): BitrixConfig
    {
        return new self($url, $authKey);
    }

    public static function fromLogin($url, $login, $password): BitrixConfig
    {
        return new self($url, base64_encode("${login}:${password}"));
    }

    public function setEncoding($encoding): BitrixConfig
    {
        $this->encoding = $encoding;
        return $this;
    }

    public function getEncoding(): string
    {
        return $this->encoding;
    }


    public function getUrl(): string
    {
        return $this->url;
    }


    public function getAuthKey(): string
    {
        return $this->authKey;
    }


}