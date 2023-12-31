<?php

declare(strict_types=1);

namespace Codigito\Shared\Domain\Filter;

final class FilterField
{
    public function __construct(
        public readonly string|array $field
    ) {
    }
}
