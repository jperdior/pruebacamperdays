<?php

namespace App\Validator;

use PHPUnit\Framework\TestCase;
use App\Validator\SearchValidator;

class SearchValidatorTest extends TestCase
{
    public function testValidateParams(): void
    {
        // ALL PARAMETERS ARE CORRECT
        $this->assertTrue(SearchValidator::searchParamsAreValid('2021-10-10', '2021-11-10','LON'));
        // CITY INVALID
        $this->assertFalse(SearchValidator::searchParamsAreValid('2021-10-10', '2021-11-10','NAR'));
        // DATE RANGE INVALID
        $this->assertFalse(SearchValidator::searchParamsAreValid('2021-10-10', '2021-09-10','LON'));
    }
}
