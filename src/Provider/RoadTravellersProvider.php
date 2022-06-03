<?php

namespace App\Provider;

use App\Model\Vehicle;
use App\Provider\ProviderInterface;
use App\Provider\Adapter\XmlResponseDataAdapter;
use App\Service\CurrencyConverter;
use App\Param\UserParamsInterface;
use App\Param\UserSearchParams;
use App\Provider\Normalizer\VehicleNormalizer;

class RoadTravellersProvider implements ProviderInterface{

    const PROVIDER_CODE = 'road_travellers';
    const AVAILABLE = 'Yes';
    const NOT_AVAILABLE = 'Not';

    /** @var UserSearchParams */
    private $userParams;

    public function __construct(UserParamsInterface $userParams)
    {
        $this->userParams = $userParams;
    }


    public function search(): array{
        $data = XmlResponseDataAdapter::getData($this->userParams);
        $vehicles = $this->normalizeVehicles($data);
        return $vehicles;
    }


    public function normalizeVehicles(array $data): array{
        $vehicles = [];
        foreach($data as $element){
            /** @var VehicleNormalizer */
            $element = $element;
            $availability = $this->normalizeAvailability($element->getAvailability());
            $price = $this->normalizePrice($element->getPrice(), $element->getCurrency());
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
        if($availability === self::AVAILABLE){
            return self::AVAILABLE_NORMALIZATION;
        }
        if($availability === self::NOT_AVAILABLE){
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