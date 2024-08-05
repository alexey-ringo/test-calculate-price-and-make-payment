<?php
declare(strict_types=1);

namespace App\Service;

use App\Dto\PurchaseDto;
use App\Dto\PurchaseDtoInterface;
use App\Strategy\PaymentProcessorStrategy\PaymentProcessor;

final class PurchaseService
{
    public function calculatePrice(PurchaseDtoInterface $dto): float
    {
        return 1.0;
    }

    /**
     * @throws \Exception
     */
    public function pay(PurchaseDto $dto): string
    {
        $calculatedPrice = $this->calculatePrice($dto);
        $paymentProcessor = new PaymentProcessor($dto->getPaymentProcessor());

        return $paymentProcessor->pay($calculatedPrice);
    }
}
