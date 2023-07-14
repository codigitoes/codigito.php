<?php

declare(strict_types=1);

namespace Core\\Shared\Domain\Filter;

use Core\\Shared\Domain\Exception\InvalidFilterException;

final class Filters
{
    public function __construct(
        public readonly array $filters = []
    ) {
        array_map(function ($aFilter) {
            if (false === $aFilter instanceof Filter) {
                throw new InvalidFilterException($aFilter->toString());
            }

            return $aFilter;
        }, $filters);
    }

    final public static function empty(): Filters
    {
        return new Filters([]);
    }

    public function hasFilters(): bool
    {
        return count($this->filters) > 0;
    }
}
