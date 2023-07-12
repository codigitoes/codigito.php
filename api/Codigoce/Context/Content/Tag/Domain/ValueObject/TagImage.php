<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Tag\Domain\ValueObject;

use Codigoce\Context\Content\Tag\Domain\Exception\InvalidTagImageException;
use Codigoce\Context\Shared\Domain\ValueObject\Cover;

class TagImage extends Cover
{
    protected function throwException(string $message): void
    {
        throw new InvalidTagImageException($message);
    }
}
