<?php

declare(strict_types=1);

namespace Codigito\Content\Blogcontent\Domain\ValueObject;

use Codigito\Shared\Domain\ValueObject\Base64Image;
use Codigito\Content\Blogcontent\Domain\Exception\InvalidBlogcontentImageException;

class BlogcontentBase64Image extends Base64Image
{
    protected function throwException(string $message): void
    {
        throw new InvalidBlogcontentImageException($message);
    }
}
