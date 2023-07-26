<?php

declare(strict_types=1);

namespace Codigito\Content\Blogcontent\Domain\ValueObject;

use Codigito\Shared\Domain\Exception\InvalidParameterException;
use Codigito\Shared\Domain\ValueObject\UnsignedZeroInt;

class BlogcontentPosition extends UnsignedZeroInt
{
    protected function throwException(int $value): void
    {
        throw new InvalidParameterException('invalid blogcontent position: '.$value);
    }

    final public static function zero(): self
    {
        return new self(0);
    }
}
