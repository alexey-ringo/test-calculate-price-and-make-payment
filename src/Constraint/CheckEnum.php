<?php
declare(strict_types=1);

namespace App\Constraint;

use App\Validator\CheckEnumValidator;
use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class CheckEnum extends Constraint
{
    public string $message = '';

    public string $enumClassName;

    public function __construct(
        string $enumClassName,
        mixed $options = null,
        array $groups = null,
        mixed $payload = null
    ) {
        parent::__construct($options, $groups, $payload);
        $this->enumClassName = $enumClassName;
    }

    public function getTargets(): string
    {
        return self::PROPERTY_CONSTRAINT;
    }

    public function validatedBy(): string
    {
        return CheckEnumValidator::class;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getEnumClassName(): string
    {
        return $this->enumClassName;
    }
}
