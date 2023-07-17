<?php

declare(strict_types=1);

namespace Codigito\Shared\Domain\ValueObject;

use Codigito\Shared\Domain\Exception\InvalidDomainEventIdException;

class DomainEventId extends UuidV4Id
{
    protected function throwException(string $value): void
    {
        throw new InvalidDomainEventIdException($value);
    }
}
