<?php

declare(strict_types=1);

namespace Core\Content\Shared\Domain\Exception;

use Core\Shared\Domain\Exception\DomainException;

class BlogpostNotFoundException extends DomainException
{
    public const PREFIX = 'blogpost not found';

    public function __construct(string $value)
    {
        parent::__construct(self::PREFIX.' '.$value);
    }

    public const ERROR_CODE = 404;

    public function getErrorCode(): int
    {
        return self::ERROR_CODE;
    }
}
