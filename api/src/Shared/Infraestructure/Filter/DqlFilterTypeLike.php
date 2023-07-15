<?php

declare(strict_types=1);

namespace Codigito\Shared\Infraestructure\Filter;

use Codigito\Shared\Domain\Filter\Filter;
use Doctrine\ORM\QueryBuilder;

final class DqlFilterTypeLike implements DqlFilterType
{
    public function apply(Filter $filter, string $alias, QueryBuilder $queryBuilder): void
    {
        $dql = $alias.'.'.$filter->field->field.' LIKE :'.$filter->field->field;

        $queryBuilder->andWhere($dql);
        $queryBuilder->setParameter($filter->field->field, '%'.$filter->value->value.'%');
    }
}
