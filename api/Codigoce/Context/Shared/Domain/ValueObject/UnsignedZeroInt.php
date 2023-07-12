<?php

declare(strict_types=1);

namespace Codigoce\Context\Shared\Domain\ValueObject;

abstract class UnsignedZeroInt
{
    final public function __construct(public readonly int $value)
    {
        $this->validateOrThrowException($value);
    }

    private function validateOrThrowException(int $value): void
    {
        if ($value >= 0) {
            return;
        }

        $this->throwException($value);
    }

    abstract protected function throwException(int $value): void;
}
