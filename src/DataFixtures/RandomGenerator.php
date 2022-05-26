<?php

namespace App\DataFixtures;

class RandomGenerator{

    public static function getRandomPrice() : float{
        return rand(1, 100);
    }

    public static function getRandomAvailability(string $provider) : string{
        switch ($provider) {
            case 'road_travellers':
                $random = rand(0, 1);
                if ($random === 0) {
                    return 'Not';
                }
                return 'Yes';
            case 'campervans_4all':
                $random = rand(0, 2);
                if ($random === 0) {
                    return 'NotAvailable';
                }
                if ($random === 1) {
                    return 'Available';
                }
                return 'OnRequest';
            default:
                $random = rand(0, 2);
                if ($random === 0) {
                    return 'not_available';
                }
                if ($random === 1) {
                    return 'available';
                }
                return 'on_request';
        }
    }

}