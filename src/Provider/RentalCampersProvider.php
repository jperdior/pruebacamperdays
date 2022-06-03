<?php

namespace App\Provider;

use App\Model\Vehicle;
use App\Param\UserParamsInterface;
use App\Param\UserSearchParams;
use App\Provider\ProviderInterface;
use App\Provider\Adapter\MysqlDataAdapter;
use App\Provider\Normalizer\VehicleNormalizer;

class RentalCampersProvider implements ProviderInterface{

    const PROVIDER_CODE = 'rental_campers';

    /** @var UserSearchParams */
    private $userParams;

    public function __construct(UserParamsInterface $userParams)
    {
        $this->userParams = $userParams;
    }

    public function search(): array{
        $data = MysqlDataAdapter::getData($this->userParams);
        $vehicles = $this->normalizeVehicles($data);
        return $vehicles;
    }


    public function normalizeVehicles($data): array{
        $vehicles = [];
        /** @var VehicleNormalizer */
        foreach($data as $vehicle){
            $availability = $this->normalizeAvailability($vehicle->getAvailability());
            $vehicle = new Vehicle(
                $vehicle->getCode(),
                $vehicle->getCode(),
                $vehicle->getPrice(),
                'EUR',
                $availability,
                self::PROVIDER_CODE,
                $this->userParams->getCity()
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