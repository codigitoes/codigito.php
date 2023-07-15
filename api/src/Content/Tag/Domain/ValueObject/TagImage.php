<?php

declare(strict_types=1);

namespace Codigito\Content\Tag\Domain\ValueObject;

use Codigito\Content\Tag\Domain\Exception\InvalidTagImageException;
use Codigito\Shared\Domain\ValueObject\Cover;

class TagImage extends Cover
{
    protected function throwException(string $message): void
    {
        throw new InvalidTagImageException($message);
    }
}
