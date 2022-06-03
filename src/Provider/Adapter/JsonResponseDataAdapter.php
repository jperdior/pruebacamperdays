<?php

namespace App\Provider\Adapter;

use App\ProviderMockups\CampervansForAllData;
use App\Param\UserParamsInterface;
use Symfony\Component\HttpFoundation\Response;
use App\Provider\Normalizer\VehicleNormalizer;

class JsonResponseDataAdapter implements DataSourceAdapterInterface
{
    public static function getData(UserParamsInterface $userParams): array
    {
        $response = CampervansForAllData::generateData();
        return self::processJsonResponse($response);
    }

    private static function processJsonResponse(Response $response): array
    {
        $data = json_decode($response->getContent(), true);
        $vehicles = [];
        foreach ($data as $vehicleJson) {
            $availability = $vehicleJson['availability'];
            $price = $vehicleJson['total_price'];
            $currency = 'EUR';
            $vehicle = new VehicleNormalizer(
                $vehicleJson['vehicle_code'],
                $vehicleJson['vehicle_code'],
                $price,
                $currency,
                $availability
            );
            $vehicles[] = $vehicle;
        }
        return $vehicles;
    }

}