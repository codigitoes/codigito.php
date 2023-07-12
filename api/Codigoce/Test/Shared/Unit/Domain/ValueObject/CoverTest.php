<?php

declare(strict_types=1);

namespace Codigoce\Test\Shared\Unit\Domain\ValueObject;

use Codigoce\Context\Shared\Domain\ValueObject\Cover;
use PHPUnit\Framework\TestCase;

class CoverImp extends Cover
{
    public const STUB_MESSAGE = 'hola :)';

    protected function throwException(string $value): void
    {
        throw new \Exception(self::STUB_MESSAGE);
    }
}

class CoverTest extends TestCase
{
    public function testItShouldCreateFromDestinationDirAndLocalRelativeFile(): void
    {
        $this->assertInstanceOf(Cover::class, new CoverImp('file.jpg'));
        $this->assertInstanceOf(Cover::class, new CoverImp('file.png'));
        $this->assertInstanceOf(Cover::class, new CoverImp('file.jpeg'));
        $this->assertInstanceOf(Cover::class, new CoverImp('file.gif'));
    }

    public function testItShouldThrowExceptionIfValueNotEndWithValidExtension(): void
    {
        $this->expectExceptionMessage(CoverImp::STUB_MESSAGE);

        new CoverImp('file.bmp');
    }
}
