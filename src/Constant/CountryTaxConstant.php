<?php
declare(strict_types=1);

namespace App\Constant;

use App\Enum\CountryEnum;

class CountryTaxConstant
{
    private static array $countryTax = [
        CountryEnum::GERMANY->value => 19,
        CountryEnum::ITALY->value => 22,
        CountryEnum::FRANCE->value => 20,
        CountryEnum::GREECE->value => 24,
    ];

    public static function getCountryTax(CountryEnum $tax): int
    {
        return self::$countryTax[$tax->value];
    }
}
