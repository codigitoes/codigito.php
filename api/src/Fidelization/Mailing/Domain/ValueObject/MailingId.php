<?php

declare(strict_types=1);

namespace Codigito\Fidelization\Mailing\Domain\ValueObject;

use Codigito\Shared\Domain\ValueObject\UuidV4Id;
use Codigito\Fidelization\Mailing\Domain\Exception\InvalidMailingIdException;

class MailingId extends UuidV4Id
{
    protected function throwException(string $value): void
    {
        throw new InvalidMailingIdException($value);
    }
}
