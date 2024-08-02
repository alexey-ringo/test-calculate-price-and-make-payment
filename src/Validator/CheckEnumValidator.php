<?php
declare(strict_types=1);

namespace App\Validator;

use App\Constraint\CheckEnum;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\ValidatorException;

final class CheckEnumValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if ($constraint instanceof CheckEnum === false) {
            throw new UnexpectedTypeException($constraint, CheckEnum::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        $enumClassName = $constraint->getEnumClassName();
        if (!enum_exists($enumClassName)) {
            throw new ValidatorException('Enum class ' . $enumClassName . 'does not exists');
        }

        //TODO - to cover test and check
        /* @phpstan-ignore-next-line */
        if ($enumClassName::tryFrom($value)) {
            return;
        }

        $propertyName = $this->context->getPropertyName();
        $this->fallValidation('The value of field ' . $propertyName . ' must be within the allowed range');
    }

    private function fallValidation(string $message): void
    {
        $this->context->buildViolation($message)
            ->addViolation();
    }
}
