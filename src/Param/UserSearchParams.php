<?php

namespace App\Param;

use App\Param\UserParamsInterface;

class UserSearchParams implements UserParamsInterface
{
    private $city;
    private $startDate;
    private $endDate;

    public function __construct(
        string $city,
        string $startDate,
        string $endDate
    ) {
        $this->city = $city;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getStartDate(): string
    {
        return $this->startDate;
    }

    public function getEndDate(): string
    {
        return $this->endDate;
    }
}