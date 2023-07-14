<?php

declare(strict_types=1);

namespace Core\\Shared\Infraestructure\Filter;

use Core\\Shared\Domain\Filter\Filter;
use Doctrine\ORM\QueryBuilder;

interface DqlFilterType
{
    public function apply(Filter $filter, string $alias, QueryBuilder $queryBuilder): void;
}
