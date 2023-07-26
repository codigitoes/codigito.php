<?php

declare(strict_types=1);

namespace Codigito\Content\Blogcontent\Domain\ValueObject;

use Codigito\Shared\Domain\ValueObject\Cover;
use Codigito\Shared\Domain\Exception\InvalidParameterException;

class BlogcontentImage extends Cover
{
    protected function throwException(string $message): void
    {
        throw new InvalidParameterException('invalid blogcontent image: '.$message);
    }
}
