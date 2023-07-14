<?php

declare(strict_types=1);

namespace Core\Context\Content\Tag\Domain\ValueObject;

use Core\Context\Content\Tag\Domain\Exception\InvalidTagIdException;
use Core\Context\Shared\Domain\ValueObject\UuidV4Id;

class TagId extends UuidV4Id
{
    protected function throwException(string $value): void
    {
        throw new InvalidTagIdException($value);
    }
}
