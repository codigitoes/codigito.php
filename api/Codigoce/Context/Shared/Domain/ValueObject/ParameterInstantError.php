<?php

declare(strict_types=1);

namespace Codigoce\Context\Shared\Domain\ValueObject;

use Codigoce\Context\Shared\Domain\Exception\ParameterNotFoundException;

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
