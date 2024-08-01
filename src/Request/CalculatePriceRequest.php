<?php
declare(strict_types=1);

namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;

class CalculatePriceRequest
{
    #[Assert\NotBlank]
    #[Assert\Type('integer')]
    private mixed $product;

    #[Assert\NotBlank]
    #[Assert\Type('string')]
    #[Assert\Length(min: 3, max: 5)]
    private mixed $taxNumber;


    #[Assert\Type('string')]
    #[Assert\Length(min: 3, max: 5)]
    private mixed $couponCode;

    public function __construct(
        mixed $product,
        mixed $taxNumber,
        mixed $couponCode
    ) {
        $this->product = $product;
        $this->taxNumber = $taxNumber;
        $this->couponCode = $couponCode;
    }

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
