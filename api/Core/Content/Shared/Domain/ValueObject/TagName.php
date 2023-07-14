<?php

declare(strict_types=1);

namespace Core\Content\Shared\Domain\ValueObject;

use Core\Content\Shared\Domain\Exception\InvalidTagNameException;
use Core\Shared\Domain\ValueObject\LimitedString;

class TagName extends LimitedString
{
    public const MINIMUM_CHARS = 3;
    public const MAXIMUM_CHARS = 50;

    public function __construct(string $value)
    {
        parent::__construct(self::MINIMUM_CHARS, self::MAXIMUM_CHARS, $value);
    }

    protected function throwException(string $value): void
    {
        throw new InvalidTagNameException($value);
    }
}
