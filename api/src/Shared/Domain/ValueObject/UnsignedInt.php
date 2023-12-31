<?php

declare(strict_types=1);

namespace Codigito\Shared\Domain\ValueObject;

abstract class UnsignedInt
{
    final public function __construct(public readonly int $value)
    {
        $this->validateOrThrowException($value);
    }

    private function validateOrThrowException(int $value): void
    {
        if ($value > 0) {
            return;
        }

        $this->throwException($value);
    }

    abstract protected function throwException(int $value): void;
}
