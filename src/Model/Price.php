<?php

namespace App\Model;

class Price{


    public $amount;

    public $currency;

    public function __construct(float $amount, string $currency)
    {
        $this->amount = $amount;
        $this->currency = $currency;
    }
}