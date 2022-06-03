<?php

namespace App\Error\Search;

use App\Error\ErrorInterface;

class DateRangeError implements ErrorInterface
{

    const MESSAGE = 'The start date must be before the end date.';
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