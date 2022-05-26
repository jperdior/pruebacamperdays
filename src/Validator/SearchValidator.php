<?php

namespace App\Validator;

use App\DataFixtures\CityFixtures;

class SearchValidator{

    public static function searchParamsAreValid(?string $startDate, ?string $endDate, ?string $cityCode): bool
    {
        if (empty($startDate) || empty($endDate)) {
            return false;
        }

        if (!self::validateDateFormat($startDate) || !self::validateDateFormat($endDate)) {
            return false;
        }

        if (!self::validateDateRange($startDate, $endDate)) {
            return false;
        }

        if (!self::validateCityCode($cityCode)) {
            return false;
        }

        return true;
    }

    private static function validateCityCode(string $cityCode): bool
    {
        return in_array($cityCode, CityFixtures::VALID_CITY_CODES);
    }


    private static function validateDateFormat(string $date, string $format = 'Y-m-d'): bool
    {
        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }

    private static function validateDateRange(string $startDate, string $endDate): bool
    {
        $startDate = new \DateTime($startDate);
        $endDate = new \DateTime($endDate);

        return $startDate < $endDate;
    }


}