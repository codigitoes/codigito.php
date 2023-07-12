<?php

declare(strict_types=1);

namespace Codigoce\Context\Fidelization\Mailing\Domain\Exception;

use Codigoce\Context\Shared\Domain\Exception\DomainException;

class MailingCantSaveException extends DomainException
{
    public const PREFIX = 'cant create a new mailing';

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