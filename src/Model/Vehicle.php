<?php

namespace App\Model;

use App\Model\Price;

class Vehicle{

    public $code;

    public $model;

    public $price;

    public $availability;

    public $provider;

    public $station;

    public function __construct(string $code, string $model, float $price, string $currency, string $availability, string $provider, string $station)
    {
        $this->code = $code;
        $this->model = $model;
        $this->price = new Price($price, $currency);
        $this->availability = $availability;
        $this->provider = $provider;
        $this->station = $station;
    }

}