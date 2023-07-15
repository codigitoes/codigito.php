<?php

declare(strict_types=1);

namespace Codigito\Shared\Domain\ValueObject;

use Codigito\Shared\Domain\Exception\ParameterNotFoundException;

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
