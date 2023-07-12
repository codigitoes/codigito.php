<?php

declare(strict_types=1);

namespace Codigoce\Context\Shared\Domain\Filter;

class Criteria
{
    public function __construct(
        public readonly Filters $filters,
        public readonly Order $order,
        public readonly Page $page
    ) {
    }

    public function hasFilters(): bool
    {
        return $this->filters->hasFilters();
    }

    protected function equal(
        string $filterName,
        string|int $filterValue
    ): Filter {
        return new Filter(
            new FilterField($filterName),
            new FilterTypeEqual(),
            new FilterValue($filterValue)
        );
    }

    protected function equalId(
        string|int $filterValue
    ): Filter {
        return new Filter(
            new FilterField('id'),
            new FilterTypeEqual(),
            new FilterValue($filterValue)
        );
    }

    protected function equalName(
        string|int $filterValue
    ): Filter {
        return new Filter(
            new FilterField('name'),
            new FilterTypeEqual(),
            new FilterValue($filterValue)
        );
    }
}
