<?php

declare(strict_types=1);

namespace Core\Fidelization\Mailing\Domain\ValueObject;

use Core\Shared\Domain\ValueObject\UuidV4Id;
use Core\Fidelization\Mailing\Domain\Exception\InvalidMailingIdException;

class MailingId extends UuidV4Id
{
    protected function throwException(string $value): void
    {
        throw new InvalidMailingIdException($value);
    }
}
