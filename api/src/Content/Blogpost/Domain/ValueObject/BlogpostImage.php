<?php

declare(strict_types=1);

namespace Codigito\Content\Blogpost\Domain\ValueObject;

use Codigito\Content\Blogpost\Domain\Exception\InvalidBlogpostImageException;
use Codigito\Shared\Domain\ValueObject\Cover;

class BlogpostImage extends Cover
{
    protected function throwException(string $message): void
    {
        throw new InvalidBlogpostImageException($message);
    }
}
