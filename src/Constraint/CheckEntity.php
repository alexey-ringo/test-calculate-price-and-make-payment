<?php
declare(strict_types=1);

namespace App\Constraint;

use App\Validator\CheckEntityValidator;
use App\Validator\CheckEnumValidator;
use Attribute;
use Symfony\Component\Validator\Constraint;

/**
 * @template T of object
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
final class CheckEntity extends Constraint
{
    public string $message = 'This value should be exists.';
    /** @var class-string<T> */
    public string $entityClass;
    public string $repositoryMethod;
    public string $field;

    /**
     * @param  class-string<T>  $entityClass
     */
    public function __construct(
        string $entityClass,
        string $repositoryMethod,
        string $field,
        mixed $options = null,
        array $groups = null,
        mixed $payload = null
    ) {
        parent::__construct($options, $groups, $payload);
        $this->entityClass = $entityClass;
        $this->repositoryMethod = $repositoryMethod;
        $this->field = $field;
    }

    public function getTargets(): string
    {
        return self::PROPERTY_CONSTRAINT;
    }

    public function validatedBy(): string
    {
        return CheckEntityValidator::class;
    }

    /**
     * @return class-string<T>
     */
    public function getEntityClass(): string
    {
        return $this->entityClass;
    }

    public function getRepositoryMethod(): string
    {
        return $this->repositoryMethod;
    }

    public function getField(): string
    {
        return $this->field;
    }
}
