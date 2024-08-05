<?php
declare(strict_types=1);

namespace App\Strategy\DiscountStrategy;

use App\Enum\DiscountTypeEnum;
use App\Exception\ApiException;

final class Discount
{
    private object $strategy;

    public function __construct(string $discountType)
    {
        $this->strategy = match (true) {
            $discountType === DiscountTypeEnum::FIXED->value => new FixedDiscountStrategy(),
            $discountType === DiscountTypeEnum::PERCENT->value => new PercentDiscountStrategy(),
            default => throw new ApiException()
        };
    }

    /**
     * @throws \Exception
     */
    public function discountPrice(float $price, int $discount): float
    {
        return $this->strategy->discountPrice($price, $discount);
    }
}
