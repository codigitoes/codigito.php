<?php

declare(strict_types=1);

namespace Codigito\Auth\Credential\Domain\ValueObject;

use Codigito\Shared\Domain\Exception\InvalidParameterException;
use Codigito\Shared\Domain\ValueObject\UuidV4Id;

class CredentialId extends UuidV4Id
{
    protected function throwException(string $value): void
    {
        throw new InvalidParameterException('invalid credential id: '.$value);
    }
}
