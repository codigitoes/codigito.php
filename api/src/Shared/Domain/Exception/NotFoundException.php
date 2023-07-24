<?php

declare(strict_types=1);

namespace Codigito\Shared\Domain\Exception;

class NotFoundException extends DomainException
{
    public const PREFIX = 'not found';

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
