<?php

declare(strict_types=1);

namespace Core\Content\Fortune\Domain\ValueObject;

use Core\Shared\Domain\ValueObject\UuidV4Id;
use Core\Content\Fortune\Domain\Exception\InvalidFortuneIdException;

class FortuneId extends UuidV4Id
{
    protected function throwException(string $value): void
    {
        throw new InvalidFortuneIdException($value);
    }
}
