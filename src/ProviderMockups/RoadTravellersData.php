<?php

namespace App\ProviderMockups;

use App\DataFixtures\VehicleGenerator;
use Symfony\Component\HttpFoundation\Response;

class RoadTravellersData{

    const AVAILABLE = 'Yes';
    const NOT_AVAILABLE = 'Not';
    const PROVIDER_CODE = 'road_travellers';

    public static function generatXmlResponse(): Response
    {
        $vehicleGenerator = new VehicleGenerator(self::PROVIDER_CODE);
        $vehicles = $vehicleGenerator->getRandomDummyVehicles(10);
        $xml = new \SimpleXMLElement('<Vehicles/>');
        foreach ($vehicles as $vehicle) {
            $xmlVehicle = $xml->addChild('Vehicle');
            $xmlVehicle->addChild('Code', $vehicle['code']);
            $xmlVehicle->addChild('TotalPrice', $vehicle['price'])->addAttribute('currency', 'EUR');
            $xmlVehicle->addChild('Available', $vehicle['available']);
        }
        return new Response($xml->asXML());

    }

}