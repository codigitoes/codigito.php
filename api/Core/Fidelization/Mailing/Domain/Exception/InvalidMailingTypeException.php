<?php

declare(strict_types=1);

namespace Core\Fidelization\Mailing\Domain\Exception;

use Core\Shared\Domain\Exception\DomainException;

class InvalidMailingTypeException extends DomainException
{
    public const PREFIX = 'invalid mailing type its an internal problem';

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
