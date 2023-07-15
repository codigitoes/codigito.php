<?php

declare(strict_types=1);

namespace Codigito\Fidelization\Mailing\Domain\ValueObject;

use Codigito\Shared\Domain\ValueObject\Email;
use Codigito\Fidelization\Mailing\Domain\Exception\InvalidMailingEmailException;

class MailingEmail extends Email
{
    protected function throwException(string $value): void
    {
        throw new InvalidMailingEmailException($value);
    }
}
