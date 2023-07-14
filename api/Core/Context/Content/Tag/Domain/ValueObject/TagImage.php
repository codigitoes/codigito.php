<?php

declare(strict_types=1);

namespace Core\Context\Content\Tag\Domain\ValueObject;

use Core\Context\Content\Tag\Domain\Exception\InvalidTagImageException;
use Core\Context\Shared\Domain\ValueObject\Cover;

class TagImage extends Cover
{
    protected function throwException(string $message): void
    {
        throw new InvalidTagImageException($message);
    }
}
