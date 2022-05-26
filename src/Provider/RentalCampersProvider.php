<?php

namespace App\Provider;

use App\Model\Vehicle;
use App\Provider\ProviderInterface;
use App\ProviderMockups\RentalCampersData;
use Symfony\Component\HttpFoundation\Response;

class RentalCampersProvider implements ProviderInterface{

    const PROVIDER_CODE = 'rental_campers';

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
        return RentalCampersData::generateData();
    }

    public function normalizeVehicles($data): array{
        $vehicles = [];
        foreach($data as $vehicle){
            $availability = $this->normalizeAvailability($vehicle['availability']);
            $vehicle = new Vehicle(
                $vehicle['code'],
                $vehicle['code'],
                $vehicle['price'],
                $vehicle['currency'],
                $availability,
                self::PROVIDER_CODE,
                $this->cityCode
            );
            $vehicles[] = $vehicle;
        }
        return $vehicles;
    }

    private function normalizeAvailability(string $availability): string{
        if($availability == 'available'){
            return self::AVAILABLE_NORMALIZATION;
        }
        if($availability == 'not_available'){
            return self::NOT_AVAILABLE_NORMALIZATION;
        }
        if($availability == 'on_request'){
            return self::ON_REQUEST_NORMALIZATION;
        }
    }

}