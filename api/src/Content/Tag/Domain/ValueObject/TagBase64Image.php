<?php

declare(strict_types=1);

namespace Codigito\Content\Tag\Domain\ValueObject;

use Codigito\Content\Tag\Domain\Exception\InvalidTagImageException;
use Codigito\Shared\Domain\ValueObject\Base64Image;

class TagBase64Image extends Base64Image
{
    protected function throwException(string $message): void
    {
        throw new InvalidTagImageException($message);
    }
}
