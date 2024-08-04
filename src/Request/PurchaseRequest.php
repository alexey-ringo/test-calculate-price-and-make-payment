<?php
declare(strict_types=1);

namespace App\Request;

use App\Constraint\CheckEntity;
use App\Constraint\CheckEnum;
use App\Entity\Coupon;
use App\Entity\Product;
use App\Enum\PaymentProcessorEnum;
use Symfony\Component\Validator\Constraints as Assert;

class PurchaseRequest extends BaseRequest
{
    #[Assert\NotBlank]
    #[Assert\Type('integer')]
    #[CheckEntity(Product::class, 'exists', 'id')]
    public mixed $product;

    #[Assert\NotBlank]
    #[Assert\Type('string')]
    public mixed $taxNumber;

    #[Assert\Type('string')]
    #[CheckEntity(Coupon::class, 'exists', 'code')]
    public mixed $couponCode;

    #[Assert\Type('string')]
    #[CheckEnum(PaymentProcessorEnum::class)]
    public mixed $paymentProcessor;

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

    public function getPaymentProcessor(): mixed
    {
        return $this->paymentProcessor;
    }
}
