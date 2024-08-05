<?php
declare(strict_types=1);

namespace App\Strategy\PaymentProcessorStrategy;

use App\Enum\PaymentProcessorEnum;
use App\Exception\ApiException;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

final class StripePaymentProcessorStrategy implements PaymentProcessorStrategyInterface
{
    public function __construct(
        private readonly StripePaymentProcessor $paymentProcessor)
    {}

    /**
     * @throws \Exception
     */
    public function pay(float $amount): string
    {
        $result = $this->paymentProcessor->processPayment($amount);
        if ($result === false) {
            throw new ApiException('Payment processing error', 400, ['message' => 'Purchase amount cannot be less than 100 Euro']);
        }

        return PaymentProcessorEnum::STRIPE->value;
    }
}
