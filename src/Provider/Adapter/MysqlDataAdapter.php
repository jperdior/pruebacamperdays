<?php

namespace App\Provider\Adapter;

use App\Provider\Adapter\DataSourceAdapterInterface;
use App\ProviderMockups\RentalCampersData;
use App\Provider\Normalizer\VehicleNormalizer;
use App\Param\UserParamsInterface;

class MysqlDataAdapter implements DataSourceAdapterInterface
{
    public static function getData(UserParamsInterface $userParams): array
    {
        $data = RentalCampersData::generateData();
        return self::processMysqlDataSet($data);
    }

    private static function processMysqlDataSet(array $data): array
    {
        $vehicles = [];
        foreach ($data as $vehicleMysql) {
            $availability = $vehicleMysql['availability'];
            $price = $vehicleMysql['price'];
            $currency = 'EUR';
            $vehicle = new VehicleNormalizer(
                $vehicleMysql['code'],
                $vehicleMysql['code'],
                $price,
                $currency,
                $availability
            );
            $vehicles[] = $vehicle;
        }
        return $vehicles;
    }


}
