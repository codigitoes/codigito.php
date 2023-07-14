<?php

declare(strict_types=1);

namespace Core\Context\Content\Blogcontent\Domain\ValueObject;

use Core\Context\Shared\Domain\ValueObject\Base64Image;
use Core\Context\Content\Blogcontent\Domain\Exception\InvalidBlogcontentImageException;

class BlogcontentBase64Image extends Base64Image
{
    protected function throwException(string $message): void
    {
        throw new InvalidBlogcontentImageException($message);
    }
}
