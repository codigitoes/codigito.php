<?php

declare(strict_types=1);

namespace Core\Test\Auth;

use Core\Test\Shared\Fixture\TestAuthFactory;
use PHPUnit\Framework\TestCase;

abstract class CoreAuthUnitTest extends TestCase
{
    use TestAuthFactory;
}
