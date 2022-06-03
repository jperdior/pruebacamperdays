<?php


namespace App\Service;

use App\Provider\RentalCampersProvider;
use App\Provider\RoadTravellersProvider;
use App\Provider\CampervansForAllProvider;
use App\Param\UserSearchParams;
use App\Provider\ProviderFactory;

class Inventory{

    public static function search(string $cityCode, string $pickUpDate, string $dropOffDate):array{
        $userSearchParams = new UserSearchParams($cityCode, $pickUpDate, $dropOffDate);
        $providers = ProviderFactory::create($userSearchParams);
        $finalVehicles = [];
        foreach($providers as $provider){
            $vehicles = $provider->search();
            if(!empty($vehicles)){
                $finalVehicles = array_merge($finalVehicles, $vehicles);
            }
        }
        return $finalVehicles;
    }



}