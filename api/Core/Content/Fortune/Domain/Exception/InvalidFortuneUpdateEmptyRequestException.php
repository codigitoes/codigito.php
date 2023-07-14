<?php

declare(strict_types=1);

namespace Core\Content\Fortune\Domain\Exception;

use Core\Shared\Domain\Exception\DomainException;

class InvalidFortuneUpdateEmptyRequestException extends DomainException
{
    public const PREFIX = 'invalid fortune update request, cant be empty';

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
