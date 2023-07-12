<?php

declare(strict_types=1);

namespace Codigoce\Context\Shared\Domain\Model;

interface PrimitivesMap
{
    public function toPrimitives(): array;
}
