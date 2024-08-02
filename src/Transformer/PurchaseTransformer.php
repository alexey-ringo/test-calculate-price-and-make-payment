<?php
declare(strict_types=1);

namespace App\Transformer;

use App\Dto\PurchaseDto;
use App\Request\PurchaseRequest;

class PurchaseTransformer
{
    public function transform(PurchaseRequest $request): PurchaseDto
    {
        return new PurchaseDto(
            product: $request->getProduct(),
            taxNumber: $request->getTaxNumber(),
            couponCode: $request->getCouponCode(),
            paymentProcessor: $request->getPaymentProcessor()
        );
    }
}
