<?php

namespace App\Error;


interface ErrorInterface
{
    public function getMessage(): string;
    public function getCode(): int;
}