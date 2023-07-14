<?php

declare(strict_types=1);

namespace Core\\Auth\Credential\Domain\Exception;

use Core\\Shared\Domain\Exception\DomainException;

class CredentialCantSaveException extends DomainException
{
    public const PREFIX = 'cant create a new credential';

    public function __construct(string $value)
    {
        parent::__construct(self::PREFIX . ' ' . $value);
    }

    public const ERROR_CODE = 500;

    public function getErrorCode(): int
    {
        return self::ERROR_CODE;
    }
}
