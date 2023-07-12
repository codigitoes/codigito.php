<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Fortune\Domain\ValueObject;

use Codigoce\Context\Shared\Domain\ValueObject\UuidV4Id;
use Codigoce\Context\Content\Fortune\Domain\Exception\InvalidFortuneIdException;

class FortuneId extends UuidV4Id
{
    protected function throwException(string $value): void
    {
        throw new InvalidFortuneIdException($value);
    }
}
