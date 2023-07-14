<?php

declare(strict_types=1);

namespace Core\\Content\Blogcontent\Domain\ValueObject;

use Core\\Shared\Domain\ValueObject\UuidV4Id;
use Core\\Content\Blogcontent\Domain\Exception\InvalidBlogcontentIdException;

class BlogcontentId extends UuidV4Id
{
    protected function throwException(string $value): void
    {
        throw new InvalidBlogcontentIdException($value);
    }
}
