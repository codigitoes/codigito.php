<?php

declare(strict_types=1);

namespace Codigito\Content\Shared\Domain\Exception;

use Codigito\Shared\Domain\Exception\DomainException;

class InvalidTagNameException extends DomainException
{
    public const PREFIX = 'invalid tag name';

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