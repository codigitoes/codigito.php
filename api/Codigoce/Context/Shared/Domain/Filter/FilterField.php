<?php

declare(strict_types=1);

namespace Codigoce\Context\Shared\Domain\Filter;

final class FilterField
{
    public function __construct(
        public readonly string|array $field
    ) {
    }
}
