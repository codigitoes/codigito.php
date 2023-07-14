<?php

declare(strict_types=1);

namespace Core\Shared\Domain\ValueObject;

abstract class Cover
{
    public const AVAILABLE_EXTENSIONS = ['jpeg', 'jpg', 'png', 'gif'];

    abstract protected function throwException(string $value): void;

    public function __construct(
        public readonly string $value
    ) {
        $this->validateFilePathItsNotEmptyOrThrowException();
        $this->validateIsValidExtensionFromFullPathException();
    }

    private function validateFilePathItsNotEmptyOrThrowException(): void
    {
        if (empty($this->value)) {
            $this->throwException('cover cannot be empty');
        }
    }

    private function validateIsValidExtensionFromFullPathException(): void
    {
        if (preg_match('/.+\.['.implode(',', self::AVAILABLE_EXTENSIONS).']+$/i', $this->value)) {
            return;
        }

        $this->throwException('cover must be a filename with an extension: '.implode(',', self::AVAILABLE_EXTENSIONS).' received: '.$this->value);
    }
}
