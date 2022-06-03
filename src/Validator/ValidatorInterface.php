<?php

namespace App\Validator;

use App\Error\ErrorInterface;
use App\Param\UserParamsInterface;

interface ValidatorInterface
{
    public static function validate(UserParamsInterface $userParams): ?ErrorInterface;
}