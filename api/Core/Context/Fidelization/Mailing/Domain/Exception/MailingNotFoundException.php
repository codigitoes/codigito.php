<?php

declare(strict_types=1);

namespace Core\Context\Fidelization\Mailing\Domain\Exception;

use Core\Context\Shared\Domain\Exception\DomainException;

class MailingNotFoundException extends DomainException
{
    public const PREFIX = 'mailing not found';

    public function __construct(string $value)
    {
        parent::__construct(self::PREFIX . ' ' . $value);
    }

    public const ERROR_CODE = 404;

    public function getErrorCode(): int
    {
        return self::ERROR_CODE;
    }
}
