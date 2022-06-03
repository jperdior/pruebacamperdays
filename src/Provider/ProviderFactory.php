<?php

namespace App\Provider;

use App\Param\UserSearchParams;
use App\Provider\RentalCampersProvider;
use App\Provider\RoadTravellersProvider;
use App\Provider\CampervansForAllProvider;

class ProviderFactory{

    public static function create(UserSearchParams $userSearchParams):array{
        $providers = [
            new RentalCampersProvider($userSearchParams),
            new RoadTravellersProvider($userSearchParams),
            new CampervansForAllProvider($userSearchParams)
        ];
        return $providers;
    }

}