<?php

declare(strict_types=1);

namespace Core\\Auth\Credential\Domain\Exception;

use Core\\Shared\Domain\Exception\DomainException;

class CredentialCantDeleteException extends DomainException
{
    public const PREFIX = 'cant delete credential';

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
