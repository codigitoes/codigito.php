<?php

declare(strict_types=1);

namespace Codigito\Shared\Domain\Filter;

use Codigito\Shared\Domain\Exception\InternalErrorException;

final class Filters
{
    public function __construct(
        public readonly array $filters = []
    ) {
        array_map(function ($aFilter) {
            if (false === $aFilter instanceof Filter) {
                throw new InternalErrorException('invalid filter: '.$aFilter->toString());
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
