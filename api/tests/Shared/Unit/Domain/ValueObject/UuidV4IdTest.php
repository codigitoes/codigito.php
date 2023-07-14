<?php

declare(strict_types=1);

namespace App\Tests\Shared\Unit\Domain\ValueObject;

use Core\Shared\Domain\ValueObject\UuidV4Id;
use PHPUnit\Framework\TestCase;

class UuidV4IdImp extends UuidV4Id
{
    protected function throwException(string $value): void
    {
        throw new \Exception('im here :)');
    }
}

class UuidV4IdTest extends TestCase
{
    public const UUID_V4 = 'e9d77fed-8b26-4894-8013-9a7fe5beb606';

    public function testItShouldGenerateId(): void
    {
        $this->assertInstanceOf(UuidV4IdImp::class, UuidV4IdImp::random());
    }

    public function testItShouldGenerateRandomUuidValue(): void
    {
        $this->assertTrue(UuidV4Id::isValidUuidV4(UuidV4Id::randomUuidV4()));
    }

    public function testItShouldValidateUuidValue(): void
    {
        $this->assertTrue(UuidV4Id::isValidUuidV4(self::UUID_V4));
    }

    public function testItShouldThrowAnInvalidIdExceptionOnInvalidCreation(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('im here :)');

        new UuidV4IdImp('invalid value');
    }
}
