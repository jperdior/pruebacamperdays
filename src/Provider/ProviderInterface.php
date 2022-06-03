<?php

namespace App\Provider;

use Symfony\Component\HttpFoundation\Response;
use App\Param\UserParamsInterface;

interface ProviderInterface
{

    const AVAILABLE_NORMALIZATION = 'available';
    const ON_REQUEST_NORMALIZATION = 'on_request';
    const NOT_AVAILABLE_NORMALIZATION = 'not_available';

    public function __construct(UserParamsInterface $userParams);
    public function search(): array;
    public function normalizeVehicles(array $data): array;


}