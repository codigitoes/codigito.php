<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Blogpost\Domain\ValueObject;

use Codigoce\Context\Content\Blogpost\Domain\Exception\InvalidBlogpostImageException;
use Codigoce\Context\Shared\Domain\ValueObject\Base64Image;

class BlogpostBase64Image extends Base64Image
{
    protected function throwException(string $message): void
    {
        throw new InvalidBlogpostImageException($message);
    }
}
