<?php

declare(strict_types=1);

namespace Codigito\Auth\Credential\Domain\ValueObject;

use Codigito\Shared\Domain\Exception\InvalidParameterException;

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
        throw new InvalidParameterException('invalid credential email: '.$value);
    }
}
