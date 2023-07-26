<?php

declare(strict_types=1);

namespace Codigito\Content\Blogpost\Domain\ValueObject;

use Codigito\Shared\Domain\Exception\InvalidParameterException;
use Codigito\Shared\Domain\ValueObject\Base64Image;

class BlogpostBase64Image extends Base64Image
{
    protected function throwException(string $message): void
    {
        throw new InvalidParameterException('invalid blogpost base64 image: '.$message);
    }
}
