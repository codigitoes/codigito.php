<?php

declare(strict_types=1);

namespace Codigoce\Test\Auth;

use Codigoce\Test\Shared\Fixture\TestAuthFactory;
use PHPUnit\Framework\TestCase;

abstract class CodigoceAuthUnitTest extends TestCase
{
    use TestAuthFactory;
}
