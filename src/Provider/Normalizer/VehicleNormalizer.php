<?php

namespace App\Provider\Normalizer;

class VehicleNormalizer{

    private $code;
    private $model;
    private $price;
    private $currency;
    private $availability;

    public function __construct(string $code, string $model, string $price, string $currency, string $availability)
    {
        $this->code = $code;
        $this->model = $model;
        $this->price = $price;
        $this->currency = $currency;
        $this->availability = $availability;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getAvailability(): string
    {
        return $this->availability;
    }

}