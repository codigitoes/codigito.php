<?php

declare(strict_types=1);

namespace Core\Content\Blogcontent\Domain\ValueObject;

use Core\Shared\Domain\ValueObject\LimitedString;
use Core\Content\Blogcontent\Domain\Exception\InvalidBlogcontentHtmlException;

class BlogcontentHtml extends LimitedString
{
    public const MINIMUM_CHARS = 5;
    public const MAXIMUM_CHARS = 50000;

    public function __construct(string $value)
    {
        parent::__construct(self::MINIMUM_CHARS, self::MAXIMUM_CHARS, $value);
    }

    protected function throwException(string $value): void
    {
        throw new InvalidBlogcontentHtmlException(strlen($value).' min:'.self::MINIMUM_CHARS.' max:'.self::MAXIMUM_CHARS);
    }
}
