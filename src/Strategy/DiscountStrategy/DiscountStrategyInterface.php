<?php

namespace App\Strategy\DiscountStrategy;

interface DiscountStrategyInterface
{
    public function discountPrice(float $price, int $discount): float;
}
