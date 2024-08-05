<?php
declare(strict_types=1);

namespace App\Validator;

use App\Constraint\CheckEnum;
use App\Constraint\CheckTaxNumber;
use App\Enum\CountryEnum;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\ValidatorException;

final class CheckTaxNumberValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if ($constraint instanceof CheckTaxNumber === false) {
            throw new UnexpectedTypeException($constraint, CheckTaxNumber::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedTypeException($value, 'string');
        }

        $countryCodeString = strtolower(substr($value, 0, 2));

        if (CountryEnum::tryFrom($countryCodeString)) {
            return;
        }

        $propertyName = $this->context->getPropertyName();
        $this->fallValidation('The value of field ' . $propertyName . ' must be contain correct country code');
    }

    private function fallValidation(string $message): void
    {
        $this->context->buildViolation($message)
            ->addViolation();
    }
}
