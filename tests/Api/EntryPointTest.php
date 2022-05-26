<?php

namespace App\Tests\Api;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;

class EntryPointTest extends ApiTestCase
{
    public function testAvailability(): void
    {
        $response = static::createClient()->request('GET', '/search?cityCode=LON&pickUpDate=2021-10-10&dropOffDate=2021-11-10');

        $this->assertResponseIsSuccessful();
    }
}
