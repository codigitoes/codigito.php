<?php

declare(strict_types=1);

namespace Codigito\Shared\Domain\ValueObject;

use Codigito\Shared\Domain\Exception\InvalidParameterException;

class DomainEventName extends LimitedString
{
    const MINIMUM_LENGTH = 5;
    const MAXIMUM_LENGTH = 100;


    public function __construct(string $value)
    {
        parent::__construct(self::MINIMUM_LENGTH, self::MAXIMUM_LENGTH, $value);
    }


    protected function throwException(string $value): void
    {
        throw new InvalidParameterException('invalid domain event name ' . $value);
    }
}
