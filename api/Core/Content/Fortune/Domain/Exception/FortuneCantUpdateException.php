<?php

declare(strict_types=1);

namespace Core\\Content\Fortune\Domain\Exception;

use Core\\Shared\Domain\Exception\DomainException;

class FortuneCantUpdateException extends DomainException
{
    public const PREFIX = 'cant update fortune';

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
