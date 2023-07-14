<?php

declare(strict_types=1);

namespace Core\Shared\Domain\ValueObject;

use Core\Shared\Domain\Exception\ParameterNotFoundException;

class ParameterInstantError
{
    public function __construct(string $parameter)
    {
        $this->throwException($parameter);
    }

    protected function throwException(string $parameter): void
    {
        throw new ParameterNotFoundException($parameter);
    }
}
