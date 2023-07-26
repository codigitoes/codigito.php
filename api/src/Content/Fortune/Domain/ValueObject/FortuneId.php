<?php

declare(strict_types=1);

namespace Codigito\Content\Fortune\Domain\ValueObject;

use Codigito\Shared\Domain\ValueObject\UuidV4Id;
use Codigito\Shared\Domain\Exception\InvalidParameterException;

class FortuneId extends UuidV4Id
{
    protected function throwException(string $value): void
    {
        throw new InvalidParameterException('invalid fortune id: '.$value);
    }
}
