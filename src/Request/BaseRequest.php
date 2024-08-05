<?php

namespace App\Request;

use App\Exception\ApiException;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class BaseRequest
{
    public function __construct(protected ValidatorInterface $validator)
    {
        $this->populate();

        if ($this->autoValidateRequest()) {
            $this->validate();
        }
    }

    public function validate()
    {
        $validateResult = $this->validator->validate($this);

        /** @var ConstraintViolation $validateResult */

        $errors = [];
        foreach ($validateResult as $item) {
            $errors[] = [
                'property' => $item->getPropertyPath(),
                'value' => $item->getInvalidValue(),
                'message' => $item->getMessage(),
            ];
        }

        if (count($errors) > 0) {
            throw new ApiException('Validation failed', 422, $errors);
        }

    }

    public function getRequest(): Request
    {
        return Request::createFromGlobals();
    }

    protected function populate(): void
    {
        foreach ($this->getRequest()->toArray() as $property => $value) {
            if (property_exists($this, $property)) {
                $this->{$property} = $value;
            }
        }
    }

    protected function autoValidateRequest(): bool
    {
        return true;
    }
}
