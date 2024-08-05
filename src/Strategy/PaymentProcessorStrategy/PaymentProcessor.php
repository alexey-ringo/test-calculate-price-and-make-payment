<?php
declare(strict_types=1);

namespace App\Strategy\PaymentProcessorStrategy;

use App\Enum\PaymentProcessorEnum;
use App\Exception\ApiException;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

final class PaymentProcessor
{
    private object $strategy;

    public function __construct(string $paymentProcessor)
    {
        $this->strategy = match (true) {
            $paymentProcessor === PaymentProcessorEnum::PAYPAL->value => new PaypalPaymentProcessorStrategy(new PaypalPaymentProcessor()),
            $paymentProcessor === PaymentProcessorEnum::STRIPE->value => new StripePaymentProcessorStrategy(new StripePaymentProcessor()),
            default => throw new ApiException()
        };
    }

    /**
     * @throws \Exception
     */
    public function pay(float $amount): string
    {
        return $this->strategy->pay($amount);
    }
}
