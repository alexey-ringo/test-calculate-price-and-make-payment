<?php

namespace App\Controller;

use App\Request\CalculatePriceRequest;
use App\Transformer\CalculatePriceTransformer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalculatePriceController extends AbstractController
{
    #[Route(path: '/calculate-price', name: 'calculatePrice', methods: ['POST'])]
    public function __invoke(
        CalculatePriceRequest $request,
        CalculatePriceTransformer $transformer
    ): Response {
        $dto = $transformer->transform($request);

        return $this->json($dto);
    }
}
