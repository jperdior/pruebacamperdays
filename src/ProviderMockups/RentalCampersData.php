<?php

namespace App\ProviderMockups;

use App\DataFixtures\VehicleGenerator;

class RentalCampersData{

    const AVAILABLE = 'available';
    const NOT_AVAILABLE = 'not_available';
    const ON_REQUEST = 'on_request';
    const PROVIDER_CODE = 'rental_campers';

    public static function generateData(): array
    {
        $vehicleGenerator = new VehicleGenerator(self::PROVIDER_CODE);
        $vehicles = $vehicleGenerator->getRandomDummyVehicles(10);
        return $vehicles;
    }

}