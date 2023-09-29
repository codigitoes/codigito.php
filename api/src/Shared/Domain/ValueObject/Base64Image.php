<?php

declare(strict_types=1);

namespace Codigito\Shared\Domain\ValueObject;

abstract class Base64Image
{
    public const AVAILABLE_EXTENSIONS = ['jpeg', 'jpg', 'png', 'gif'];

    abstract protected function throwException(string $value): void;

    public function __construct(
        public readonly string $value
    ) {
        $this->validateItsNotEmptyOrThrowException();
        $this->validateExtensionOrThrowException();
    }

    private function validateItsNotEmptyOrThrowException(): void
    {
        if (empty($this->value)) {
            $this->throwException('base64 image cannot be empty');
        }
    }

    private function validateExtensionOrThrowException(): void
    {
        $temporalyFile = $this->createTemporalyFile();
        $fileInfo      = mime_content_type($temporalyFile);
        $extension     = str_replace('image/', '', $fileInfo);
        if (!$this->isValidExtension($extension)) {
            $this->throwException('file of '.$fileInfo.' is not allow. Use '.implode(', ', self::AVAILABLE_EXTENSIONS));
        }
    }

    private function createTemporalyFile(): string
    {
        try {
            $gdImage = imagecreatefromstring(base64_decode($this->value));
        } catch (\Throwable) {
            $this->throwException('cant create image from received base64');
        }
        $temporalyFile = sys_get_temp_dir().DIRECTORY_SEPARATOR.UuidV4Id::randomUuidV4();

        $created = imagepng($gdImage, $temporalyFile);
        if (false === $created) {
            $created = imagejpeg($gdImage, $temporalyFile);
        }
        if (false === $created) {
            $this->throwException('cant create image from received base64');
        }

        return $temporalyFile;
    }

    private function isValidExtension(string $extension): bool
    {
        return in_array($extension, self::AVAILABLE_EXTENSIONS);
    }
}
