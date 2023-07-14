<?php

declare(strict_types=1);

namespace Core\\Shared\Domain\Exception;

class InvalidCommandCantFindHandlerException extends DomainException
{
    public const PREFIX = 'cant find a handler for command';

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
