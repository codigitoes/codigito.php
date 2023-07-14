<?php

declare(strict_types=1);

namespace App\Tests\Auth;

use App\Tests\Shared\Fixture\TestAuthFactory;
use PHPUnit\Framework\TestCase;

abstract class CoreAuthUnitTest extends TestCase
{
    use TestAuthFactory;
}
