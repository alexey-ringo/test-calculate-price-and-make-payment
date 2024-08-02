<?php

namespace App\Controller;

use App\Dto\ExchangeRequestDto;
use App\Request\CalculatePriceRequest;
use App\Service\CurrencyService;
use App\Validator\Validator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;

class CalculatePriceController extends AbstractController
{
    #[Route(path: '/calculate-price', name: 'calculatePrice', methods: ['POST'])]
    public function __invoke(
        #[MapRequestPayload] CalculatePriceRequest $calculatePriceRequest,
    ): Response {

        // here, $productReview is a fully typed representation of the request data

    }
}
