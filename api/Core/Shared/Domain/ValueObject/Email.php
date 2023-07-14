<?php

declare(strict_types=1);

namespace Core\\Shared\Domain\ValueObject;

abstract class Email
{
    public function __toString()
    {
        return $this->value;
    }

    final public function __construct(public readonly string $value)
    {
        $this->validateOrThrowException($value);
    }

    private function validateOrThrowException(string $value): void
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return;
        }

        $this->throwException($value);
    }

    abstract protected function throwException(string $value): void;
}
