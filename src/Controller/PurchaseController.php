<?php

namespace App\Controller;

use App\Request\PurchaseRequest;
use App\Service\PurchaseService;
use App\Transformer\PurchaseTransformer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class PurchaseController extends AbstractController
{
    /**
     * @throws \Exception
     */
    #[Route(path: '/purchase', name: 'purchase', methods: ['POST'])]
    public function __invoke(
        PurchaseRequest $request,
        PurchaseTransformer $transformer,
        PurchaseService $service
    ): Response {
        $dto = $transformer->transform($request);
        $result = $service->pay($dto);

        return $this->json(['processor' => $result]);
    }
}
