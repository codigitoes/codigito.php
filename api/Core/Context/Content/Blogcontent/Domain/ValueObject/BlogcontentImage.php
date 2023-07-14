<?php

declare(strict_types=1);

namespace Core\Context\Content\Blogcontent\Domain\ValueObject;

use Core\Context\Shared\Domain\ValueObject\Cover;
use Core\Context\Content\Blogcontent\Domain\Exception\InvalidBlogcontentImageException;

class BlogcontentImage extends Cover
{
    protected function throwException(string $message): void
    {
        throw new InvalidBlogcontentImageException($message);
    }
}
