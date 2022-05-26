<?php

namespace App\Service;

class CurrencyConverter{

    public static function convertUsdToEur(float $usd): float{
        return $usd * 0.9;
    }
}