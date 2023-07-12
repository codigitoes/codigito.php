<?php

declare(strict_types=1);

namespace Codigoce\Test\Shared\Unit\Domain\ValueObject;

use Codigoce\Context\Shared\Domain\ValueObject\Base64Image;
use PHPUnit\Framework\TestCase;

class Base64ImageImp extends Base64Image
{
    public const STUB_MESSAGE = 'hola :)';

    protected function throwException(string $value): void
    {
        throw new \Exception(self::STUB_MESSAGE);
    }
}

class Base64ImageTest extends TestCase
{
    public const BASE64_VALID_IMAGE = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg==';

    public function testItShouldCreateFromValidBase64Image(): void
    {
        $this->assertInstanceOf(Base64Image::class, new Base64ImageImp(self::BASE64_VALID_IMAGE));
    }

    public function testItShouldThrowExceptionIfCreateWithNoValidBase64Image(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage(Base64ImageImp::STUB_MESSAGE);

        $this->assertInstanceOf(Base64Image::class, new Base64ImageImp('not valid base64 image'));
    }
}
