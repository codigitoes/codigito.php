<?php

declare(strict_types=1);

namespace Codigito\Content\Blogpost\Domain\ValueObject;

use Codigito\Shared\Domain\Exception\InvalidParameterException;

class BlogpostYoutube
{
    public readonly string $value;

    public function __construct(public string $url)
    {
        $this->value = str_replace('watch?v=', 'embed/', $url);

        if (!preg_match('/.+youtube.+/', $this->value) && !preg_match('/.+youtu\.be.+/', $this->value)) {
            $this->throwException($this->value);
        }
    }

    protected function throwException(string $value): void
    {
        throw new InvalidParameterException('invalid blogpost youtube url: '.$value);
    }
}
