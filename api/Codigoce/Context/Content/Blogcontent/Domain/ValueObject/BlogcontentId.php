<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Blogcontent\Domain\ValueObject;

use Codigoce\Context\Shared\Domain\ValueObject\UuidV4Id;
use Codigoce\Context\Content\Blogcontent\Domain\Exception\InvalidBlogcontentIdException;

class BlogcontentId extends UuidV4Id
{
    protected function throwException(string $value): void
    {
        throw new InvalidBlogcontentIdException($value);
    }
}
