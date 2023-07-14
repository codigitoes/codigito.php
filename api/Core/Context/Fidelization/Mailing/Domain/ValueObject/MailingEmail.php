<?php

declare(strict_types=1);

namespace Core\Context\Fidelization\Mailing\Domain\ValueObject;

use Core\Context\Shared\Domain\ValueObject\Email;
use Core\Context\Fidelization\Mailing\Domain\Exception\InvalidMailingEmailException;

class MailingEmail extends Email
{
    protected function throwException(string $value): void
    {
        throw new InvalidMailingEmailException($value);
    }
}
