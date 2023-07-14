<?php

declare(strict_types=1);

namespace Core\Content\Fortune\Domain\ValueObject;

use Core\Shared\Domain\ValueObject\LimitedString;
use Core\Content\Fortune\Domain\Exception\InvalidFortuneNameException;

class FortuneName extends LimitedString
{
    public const MINIMUM_CHARS = 5;
    public const MAXIMUM_CHARS = 150;

    public function __construct(string $value)
    {
        parent::__construct(self::MINIMUM_CHARS, self::MAXIMUM_CHARS, $value);
    }

    protected function throwException(string $value): void
    {
        throw new InvalidFortuneNameException($value);
    }
}
