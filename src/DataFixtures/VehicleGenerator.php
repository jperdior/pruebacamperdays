<?php

namespace App\DataFixtures;

use App\DataFixtures\RandomGenerator;

class VehicleGenerator{

    const VEHICLES = [
            [
                'brand' => 'Mercedes',
                'model' => 'A-Class'
            ],
            [
                'brand' => 'Audi',
                'model' => 'A4'
            ],
            [
                'brand' => 'BMW',
                'model' => 'X5'
            ],
            [
                'brand' => 'Volkswagen',
                'model' => 'Golf'
            ],
            [
                'brand' => 'Toyota',
                'model' => 'Corolla'
            ],
            [
                'brand' => 'Ford',
                'model' => 'Fiesta'
            ],
            [
                'brand' => 'Opel',
                'model' => 'Astra'
            ],
            [
                'brand' => 'Peugeot',
                'model' => '207'
            ],
            [
                'brand' => 'Citroen',
                'model' => 'C4'
            ],
            [
                'brand' => 'Renault',
                'model' => 'Clio'
            ],
            [
                'brand' => 'Fiat',
                'model' => 'Punto'
            ],
            [
                'brand' => 'Honda',
                'model' => 'Civic'
            ],
            [
                'brand' => 'Hyundai',
                'model' => 'i30'
            ],
            [
                'brand' => 'Kia',
                'model' => 'Ceed'
            ],
            [
                'brand' => 'Skoda',
                'model' => 'Octavia'
            ],
            [
                'brand' => 'Seat',
                'model' => 'Ibiza'
            ],
            [
                'brand' => 'Suzuki',
                'model' => 'Swift'
            ],
            [
                'brand' => 'Nissan',
                'model' => 'Micra'
            ],
            [
                'brand' => 'Mazda',
                'model' => '6'
            ],
            [
                'brand' => 'Mitsubishi',
                'model' => 'Lancer'
            ],
            [
                'brand' => 'Kia',
                'model' => 'Sorento'
            ],
        ];

    private $provider;

    public function __construct(string $provider)
    {
        $this->provider = $provider;
    }

    public function getRandomDummyVehicles(int $quantity): array{
        $vehicles = [];
        for ($i=0; $i < $quantity; $i++) {
            switch($this->provider){
                case 'road_travellers':
                    $vehicle = $this->getRoadTravellersRandomDummyVehicle();

                    break;
                case 'campervans_4all':
                    $vehicle = $this->getCampervansRandomDummyVehicle();
                    break;
                default:
                    $vehicle = $this->getRentalCampersRandomDummyVehicle();
                    break;
            }
            $vehicles[] = $vehicle;
        }
        return $vehicles;
    }

    private function getRoadTravellersRandomDummyVehicle(): array{
        $randomVehicle = self::VEHICLES[rand(0, count(self::VEHICLES)-1)];
        $vehicle['code'] = $randomVehicle['brand'] . ' ' . $randomVehicle['model'];
        $vehicle['price'] = RandomGenerator::getRandomPrice();
        $vehicle['available'] = RandomGenerator::getRandomAvailability($this->provider);
        return $vehicle;
    }

    private function getCampervansRandomDummyVehicle(): array{
        $randomVehicle = self::VEHICLES[rand(0, count(self::VEHICLES)-1)];
        $vehicle['vehicle_code'] = $randomVehicle['brand'] . ' ' . $randomVehicle['model'];
        $vehicle['total_price'] = RandomGenerator::getRandomPrice();
        $vehicle['availability'] = RandomGenerator::getRandomAvailability($this->provider);
        return $vehicle;
    }

    private function getRentalCampersRandomDummyVehicle(): array{
        $randomVehicle = self::VEHICLES[rand(0, count(self::VEHICLES)-1)];
        $vehicle['code'] = $randomVehicle['brand'] . ' ' . $randomVehicle['model'];
        $vehicle['price'] = RandomGenerator::getRandomPrice();
        $vehicle['currency'] = 'EUR';
        $vehicle['availability'] = RandomGenerator::getRandomAvailability($this->provider);
        return $vehicle;
    }


}