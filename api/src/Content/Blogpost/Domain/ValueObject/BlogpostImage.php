<?php

declare(strict_types=1);

namespace Codigito\Content\Blogpost\Domain\ValueObject;

use Codigito\Shared\Domain\Exception\InvalidParameterException;
use Codigito\Shared\Domain\ValueObject\Cover;

class BlogpostImage extends Cover
{
    protected function throwException(string $message): void
    {
        throw new InvalidParameterException('invalid blogpost image: '.$message);
    }
}
