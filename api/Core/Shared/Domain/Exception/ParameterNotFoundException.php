<?php

declare(strict_types=1);

namespace Core\\Shared\Domain\Exception;

class ParameterNotFoundException extends DomainException
{
    public const PREFIX = 'parameter not found';

    public function __construct(string $parameter)
    {
        parent::__construct(self::PREFIX . ' ' . $parameter);
    }

    public const ERROR_CODE = 400;

    public function getErrorCode(): int
    {
        return self::ERROR_CODE;
    }
}
