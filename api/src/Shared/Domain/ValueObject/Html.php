<?php

declare(strict_types=1);

namespace Codigito\Shared\Domain\ValueObject;

abstract class Html
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
        if ($value != strip_tags($value)) {
            return;
        }

        $this->throwException($value);
    }

    abstract protected function throwException(string $value): void;
}
