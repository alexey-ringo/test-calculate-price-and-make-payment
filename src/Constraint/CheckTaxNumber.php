<?php
declare(strict_types=1);

namespace App\Constraint;

use App\Validator\CheckTaxNumberValidator;
use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class CheckTaxNumber extends Constraint
{
    public string $message = '';

    public function getTargets(): string
    {
        return self::PROPERTY_CONSTRAINT;
    }

    public function validatedBy(): string
    {
        return CheckTaxNumberValidator::class;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
