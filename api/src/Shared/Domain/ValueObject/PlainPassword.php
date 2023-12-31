<?php

declare(strict_types=1);

namespace Codigito\Shared\Domain\ValueObject;

use Codigito\Shared\Domain\Exception\InvalidParameterException;

class PlainPassword extends LimitedString
{
    public const MINIMUM_CHARS = 5;
    public const MAXIMUM_CHARS = 20;

    public function __construct(string $value)
    {
        parent::__construct(self::MINIMUM_CHARS, self::MAXIMUM_CHARS, $value);
    }

    protected function throwException(string $value): void
    {
        throw new InvalidParameterException('invalid plain password: '.$value);
    }
}
