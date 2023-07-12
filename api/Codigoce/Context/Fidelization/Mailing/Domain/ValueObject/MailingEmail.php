<?php

declare(strict_types=1);

namespace Codigoce\Context\Fidelization\Mailing\Domain\ValueObject;

use Codigoce\Context\Shared\Domain\ValueObject\Email;
use Codigoce\Context\Fidelization\Mailing\Domain\Exception\InvalidMailingEmailException;

class MailingEmail extends Email
{
    protected function throwException(string $value): void
    {
        throw new InvalidMailingEmailException($value);
    }
}
