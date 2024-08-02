<?php
declare(strict_types=1);

namespace App\Transformer;

use App\Dto\CalculatePriceDto;
use App\Request\CalculatePriceRequest;

class CalculatePriceTransformer
{
    public function transform(CalculatePriceRequest $request): CalculatePriceDto
    {
        return new CalculatePriceDto(
            product: $request->getProduct(),
            taxNumber: $request->getTaxNumber(),
            couponCode: $request->getCouponCode()
        );
    }
}
