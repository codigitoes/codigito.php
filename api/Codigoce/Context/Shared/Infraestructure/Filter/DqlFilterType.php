<?php

declare(strict_types=1);

namespace Codigoce\Context\Shared\Infraestructure\Filter;

use Codigoce\Context\Shared\Domain\Filter\Filter;
use Doctrine\ORM\QueryBuilder;

interface DqlFilterType
{
    public function apply(Filter $filter, string $alias, QueryBuilder $queryBuilder): void;
}
