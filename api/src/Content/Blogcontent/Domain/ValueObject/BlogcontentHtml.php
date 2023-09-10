<?php

declare(strict_types=1);

namespace Codigito\Content\Blogcontent\Domain\ValueObject;

use Codigito\Shared\Domain\ValueObject\LimitedString;
use Codigito\Shared\Domain\Exception\InvalidParameterException;

class BlogcontentHtml extends LimitedString
{
    public const MINIMUM_CHARS = 5;
    public const MAXIMUM_CHARS = 100000;

    public function __construct(string $value)
    {
        parent::__construct(self::MINIMUM_CHARS, self::MAXIMUM_CHARS, $value);
    }

    protected function throwException(string $value): void
    {
        throw new InvalidParameterException('invalid blogcontent html: ' . strlen($value) . ' min:' . self::MINIMUM_CHARS . ' max:' . self::MAXIMUM_CHARS);
    }
}
