<?php

declare(strict_types=1);

namespace Codigito\Tests\Auth;

use Codigito\Tests\Shared\Fixture\TestAuthFactory;
use PHPUnit\Framework\TestCase;

abstract class CoreAuthUnitTest extends TestCase
{
    use TestAuthFactory;
}
