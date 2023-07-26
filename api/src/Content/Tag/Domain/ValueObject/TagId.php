<?php

declare(strict_types=1);

namespace Codigito\Content\Tag\Domain\ValueObject;

use Codigito\Shared\Domain\Exception\InvalidParameterException;
use Codigito\Shared\Domain\ValueObject\UuidV4Id;

class TagId extends UuidV4Id
{
    protected function throwException(string $value): void
    {
        throw new InvalidParameterException('invalid tag id: '.$value);
    }
}
