<?php

declare(strict_types=1);

namespace Core\Context\Content\Blogcontent\Domain\ValueObject;

use Core\Context\Shared\Domain\ValueObject\UuidV4Id;
use Core\Context\Content\Blogcontent\Domain\Exception\InvalidBlogcontentIdException;

class BlogcontentId extends UuidV4Id
{
    protected function throwException(string $value): void
    {
        throw new InvalidBlogcontentIdException($value);
    }
}
