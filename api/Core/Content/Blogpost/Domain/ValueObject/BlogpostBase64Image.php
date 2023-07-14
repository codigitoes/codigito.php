<?php

declare(strict_types=1);

namespace Core\Content\Blogpost\Domain\ValueObject;

use Core\Content\Blogpost\Domain\Exception\InvalidBlogpostImageException;
use Core\Shared\Domain\ValueObject\Base64Image;

class BlogpostBase64Image extends Base64Image
{
    protected function throwException(string $message): void
    {
        throw new InvalidBlogpostImageException($message);
    }
}
