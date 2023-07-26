<?php

declare(strict_types=1);

namespace Codigito\Content\Blogcontent\Domain\ValueObject;

use Codigito\Shared\Domain\ValueObject\Base64Image;
use Codigito\Shared\Domain\Exception\InvalidParameterException;

class BlogcontentBase64Image extends Base64Image
{
    protected function throwException(string $message): void
    {
        throw new InvalidParameterException('invalid blogcontent image: '.$message);
    }
}
