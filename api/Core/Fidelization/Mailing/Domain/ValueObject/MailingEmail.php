<?php

declare(strict_types=1);

namespace Core\\Fidelization\Mailing\Domain\ValueObject;

use Core\\Shared\Domain\ValueObject\Email;
use Core\\Fidelization\Mailing\Domain\Exception\InvalidMailingEmailException;

class MailingEmail extends Email
{
    protected function throwException(string $value): void
    {
        throw new InvalidMailingEmailException($value);
    }
}
