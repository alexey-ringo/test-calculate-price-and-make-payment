<?php

namespace App\Strategy\PaymentProcessorStrategy;

interface PaymentProcessorStrategyInterface
{
    public function pay(float $amount): string;
}
