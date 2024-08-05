<?php
declare(strict_types=1);

namespace App\Service;

use App\Constant\CountryTaxConstant;
use App\Dto\PurchaseDto;
use App\Dto\PurchaseDtoInterface;
use App\Exception\ApiException;
use App\Helper\CountryHelper;
use App\Repository\CouponRepository;
use App\Repository\ProductRepository;
use App\Strategy\DiscountStrategy\Discount;
use App\Strategy\PaymentProcessorStrategy\PaymentProcessor;

final class PurchaseService
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly CouponRepository $couponRepository,
    ) {}

    public function calculatePrice(PurchaseDtoInterface $dto): float
    {
        $coupon = $this->couponRepository->findOneBy(['code' => $dto->getCouponCode()]);
        if (null === $coupon) {
            throw new ApiException('Not Found', 404, ['message' => 'Not found Coupon with code : ' . $dto->getCouponCode()]);
        }
        $product = $this->productRepository->find($dto->getProduct());
        if (null === $product) {
            throw new ApiException('Not Found', 404, ['message' => 'Not found Product with id : ' . $dto->getProduct()]);
        }

        $discount = new Discount($coupon->getDiscountType()->value);
        $discountPrice = $discount->discountPrice($product->getPrice(), $coupon->getDiscount());

        $country = CountryHelper::getCountry($dto->getTaxNumber());
        $countryTax = CountryTaxConstant::getCountryTax($country);

        return $discountPrice + $discountPrice * ($countryTax / 100);
    }

    /**
     * @throws \Exception
     */
    public function pay(PurchaseDto $dto): string
    {
        $calculatedPrice = $this->calculatePrice($dto);
        $paymentProcessor = new PaymentProcessor($dto->getPaymentProcessor());

        return $paymentProcessor->pay($calculatedPrice);
    }
}
