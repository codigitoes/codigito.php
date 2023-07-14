<?php

declare(strict_types=1);

namespace Core\Test\Shared\Unit\Domain\ValueObject;

use Core\Context\Shared\Domain\ValueObject\LimitedString;
use PHPUnit\Framework\TestCase;

class LimitedStringImp extends LimitedString
{
    public const MINIMUM_CHARS = 5;
    public const MAXIMUM_CHARS = 10;

    public function __construct(string $value)
    {
        parent::__construct(
            self::MINIMUM_CHARS,
            self::MAXIMUM_CHARS,
            $value
        );
    }

    protected function throwException(string $message): void
    {
        throw new \Exception('hola soy un error');
    }
}

class LimitedStringTest extends TestCase
{
    public function testItShouldThrowAnInvalidTitleExceptionOnLimitMin(): void
    {
        $this->expectException(\Exception::class);

        new LimitedStringImp(str_repeat('a', LimitedStringImp::MINIMUM_CHARS - 1));
    }

    public function testItShouldThrowAnInvalidTitleExceptionOnLimitMax(): void
    {
        $this->expectException(\Exception::class);

        new LimitedStringImp(str_repeat('a', LimitedStringImp::MAXIMUM_CHARS + 1));
    }

    public function testItShouldComposeCustomMessageWithLimitsPrefixMessageAndCreationMessage(): void
    {
        $value = str_repeat('a', LimitedStringImp::MINIMUM_CHARS - 1);

        $this->expectExceptionMessage('hola soy un error');

        new LimitedStringImp($value);
    }
}
