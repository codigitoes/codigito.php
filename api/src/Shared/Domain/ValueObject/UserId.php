<?php

declare(strict_types=1);

namespace Codigito\Shared\Domain\ValueObject;

use Codigito\Shared\Domain\Exception\InvalidParameterException;

class UserId extends UuidV4Id
{
    protected function throwException(string $value): void
    {
        throw new InvalidParameterException('invalid user id: '.$value);
    }
}
