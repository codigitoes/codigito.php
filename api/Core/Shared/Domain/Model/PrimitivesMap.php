<?php

declare(strict_types=1);

namespace Core\Shared\Domain\Model;

interface PrimitivesMap
{
    public function toPrimitives(): array;
}
