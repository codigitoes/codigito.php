<?php

declare(strict_types=1);

namespace Core\Auth\Credential\Domain\ValueObject;

use Core\Auth\Credential\Domain\Exception\InvalidCredentialEmailException;

class CredentialEmail
{
    public function __construct(
        public readonly string $value
    ) {
        if (false === filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->throwException($value);
        }
    }

    protected function throwException(string $value): void
    {
        throw new InvalidCredentialEmailException($value);
    }
}
