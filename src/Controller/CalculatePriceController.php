<?php

namespace App\Controller;

use App\Request\CalculatePriceRequest;
use App\Service\PurchaseService;
use App\Transformer\CalculatePriceTransformer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalculatePriceController extends AbstractController
{
    #[Route(path: '/calculate-price', name: 'calculatePrice', methods: ['POST'])]
    public function __invoke(
        CalculatePriceRequest $request,
        CalculatePriceTransformer $transformer,
        PurchaseService $service
    ): Response {
        $dto = $transformer->transform($request);
        $result = $service->calculatePrice($dto);

        return $this->json(['final_price' => $result]);
    }
}
