<?php

declare(strict_types=1);

namespace Codigito\Content\Blogpost\Domain\ValueObject;

use Codigito\Shared\Domain\Exception\InvalidParameterException;
use Codigito\Shared\Domain\ValueObject\Html;

class BlogpostHtml extends Html
{
    protected function throwException(string $value): void
    {
        throw new InvalidParameterException('invalid blogpost html: '.$value);
    }
}
