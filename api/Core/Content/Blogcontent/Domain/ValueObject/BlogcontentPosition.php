<?php

declare(strict_types=1);

namespace Core\\Content\Blogcontent\Domain\ValueObject;

use Core\\Content\Blogcontent\Domain\Exception\InvalidBlogcontentPositionException;
use Core\\Shared\Domain\ValueObject\UnsignedZeroInt;

class BlogcontentPosition extends UnsignedZeroInt
{
    protected function throwException(int $value): void
    {
        throw new InvalidBlogcontentPositionException($value);
    }

    final public static function zero(): self
    {
        return new self(0);
    }
}
