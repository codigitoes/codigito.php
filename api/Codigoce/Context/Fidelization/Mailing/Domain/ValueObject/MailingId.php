<?php

declare(strict_types=1);

namespace Codigoce\Context\Fidelization\Mailing\Domain\ValueObject;

use Codigoce\Context\Shared\Domain\ValueObject\UuidV4Id;
use Codigoce\Context\Fidelization\Mailing\Domain\Exception\InvalidMailingIdException;

class MailingId extends UuidV4Id
{
    protected function throwException(string $value): void
    {
        throw new InvalidMailingIdException($value);
    }
}
