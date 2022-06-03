<?php

namespace App\Validator;

use PHPUnit\Framework\TestCase;
use App\Validator\SearchValidator;
use App\Error\ErrorInterface;
use App\Param\UserSearchParams;

class SearchValidatorTest extends TestCase
{
    public function testCorrectParameters(): void
    {
        $userParams = new UserSearchParams('LON', '2021-10-10', '2021-11-10');
        $paramValidationResult = SearchValidator::validate($userParams);
        $this->assertTrue($paramValidationResult === null);
    }

    public function testIncorrectCity(): void
    {
        $userParams = new UserSearchParams('NAR', '2021-10-10', '2021-11-10');
        $paramValidationResult = SearchValidator::validate($userParams);
        $this->assertTrue($paramValidationResult instanceof ErrorInterface);
        $this->assertEquals(400, $paramValidationResult->getCode());
        $this->assertEquals('City code is invalid.', $paramValidationResult->getMessage());
    }

    public function testIncorrectDateFormat(): void
    {
        $userParams = new UserSearchParams('LON', '10-10-2021', '2021-11-10');
        $paramValidationResult = SearchValidator::validate($userParams);
        $this->assertTrue($paramValidationResult instanceof ErrorInterface);
        $this->assertEquals(400, $paramValidationResult->getCode());
        $this->assertEquals('Date format is invalid.', $paramValidationResult->getMessage());
    }

    public function testIncorrectDateRange(): void
    {
        $userParams = new UserSearchParams('LON', '2021-10-10', '2021-09-10');
        $paramValidationResult = SearchValidator::validate($userParams);
        $this->assertTrue($paramValidationResult instanceof ErrorInterface);
        $this->assertEquals(400, $paramValidationResult->getCode());
        $this->assertEquals('The start date must be before the end date.', $paramValidationResult->getMessage());
    }

    public function testEmptyDate(): void
    {
        $userParams = new UserSearchParams('LON', '', '');
        $paramValidationResult = SearchValidator::validate($userParams);
        $this->assertTrue($paramValidationResult instanceof ErrorInterface);
        $this->assertEquals(400, $paramValidationResult->getCode());
        $this->assertEquals('Please provide a start date and an end date.', $paramValidationResult->getMessage());
    }
}
