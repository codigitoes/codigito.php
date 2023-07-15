<?php

declare(strict_types=1);

namespace Codigito\Content\Shared\Domain\ValueObject;

use Codigito\Shared\Domain\ValueObject\UuidV4Id;
use Codigito\Content\Shared\Domain\Exception\InvalidBlogpostIdException;

class BlogpostId extends UuidV4Id
{
    protected function throwException(string $value): void
    {
        throw new InvalidBlogpostIdException($value);
    }
}
