<?php

namespace App\Error\Search;

use App\Error\ErrorInterface;

class CityError implements ErrorInterface
{

    const MESSAGE = 'City code is invalid.';
    const CODE = 400;

    public function __construct()
    {
        return;
    }

    public function getMessage(): string
    {
        return self::MESSAGE;
    }

    public function getCode(): int
    {
        return self::CODE;
    }
}