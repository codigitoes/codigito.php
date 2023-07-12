<?php

declare(strict_types=1);

namespace Codigoce\Context\Auth\Credential\Domain\Exception;

use Codigoce\Context\Shared\Domain\Exception\DomainException;

class InvalidCredentialPasswordException extends DomainException
{
    public const PREFIX = 'invalid credential password';

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
