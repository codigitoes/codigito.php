<?php

declare(strict_types=1);

namespace Core\Content\Tag\Domain\Exception;

use Core\Shared\Domain\Exception\DomainException;

class InvalidTagTypeException extends DomainException
{
    public const PREFIX = 'invalid tag type its an internal problem';

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
