<?php

declare(strict_types=1);

namespace Core\\Content\Blogpost\Domain\Exception;

use Core\\Shared\Domain\Exception\DomainException;

class BlogpostCantDeleteException extends DomainException
{
    public const PREFIX = 'cant delete blogpost';

    public function __construct(string $value)
    {
        parent::__construct(self::PREFIX . ' ' . $value);
    }

    public const ERROR_CODE = 500;

    public function getErrorCode(): int
    {
        return self::ERROR_CODE;
    }
}
