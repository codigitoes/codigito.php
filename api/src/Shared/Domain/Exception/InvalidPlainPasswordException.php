<?php

declare(strict_types=1);

namespace Codigito\Shared\Domain\Exception;

class InvalidPlainPasswordException extends DomainException
{
    public const PREFIX = 'invalid plain password';

    public function __construct(string $value)
    {
        parent::__construct(self::PREFIX.' '.$value);
    }

    public const ERROR_CODE = 400;

    public function getErrorCode(): int
    {
        return self::ERROR_CODE;
    }
}
