<?php
declare(strict_types=1);

namespace App\Strategy\DiscountStrategy;

use App\Exception\ApiException;

final class PercentDiscountStrategy implements DiscountStrategyInterface
{
    /**
     * @throws \Exception
     */
    public function discountPrice(float $price, int $discount): float
    {
        if ($discount > 99) {
            throw new ApiException('Calculate discount error', 400, ['message' => 'Discount cannot be greater than 99%']);
        }

        return $price - $price * ($discount / 100);
    }
}
