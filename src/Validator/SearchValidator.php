<?php

namespace App\Validator;

use App\Validator\ValidatorInterface;
use App\DataFixtures\CityFixtures;
use App\Error\ErrorInterface;
use App\Error\Search\DateEmptyError;
use App\Error\Search\DateInvalidFormatError;
use App\Error\Search\DateRangeError;
use App\Error\Search\CityError;
use App\Param\UserParamsInterface;
use App\Param\UserSearchParams;


class SearchValidator implements ValidatorInterface{

    public static function validate(UserParamsInterface $searchParams): ?ErrorInterface
    {
        /** @var UserSearchParams */
        $searchParams = $searchParams;
        $startDate = $searchParams->getStartDate();
        $endDate = $searchParams->getEndDate();
        $cityCode = $searchParams->getCity();

        if (empty($startDate) || empty($endDate)) {
            return new DateEmptyError();
        }

        if (!self::validateDateFormat($startDate) || !self::validateDateFormat($endDate)) {
            return new DateInvalidFormatError();
        }

        if (!self::validateDateRange($startDate, $endDate)) {
            return new DateRangeError();
        }

        if (!self::validateCityCode($cityCode)) {
            return new CityError();
        }
        return null;
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