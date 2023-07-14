<?php

declare(strict_types=1);

namespace Core\\Shared\Domain\ValueObject;

abstract class UuidV4Id
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
        if (self::isValidUuidV4($value)) {
            return;
        }

        $this->throwException($value);
    }

    abstract protected function throwException(string $value): void;

    final public static function random(): static
    {
        return new static(self::randomUuidV4());
    }

    final public static function isValidUuidV4(string $value): bool
    {
        return preg_match('/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i', $value) > 0;
    }

    final public static function randomUuidV4(): string
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xFFFF),
            mt_rand(0, 0xFFFF),
            mt_rand(0, 0xFFFF),
            mt_rand(0, 0x0FFF) | 0x4000,
            mt_rand(0, 0x3FFF) | 0x8000,
            mt_rand(0, 0xFFFF),
            mt_rand(0, 0xFFFF),
            mt_rand(0, 0xFFFF)
        );
    }
}
