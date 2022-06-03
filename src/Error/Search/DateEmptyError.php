<?php

namespace App\Error\Search;

use App\Error\ErrorInterface;

class DateEmptyError implements ErrorInterface
{

    const MESSAGE = 'Please provide a start date and an end date.';
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