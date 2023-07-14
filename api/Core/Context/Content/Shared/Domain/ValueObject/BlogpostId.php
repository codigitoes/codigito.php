<?php

declare(strict_types=1);

namespace Core\Context\Content\Shared\Domain\ValueObject;

use Core\Context\Shared\Domain\ValueObject\UuidV4Id;
use Core\Context\Content\Shared\Domain\Exception\InvalidBlogpostIdException;

class BlogpostId extends UuidV4Id
{
    protected function throwException(string $value): void
    {
        throw new InvalidBlogpostIdException($value);
    }
}
