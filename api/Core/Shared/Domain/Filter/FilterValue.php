<?php

declare(strict_types=1);

namespace Core\\Shared\Domain\Filter;

final class FilterValue
{
    public function __construct(
        public readonly string|int|bool|array $value
    ) {
    }
}
