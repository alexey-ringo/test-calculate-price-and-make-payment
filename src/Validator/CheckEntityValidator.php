<?php
declare(strict_types=1);

namespace App\Validator;

use App\Constraint\CheckEntity;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Throwable;

final class CheckEntityValidator extends ConstraintValidator
{
    private ManagerRegistry $registry;

    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }

    public function validate($value, Constraint $constraint): void
    {
        if ($constraint instanceof CheckEntity === false) {
            throw new UnexpectedTypeException($constraint, CheckEntity::class);
        }
        if ($value === null || $value === '') {
            return;
        }

        $entityClass = $constraint->getEntityClass();
        $entityManager = $this->registry->getManagerForClass($entityClass);
        if ($entityManager === null) {
            throw new ConstraintDefinitionException(
                'Unable to find the object manager associated with an entity of class "%s".' . $entityClass
            );
        }
        $arguments = [$value, $constraint->getField()];
        $repository = $entityManager->getRepository($entityClass);
        $result = $repository->{$constraint->getRepositoryMethod()}(...$arguments);

        if ($result === true) {
            return;
        }

        $propertyName = $this->context->getPropertyName();
        $message = 'Not found ' . $this->getTargetClassNane($entityClass) . ' with field ' . $propertyName . ' - ' . $value;
        $this->context
            ->buildViolation($message)
            ->addViolation();
    }

    private function getTargetClassNane(string $qualificationClassName): string
    {
        try {
            $array = explode('\\', $qualificationClassName);

            return $array[count($array) - 1];
        } catch (Throwable $e) {
            return 'Entity';
        }
    }
}
