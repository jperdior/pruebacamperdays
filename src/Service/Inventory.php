<?php


namespace App\Service;

use App\Provider\RentalCampersProvider;
use App\Provider\RoadTravellersProvider;
use App\Provider\CampervansForAllProvider;

class Inventory{

    public static function search(string $cityCode, \DateTime $pickUpDate, \DateTime $dropOffDate):array{
        $finalVehicles = [];
        $rentalCampersProvider = new RentalCampersProvider($cityCode, $pickUpDate, $dropOffDate);
        $rentalCampersVehicles = $rentalCampersProvider->search();
        if(!empty($rentalCampersVehicles)){
            $finalVehicles = array_merge($finalVehicles, $rentalCampersVehicles);
        }
        $roadTravellersProvider = new RoadTravellersProvider($cityCode, $pickUpDate, $dropOffDate);
        $roadTravellersVehicles = $roadTravellersProvider->search();
        if(!empty($roadTravellersVehicles)){
            $finalVehicles = array_merge($finalVehicles, $roadTravellersVehicles);
        }
        $campervansForAllProvider = new CampervansForAllProvider($cityCode, $pickUpDate, $dropOffDate);
        $campervansForAllVehicles = $campervansForAllProvider->search();
        if(!empty($campervansForAllVehicles)){
            $finalVehicles = array_merge($finalVehicles, $campervansForAllVehicles);
        }

        return $finalVehicles;
    }



}