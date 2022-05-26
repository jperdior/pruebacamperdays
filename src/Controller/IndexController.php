<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Validator\SearchValidator;
use App\Service\Inventory;

class IndexController extends AbstractController
{
    #[Route('/search', name: 'app_index', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        $startDate = $request->query->get('pickUpDate');
        $endDate = $request->query->get('dropOffDate');
        $cityCode = $request->query->get('cityCode');
        if(!SearchValidator::searchParamsAreValid($startDate, $endDate, $cityCode)){
            return new JsonResponse(['error' => 'Invalid search parameters'], 400);
        }
        $startDate = \DateTime::createFromFormat('Y-m-d', $startDate);
        $endDate = \DateTime::createFromFormat('Y-m-d', $endDate);
        $vehicles = Inventory::search($cityCode, $startDate, $endDate);
        return new JsonResponse($vehicles);
    }
}
