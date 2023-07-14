<?php

declare(strict_types=1);

namespace Core\Content\Tag\Domain\ValueObject;

use Core\Content\Tag\Domain\Exception\InvalidTagImageException;
use Core\Shared\Domain\ValueObject\Cover;

class TagImage extends Cover
{
    protected function throwException(string $message): void
    {
        throw new InvalidTagImageException($message);
    }
}
