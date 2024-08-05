<?php
declare(strict_types=1);

namespace App\Strategy\PaymentProcessorStrategy;

use App\Enum\PaymentProcessorEnum;
use App\Exception\ApiException;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;
use Throwable;

final class PaypalPaymentProcessorStrategy implements PaymentProcessorStrategyInterface
{
    public function __construct(
        private readonly PaypalPaymentProcessor $paymentProcessor)
    {}

    /**
     * @throws \Exception
     */
    public function pay(float $amount): string
    {
        try {
            $this->paymentProcessor->pay((int) $amount);
        } catch (Throwable $e) {
            throw new ApiException('Payment processing error', 400, ['message' => $e->getMessage()]);
        }

        return PaymentProcessorEnum::PAYPAL->value;
    }
}
