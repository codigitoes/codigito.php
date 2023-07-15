<?php

declare(strict_types=1);

namespace Codigito\Content\Blogcontent\Domain\ValueObject;

use Codigito\Shared\Domain\ValueObject\Cover;
use Codigito\Content\Blogcontent\Domain\Exception\InvalidBlogcontentImageException;

class BlogcontentImage extends Cover
{
    protected function throwException(string $message): void
    {
        throw new InvalidBlogcontentImageException($message);
    }
}
