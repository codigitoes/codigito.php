<?php

declare(strict_types=1);

namespace Codigito\Content\Blogpost\Domain\ValueObject;

use Codigito\Content\Blogpost\Domain\Exception\InvalidBlogpostNameException;
use Codigito\Shared\Domain\ValueObject\LimitedString;

class BlogpostName extends LimitedString
{
    public const MINIMUM_CHARS = 5;
    public const MAXIMUM_CHARS = 150;

    public function __construct(string $value)
    {
        parent::__construct(self::MINIMUM_CHARS, self::MAXIMUM_CHARS, $value);
    }

    protected function throwException(string $value): void
    {
        throw new InvalidBlogpostNameException($value);
    }
}
