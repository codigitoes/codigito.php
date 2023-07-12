<?php

declare(strict_types=1);

namespace Codigoce\Context\Shared\Domain\Filter;

class Filter
{
    public function __construct(
        public readonly FilterField $field,
        public readonly FilterType $type,
        public readonly FilterValue $value
    ) {
    }
}
