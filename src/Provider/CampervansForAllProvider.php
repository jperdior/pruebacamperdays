<?php

namespace App\Provider;

use App\Provider\ProviderInterface;
use App\Model\Vehicle;
use App\Param\UserParamsInterface;
use App\Param\UserSearchParams;
use App\Service\CurrencyConverter;
use App\Provider\Adapter\JsonResponseDataAdapter;

class CampervansForAllProvider implements ProviderInterface{

    const PROVIDER_CODE = 'campervans_4all';
    const PROVIDER_CURRENCY = 'USD';

    /** @var UserSearchParams */
    private $userParams;

    public function __construct(UserParamsInterface $userParams)
    {
        $this->userParams = $userParams;
    }


    public function search(): array{
        $data = JsonResponseDataAdapter::getData($this->userParams);
        $vehicles = $this->normalizeVehicles($data);
        return $vehicles;
    }

    public function normalizeVehicles(array $data): array{
        $vehicles = [];
        foreach($data as $element){
            /** @var VehicleNormalizer */
            $element = $element;
            $availability = $this->normalizeAvailability($element->getAvailability());
            $price = $element->getPrice();
            $vehicle = new Vehicle(
                $element->getCode(),
                $element->getCode(),
                $price,
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
