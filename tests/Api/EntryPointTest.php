<?php

namespace App\Tests\Api;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;

class EntryPointTest extends ApiTestCase
{
    public function testAvailability(): void
    {
        $response = static::createClient()->request('GET', '/search?cityCode=LON&pickUpDate=2021-10-10&dropOffDate=2021-11-10');

        $this->assertResponseIsSuccessful();

        /**
         * TODO: check the content of the response. As the data is created randomly it should be tested with regex.
         * Ideally I would create a test database with real availabilities and a fixed XML and Json so I could compare different
         * query parameters knowing what the exact response should be in each case  */
    }
}
