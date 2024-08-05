<?php
declare(strict_types=1);

namespace App\Strategy\DiscountStrategy;

use App\Exception\ApiException;

final class FixedDiscountStrategy implements DiscountStrategyInterface
{
    /**
     * @throws \Exception
     */
    public function discountPrice(float $price, int $discount): float
    {
        if ($discount >= $price) {
            throw new ApiException('Calculate discount error', 400, ['message' => 'Discount value cannot be greater than price']);
        }

        return $price - $discount;
    }
}
