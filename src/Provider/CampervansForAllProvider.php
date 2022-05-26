<?php

namespace App\Provider;

use App\Provider\ProviderInterface;
use App\ProviderMockups\CampervansForAllData;
use App\Model\Vehicle;
use App\Service\CurrencyConverter;

class CampervansForAllProvider implements ProviderInterface{

    const PROVIDER_CODE = 'campervans_4all';
    const PROVIDER_CURRENCY = 'USD';

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
        $data = $this->getData();
        $vehicles = $this->normalizeVehicles($data);
        return $vehicles;
    }

    public function getData(){
        return CampervansForAllData::generateData();
    }

    public function normalizeVehicles($data): array{
        $data = json_decode($data->getContent(), true);

        $vehicles = [];
        foreach($data as $vehicle){
            $price = CurrencyConverter::convertUsdToEur($vehicle['total_price']);
            $availability = $this->normalizeAvailability($vehicle['availability']);
            $vehicle = new Vehicle(
                $vehicle['vehicle_code'],
                $vehicle['vehicle_code'],
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
        if($availability == 'Available'){
            return self::AVAILABLE_NORMALIZATION;
        }
        if($availability == 'NotAvailable'){
            return self::NOT_AVAILABLE_NORMALIZATION;
        }
        if($availability == 'OnRequest'){
            return self::ON_REQUEST_NORMALIZATION;
        }
    }

}
