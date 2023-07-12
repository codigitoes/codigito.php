<?php

declare(strict_types=1);

namespace Codigoce\Context\Shared\Domain\Query;

class EmptyQuery implements Query
{
    final public static function create(): self
    {
        return new self();
    }
}
