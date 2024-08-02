<?php
declare(strict_types=1);

namespace App\Request;

use App\Constraint\CheckEntity;
use App\Entity\Coupon;
use App\Entity\Product;
use Symfony\Component\Validator\Constraints as Assert;

class CalculatePriceRequest extends BaseRequest
{
    #[Assert\NotBlank]
    #[Assert\Type('integer')]
    #[CheckEntity(Product::class, 'exists', 'id')]
    public readonly mixed $product;

    #[Assert\NotBlank]
    #[Assert\Type('string')]
    #[Assert\Length(min: 3, max: 5)]
    public readonly mixed $taxNumber;

    #[Assert\Type('string')]
    #[CheckEntity(Coupon::class, 'exists', 'id')]
    public readonly mixed $couponCode;

    public function getProduct(): mixed
    {
        return $this->product;
    }

    public function getTaxNumber(): mixed
    {
        return $this->taxNumber;
    }

    public function getCouponCode(): mixed
    {
        return $this->couponCode;
    }
}
