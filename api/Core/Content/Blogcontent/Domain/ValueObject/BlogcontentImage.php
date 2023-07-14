<?php

declare(strict_types=1);

namespace Core\Content\Blogcontent\Domain\ValueObject;

use Core\Shared\Domain\ValueObject\Cover;
use Core\Content\Blogcontent\Domain\Exception\InvalidBlogcontentImageException;

class BlogcontentImage extends Cover
{
    protected function throwException(string $message): void
    {
        throw new InvalidBlogcontentImageException($message);
    }
}
