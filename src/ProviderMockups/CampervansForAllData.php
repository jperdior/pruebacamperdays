<?php

namespace App\ProviderMockups;

use App\DataFixtures\VehicleGenerator;
use Symfony\Component\HttpFoundation\JsonResponse;

class CampervansForAllData{

    const AVAILABLE = 'available';
    const NOT_AVAILABLE = 'not_available';
    const ON_REQUEST = 'on_request';
    const PROVIDER_CODE = 'campervans_4all';

    public static function generateData(): JsonResponse
    {
        $vehicleGenerator = new VehicleGenerator(self::PROVIDER_CODE);
        $vehicles = $vehicleGenerator->getRandomDummyVehicles(10);
        return new JsonResponse($vehicles);
    }

}