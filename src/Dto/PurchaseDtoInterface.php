<?php

namespace App\Dto;

interface PurchaseDtoInterface
{
    public function getProduct(): int;
    public function getTaxNumber(): string;
    public function getCouponCode(): string;

}
