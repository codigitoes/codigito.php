<?php

declare(strict_types=1);

namespace Codigoce\Context\Shared\Domain\Exception;

class CantCreateCdnLocalException extends DomainException
{
    public const PREFIX = 'cant create into cdn local';

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