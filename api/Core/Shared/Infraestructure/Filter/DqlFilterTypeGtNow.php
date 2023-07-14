<?php

declare(strict_types=1);

namespace Core\\Shared\Infraestructure\Filter;

use Core\\Shared\Domain\Filter\Filter;
use Doctrine\ORM\QueryBuilder;

final class DqlFilterTypeGtNow implements DqlFilterType
{
    public function apply(Filter $filter, string $alias, QueryBuilder $queryBuilder): void
    {
        $dql = $alias . '.' . $filter->field->field . ' > CURRENT_TIMESTAMP()';

        $queryBuilder->andWhere($dql);
    }
}
