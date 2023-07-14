<?php

declare(strict_types=1);

namespace Core\Content\Tag\Domain\Exception;

use Core\Shared\Domain\Exception\DomainException;

class InvalidTagImageException extends DomainException
{
    public const PREFIX = 'invalid tag image';

    public function __construct(string $value)
    {
        parent::__construct(self::PREFIX.' '.$value);
    }

    public const ERROR_CODE = 400;

    public function getErrorCode(): int
    {
        return self::ERROR_CODE;
    }
}
