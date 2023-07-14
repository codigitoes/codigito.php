<?php

declare(strict_types=1);

namespace Core\Content\Blogcontent\Domain\ValueObject;

use Core\Shared\Domain\ValueObject\Base64Image;
use Core\Content\Blogcontent\Domain\Exception\InvalidBlogcontentImageException;

class BlogcontentBase64Image extends Base64Image
{
    protected function throwException(string $message): void
    {
        throw new InvalidBlogcontentImageException($message);
    }
}
