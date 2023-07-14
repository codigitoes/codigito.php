<?php

declare(strict_types=1);

namespace Core\Context\Auth\Credential\Domain\Exception;

use Core\Context\Shared\Domain\Exception\DomainException;

class CredentialNotFoundException extends DomainException
{
    public const PREFIX = 'credential not found';

    public function __construct(string $value)
    {
        parent::__construct(self::PREFIX . ' ' . $value);
    }

    public const ERROR_CODE = 404;

    public function getErrorCode(): int
    {
        return self::ERROR_CODE;
    }
}
