<?php

declare(strict_types=1);

namespace Codigito\Shared\Domain\Exception;

class InvalidEventException extends DomainException
{
    public const PREFIX = 'invalid event';

    public function __construct(string $value)
    {
        parent::__construct(self::PREFIX.' '.$value);
    }

    public const ERROR_CODE = 500;

    public function getErrorCode(): int
    {
        return self::ERROR_CODE;
    }
}
