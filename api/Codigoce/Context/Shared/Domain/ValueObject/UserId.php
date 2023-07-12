<?php

declare(strict_types=1);

namespace Codigoce\Context\Shared\Domain\ValueObject;

use Codigoce\Context\Shared\Domain\Exception\InvalidUserIdException;

class UserId extends UuidV4Id
{
    protected function throwException(string $value): void
    {
        throw new InvalidUserIdException($value);
    }
}
