<?php

declare(strict_types=1);

namespace Codigito\Shared\Domain\Model;

interface PrimitivesMap
{
    public function toPrimitives(): array;
}
