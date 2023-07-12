<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Blogcontent\Domain\ValueObject;

use Codigoce\Context\Shared\Domain\ValueObject\Cover;
use Codigoce\Context\Content\Blogcontent\Domain\Exception\InvalidBlogcontentImageException;

class BlogcontentImage extends Cover
{
    protected function throwException(string $message): void
    {
        throw new InvalidBlogcontentImageException($message);
    }
}
