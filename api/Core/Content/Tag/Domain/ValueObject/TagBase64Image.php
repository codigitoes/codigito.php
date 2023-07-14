<?php

declare(strict_types=1);

namespace Core\\Content\Tag\Domain\ValueObject;

use Core\\Content\Tag\Domain\Exception\InvalidTagImageException;
use Core\\Shared\Domain\ValueObject\Base64Image;

class TagBase64Image extends Base64Image
{
    protected function throwException(string $message): void
    {
        throw new InvalidTagImageException($message);
    }
}
