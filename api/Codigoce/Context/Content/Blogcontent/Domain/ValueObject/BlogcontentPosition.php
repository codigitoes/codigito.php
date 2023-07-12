<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Blogcontent\Domain\ValueObject;

use Codigoce\Context\Content\Blogcontent\Domain\Exception\InvalidBlogcontentPositionException;
use Codigoce\Context\Shared\Domain\ValueObject\UnsignedZeroInt;

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
