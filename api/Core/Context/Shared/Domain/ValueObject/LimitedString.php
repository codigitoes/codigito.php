<?php

declare(strict_types=1);

namespace Core\Context\Shared\Domain\ValueObject;

abstract class LimitedString
{
    public function __construct(
        readonly int $minimum,
        readonly int $maximum,
        public readonly string $value
    ) {
        $this->validateOrThrowException($minimum, $maximum, $value);
    }

    private function validateOrThrowException(
        int $minimum,
        int $maximum,
        string $value
    ): void {
        if (strlen($value) >= $minimum && strlen($value) <= $maximum) {
            return;
        }

        $this->throwException($value);
    }

    abstract protected function throwException(string $message): void;
}
