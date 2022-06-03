<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Validator\SearchValidator;
use App\Error\ErrorInterface;
use App\Service\Inventory;
use App\Param\UserSearchParams;

class IndexController extends AbstractController
{
    #[Route('/search', name: 'app_index', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        $startDate = $request->query->get('pickUpDate');
        $endDate = $request->query->get('dropOffDate');
        $cityCode = $request->query->get('cityCode');
        $userSearchParams = new UserSearchParams($cityCode, $startDate, $endDate);
        $paramValidationResult = SearchValidator::validate($userSearchParams);
        if($paramValidationResult instanceof ErrorInterface){
            return new JsonResponse(['message' => $paramValidationResult->getMessage()], $paramValidationResult->getCode());
        }
        $vehicles = Inventory::search($cityCode, $startDate, $endDate);
        return new JsonResponse($vehicles);
    }
}
