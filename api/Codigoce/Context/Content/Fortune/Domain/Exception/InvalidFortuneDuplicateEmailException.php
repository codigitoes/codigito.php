<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Fortune\Domain\Exception;

use Codigoce\Context\Shared\Domain\Exception\DomainException;

class InvalidFortuneDuplicateEmailException extends DomainException
{
    public const PREFIX = 'invalid fortune email exists';

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
