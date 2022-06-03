<?php

namespace App\Provider\Adapter;

use App\ProviderMockups\RoadTravellersData;
use App\Param\UserParamsInterface;
use Symfony\Component\HttpFoundation\Response;
use App\Provider\Normalizer\VehicleNormalizer;

class XmlResponseDataAdapter implements DataSourceAdapterInterface
{
    public static function getData(UserParamsInterface $userParams): array
    {
        $response = RoadTravellersData::generatXmlResponse();
        return self::processXmlResponse($response);
    }

    private static function processXmlResponse(Response $response): array
    {
        $vehiclesXml = simplexml_load_string($response->getContent());
        $vehicles = [];
        foreach ($vehiclesXml as $vehicleXml) {
            $availability = (string)$vehicleXml->Available;
            $price = (string)$vehicleXml->TotalPrice;
            $currency = (string)$vehicleXml->TotalPrice->attributes()->currency;
            $vehicle = new VehicleNormalizer(
                (string)$vehicleXml->Code,
                (string)$vehicleXml->Code,
                $price,
                $currency,
                $availability
            );
            $vehicles[] = $vehicle;
        }
        return $vehicles;
    }

}