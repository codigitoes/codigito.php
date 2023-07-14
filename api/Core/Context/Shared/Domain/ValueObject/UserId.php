<?php

declare(strict_types=1);

namespace Core\Context\Shared\Domain\ValueObject;

use Core\Context\Shared\Domain\Exception\InvalidUserIdException;

class UserId extends UuidV4Id
{
    protected function throwException(string $value): void
    {
        throw new InvalidUserIdException($value);
    }
}
