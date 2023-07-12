<?php

declare(strict_types=1);

namespace Codigoce\Context\Auth\Credential\Domain\ValueObject;

use Codigoce\Context\Auth\Credential\Domain\Exception\InvalidCredentialIdException;
use Codigoce\Context\Shared\Domain\ValueObject\UuidV4Id;

class CredentialId extends UuidV4Id
{
    protected function throwException(string $value): void
    {
        throw new InvalidCredentialIdException($value);
    }
}
