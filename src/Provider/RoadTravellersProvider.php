<?php

namespace App\Provider;

use App\Model\Vehicle;
use App\Provider\ProviderInterface;
use App\ProviderMockups\RoadTravellersData;
use Symfony\Component\HttpFoundation\Response;
use App\Service\CurrencyConverter;

class RoadTravellersProvider implements ProviderInterface{

    const PROVIDER_CODE = 'road_travellers';

    private $cityCode;
    private $startDate;
    private $endDate;

    public function __construct(string $cityCode, \DateTime $startDate, \DateTime $endDate)
    {
        $this->cityCode = $cityCode;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function search(): array{
        $response = $this->getData();
        $vehicles = $this->normalizeVehicles($response);
        return $vehicles;
    }

    public function getData(): Response{
        return RoadTravellersData::generatXmlResponse();
    }

    public function normalizeVehicles($data): array{
        $vehiclesXml = simplexml_load_string($data->getContent());
        $vehicles = [];
        foreach($vehiclesXml as $vehicleXml){
            $availability = $this->normalizeAvailability((string)$vehicleXml->Available);
            $price = $this->normalizePrice((string)$vehicleXml->TotalPrice,(string)$vehicleXml->TotalPrice->attributes()->currency);
            $vehicle = new Vehicle(
                (string)$vehicleXml->Code,
                (string)$vehicleXml->Code,
                $price,
                'EUR',
                $availability,
                self::PROVIDER_CODE,
                $this->cityCode
            );
            $vehicles[] = $vehicle;
        }
        return $vehicles;
    }

    private function normalizeAvailability(string $availability): string{
        if($availability == 'Yes'){
            return self::AVAILABLE_NORMALIZATION;
        }
        if($availability == 'Not'){
            return self::NOT_AVAILABLE_NORMALIZATION;
        }
    }

    private function normalizePrice(string $amount, string $currency){
        if($currency == 'USD'){
            return CurrencyConverter::convertUsdToEur($amount);
        }
        return $amount;
    }

}