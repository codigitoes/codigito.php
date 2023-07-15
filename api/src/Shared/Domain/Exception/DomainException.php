<?php

declare(strict_types=1);

namespace Codigito\Shared\Domain\Exception;

abstract class DomainException extends \Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }

    abstract public function getErrorCode(): int;
}
