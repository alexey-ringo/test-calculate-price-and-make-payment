<?php
declare(strict_types=1);

namespace App\Helper;

use App\Enum\CountryEnum;
use App\Exception\ApiException;
use Throwable;

class CountryHelper
{
    public static function getCountry(string $countryNumber): CountryEnum
    {
        try {
            $countryCodeString = strtolower(substr($countryNumber, 0, 2));

            return CountryEnum::from($countryCodeString);
        } catch (Throwable $e) {
            throw new ApiException('Validation error', 422, ['message' => 'Invalid country code into taxNumber']);
        }
    }
}
