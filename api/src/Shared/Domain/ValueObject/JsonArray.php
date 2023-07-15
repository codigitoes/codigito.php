<?php

declare(strict_types=1);

namespace Codigito\Shared\Domain\ValueObject;

abstract class JsonArray
{
    abstract protected function throwException(string $value): void;

    public function __construct(
        public readonly string $value
    ) {
        $this->validateJsonContainArrayOrThrowException();
    }

    final public function toMap(): array
    {
        return json_decode($this->value);
    }

    private function validateJsonContainArrayOrThrowException(): void
    {
        if (empty($this->value)) {
            $this->throwException('json value cannot be empty');
        }
        if (false === is_array(json_decode($this->value, true))) {
            $this->throwException('json decoded value must be an array');
        }
    }
}
