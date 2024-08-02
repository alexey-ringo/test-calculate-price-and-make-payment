<?php

declare(strict_types=1);

namespace App\Exception;

use RuntimeException;
use Throwable;

class ApiException extends RuntimeException
{
    private array $details;

    public function __construct(
        string $message = '',
        int $code = 500,
        array $details = [],
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);

        $this->details = $details;
    }

    public function getDetails(): array
    {
        return $this->details;
    }

    public function setDetails(array $details): void
    {
        $this->details = $details;
    }
//
//    public function addDetails(Message $message): void
//    {
//        $this->details[] = $message;
//    }
//
//    /**
//     * Push details message to the exception.
//     *
//     * @param Message $details
//     * @return $this
//     * @deprecated Please use {@see GRPCException::addDetails()} method instead.
//     */
//    #[Deprecated('Please use GRPCException::addDetails() instead', '%class%::addDetails(%parameter0%)')]
//    public function withDetails(
//        $details
//    ): self {
//        $this->details[] = $details;
//
//        return $this;
//    }
}
