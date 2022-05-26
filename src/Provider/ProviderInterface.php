<?php

namespace App\Provider;

use Symfony\Component\HttpFoundation\Response;

interface ProviderInterface
{

    const AVAILABLE_NORMALIZATION = 'available';
    const ON_REQUEST_NORMALIZATION = 'on_request';
    const NOT_AVAILABLE_NORMALIZATION = 'not_available';

    public function __construct(string $station, \DateTime $startDate, \DateTime $endDate);
    public function search(): array;
    public function getData();
    public function normalizeVehicles($data): array;


}