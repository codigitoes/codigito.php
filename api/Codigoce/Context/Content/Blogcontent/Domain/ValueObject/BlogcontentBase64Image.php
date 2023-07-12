<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Blogcontent\Domain\ValueObject;

use Codigoce\Context\Shared\Domain\ValueObject\Base64Image;
use Codigoce\Context\Content\Blogcontent\Domain\Exception\InvalidBlogcontentImageException;

class BlogcontentBase64Image extends Base64Image
{
    protected function throwException(string $message): void
    {
        throw new InvalidBlogcontentImageException($message);
    }
}
