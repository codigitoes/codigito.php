<?php

declare(strict_types=1);

namespace Codigoce\Context\Fidelization\Mailing\Domain\ValueObject;

class MailingConfirmed
{
    public function __construct(public readonly bool $value)
    {
    }

    public function toString(): string
    {
        $result = 'no';
        if ($this->value) {
            $result = 'yes';
        }

        return $result;
    }

    final public static function confirmed(): self
    {
        return new self(true);
    }

    final public static function unconfirmed(): self
    {
        return new self(false);
    }
}
