<?php

declare(strict_types=1);

namespace Core\Content\Shared\Domain\ValueObject;

use Core\Shared\Domain\ValueObject\UuidV4Id;
use Core\Content\Shared\Domain\Exception\InvalidBlogpostIdException;

class BlogpostId extends UuidV4Id
{
    protected function throwException(string $value): void
    {
        throw new InvalidBlogpostIdException($value);
    }
}
