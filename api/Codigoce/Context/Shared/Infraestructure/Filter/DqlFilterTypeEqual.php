<?php

declare(strict_types=1);

namespace Codigoce\Context\Shared\Infraestructure\Filter;

use Codigoce\Context\Shared\Domain\Filter\Filter;
use Doctrine\ORM\QueryBuilder;

final class DqlFilterTypeEqual implements DqlFilterType
{
    public function apply(Filter $filter, string $alias, QueryBuilder $queryBuilder): void
    {
        $dql = $alias.'.'.$filter->field->field.' = :'.$filter->field->field;

        $queryBuilder->andWhere($dql);
        $queryBuilder->setParameter($filter->field->field, $filter->value->value);
    }
}