<?php

declare(strict_types=1);

namespace Codigoce\Context\Auth\Credential\Domain\Exception;

use Codigoce\Context\Shared\Domain\Exception\DomainException;

class CredentialCantUpdateException extends DomainException
{
    public const PREFIX = 'cant update credential';

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