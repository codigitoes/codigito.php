<?php

declare(strict_types=1);

namespace Codigito\Auth\Credential\Domain\ValueObject;

use Codigito\Auth\Credential\Domain\Exception\InvalidCredentialIdException;
use Codigito\Shared\Domain\ValueObject\UuidV4Id;

class CredentialId extends UuidV4Id
{
    protected function throwException(string $value): void
    {
        throw new InvalidCredentialIdException($value);
    }
}
