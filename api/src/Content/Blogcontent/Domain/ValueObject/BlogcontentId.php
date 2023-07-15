<?php

declare(strict_types=1);

namespace Codigito\Content\Blogcontent\Domain\ValueObject;

use Codigito\Shared\Domain\ValueObject\UuidV4Id;
use Codigito\Content\Blogcontent\Domain\Exception\InvalidBlogcontentIdException;

class BlogcontentId extends UuidV4Id
{
    protected function throwException(string $value): void
    {
        throw new InvalidBlogcontentIdException($value);
    }
}
