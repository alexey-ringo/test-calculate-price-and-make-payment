<?php

namespace App\Controller;

use App\Request\PurchaseRequest;
use App\Transformer\PurchaseTransformer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class PurchaseController extends AbstractController
{
    #[Route(path: '/purchase', name: 'purchase', methods: ['POST'])]
    public function __invoke(
        PurchaseRequest $request,
        PurchaseTransformer $transformer
    ): Response {
        $dto = $transformer->transform($request);

        return $this->json($dto);
    }
}
