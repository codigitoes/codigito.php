<?php

declare(strict_types=1);

namespace Core\Shared\Domain\Query;

class EmptyQuery implements Query
{
    final public static function create(): self
    {
        return new self();
    }
}
