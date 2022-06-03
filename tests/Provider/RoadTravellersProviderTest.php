<?php

namespace App\Validator;

use PHPUnit\Framework\TestCase;
use App\Provider\RoadTravellersProvider;
use App\Param\UserSearchParams;
use App\Model\Vehicle;

class RoadTravellersProviderTest extends TestCase
{
    public function testValidVehicles(): void
    {
        $roadTravellerProvider = new RoadTravellersProvider(new UserSearchParams('LON','2019-01-01', '2019-01-02'));
        $vehicles = $roadTravellerProvider->search();
        foreach($vehicles as $vehicle) {
            $this->assertEquals($vehicle::class,Vehicle::class);
            $this->testValidVehicle($vehicle);
        }
    }

    private function testValidVehicle(Vehicle $vehicle): void
    {
        $this->assertTrue(!empty($vehicle->code));
        $this->assertTrue(!empty($vehicle->model));
        $this->assertTrue(!empty($vehicle->price->amount));
        $this->assertTrue(!empty($vehicle->price->currency));
        $this->assertTrue(!empty($vehicle->availability));
        $this->assertTrue(
            $vehicle->availability === 'available' ||
            $vehicle->availability === 'not_available' ||
            $vehicle->availability === 'on_request');
        $this->assertTrue(!empty($vehicle->provider));
        $this->assertTrue(!empty($vehicle->station));
    }
}
