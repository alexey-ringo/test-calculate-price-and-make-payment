<?php
declare(strict_types=1);

namespace App\Dto;

readonly class CalculatePriceDto implements PurchaseDtoInterface
{
    public function __construct(
        private int    $product,
        private string $taxNumber,
        private string $couponCode
    ) {}

    public function getProduct(): int
    {
        return $this->product;
    }

    public function getTaxNumber(): string
    {
        return $this->taxNumber;
    }

    public function getCouponCode(): string
    {
        return $this->couponCode;
    }
}
