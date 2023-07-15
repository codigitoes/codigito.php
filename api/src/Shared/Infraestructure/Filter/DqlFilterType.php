<?php

declare(strict_types=1);

namespace Codigito\Shared\Infraestructure\Filter;

use Codigito\Shared\Domain\Filter\Filter;
use Doctrine\ORM\QueryBuilder;

interface DqlFilterType
{
    public function apply(Filter $filter, string $alias, QueryBuilder $queryBuilder): void;
}
