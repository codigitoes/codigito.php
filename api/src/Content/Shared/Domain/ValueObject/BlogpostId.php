<?php

declare(strict_types=1);

namespace Codigito\Content\Shared\Domain\ValueObject;

use Codigito\Shared\Domain\ValueObject\UuidV4Id;
use Codigito\Shared\Domain\Exception\InvalidParameterException;

class BlogpostId extends UuidV4Id
{
    protected function throwException(string $value): void
    {
        throw new InvalidParameterException('invalid blogpost id: '.$value);
    }
}
