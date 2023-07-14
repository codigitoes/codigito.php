<?php

declare(strict_types=1);

namespace Core\Context\Content\Blogpost\Domain\ValueObject;

use Core\Context\Content\Blogpost\Domain\Exception\InvalidBlogpostImageException;
use Core\Context\Shared\Domain\ValueObject\Cover;

class BlogpostImage extends Cover
{
    protected function throwException(string $message): void
    {
        throw new InvalidBlogpostImageException($message);
    }
}
