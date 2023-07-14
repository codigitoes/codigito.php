<?php

declare(strict_types=1);

namespace Core\Content\Tag\Domain\Exception;

use Core\Shared\Domain\Exception\DomainException;

class TagCantUpdateException extends DomainException
{
    public const PREFIX = 'cant update tag';

    public function __construct(string $value)
    {
        parent::__construct(self::PREFIX.' '.$value);
    }

    public const ERROR_CODE = 500;

    public function getErrorCode(): int
    {
        return self::ERROR_CODE;
    }
}
