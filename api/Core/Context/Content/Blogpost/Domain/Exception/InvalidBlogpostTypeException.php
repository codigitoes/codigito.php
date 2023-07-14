<?php

declare(strict_types=1);

namespace Core\Context\Content\Blogpost\Domain\Exception;

use Core\Context\Shared\Domain\Exception\DomainException;

class InvalidBlogpostTypeException extends DomainException
{
    public const PREFIX = 'invalid blogpost type its an internal problem';

    public function __construct()
    {
        parent::__construct(self::PREFIX);
    }

    public const ERROR_CODE = 500;

    public function getErrorCode(): int
    {
        return self::ERROR_CODE;
    }
}
