<?php

declare(strict_types=1);

namespace Core\Content\Tag\Domain\ValueObject;

use Core\Content\Tag\Domain\Exception\InvalidTagIdException;
use Core\Shared\Domain\ValueObject\UuidV4Id;

class TagId extends UuidV4Id
{
    protected function throwException(string $value): void
    {
        throw new InvalidTagIdException($value);
    }
}
