<?php

namespace App\Provider\Adapter;

use App\Param\UserParamsInterface;

interface DataSourceAdapterInterface
{
    public static function getData(UserParamsInterface $userParams): array;

}