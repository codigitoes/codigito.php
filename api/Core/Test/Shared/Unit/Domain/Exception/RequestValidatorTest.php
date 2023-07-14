<?php

declare(strict_types=1);

namespace Core\Test\Shared\Unit\Exception;

use Core\Context\Shared\Domain\Exception\ParameterNotFoundException;
use Core\Context\Shared\Domain\Helper\ParametersValidator;
use Core\Context\Shared\Domain\ValueObject\LimitedString;
use PHPUnit\Framework\TestCase;

class ParametersValidatorTestVO extends LimitedString
{
    public const STUB_MESSAGE = 'hola';

    public function __construct(
        string $value
    ) {
        parent::__construct(5, 10, $value);
    }

    protected function throwException(string $message): void
    {
        throw new ParameterNotFoundException(self::STUB_MESSAGE);
    }
}

class RequestValidatorTest extends TestCase
{
    public function testItShouldResult1ErrorForEachValidationKeyError(): void
    {
        $sut = new ParametersValidator();

        $sut->register('key1', ParametersValidatorTestVO::class);
        $sut->register('key2', ParametersValidatorTestVO::class);
        $sut->register('key3', ParametersValidatorTestVO::class);

        $parameters = [
            'key1' => '',
            'key2' => '',
            'key3' => str_repeat('a', 10),
        ];
        $actual = $sut->validate($parameters);

        $this->assertIsArray($actual);
        $this->assertCount(2, $actual);
        $this->assertEquals(ParameterNotFoundException::PREFIX . ' ' . ParametersValidatorTestVO::STUB_MESSAGE, $actual[0]);
        $this->assertEquals(ParameterNotFoundException::PREFIX . ' ' . ParametersValidatorTestVO::STUB_MESSAGE, $actual[1]);
    }

    public function testItShouldResult1ErrorForEachParameterKeyNotFound(): void
    {
        $sut = new ParametersValidator();
        $sut->register('key1', ParametersValidatorTestVO::class);
        $sut->register('key2', ParametersValidatorTestVO::class);
        $sut->register('key3', ParametersValidatorTestVO::class);

        $parameters = [
            'key2' => str_repeat('a', 10),
        ];
        $actual   = $sut->validate($parameters);
        $expected = [
            ParameterNotFoundException::PREFIX . ' key1',
            ParameterNotFoundException::PREFIX . ' key3',
        ];
        $this->assertIsArray($actual);
        $this->assertCount(2, $actual);
        $this->assertEquals($expected, $actual);
    }
}
