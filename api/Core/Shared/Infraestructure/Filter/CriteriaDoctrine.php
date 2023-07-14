<?php

declare(strict_types=1);

namespace Core\Shared\Infraestructure\Filter;

use Core\Shared\Domain\Filter\Criteria;
use Core\Shared\Domain\Filter\Filter;
use Doctrine\ORM\QueryBuilder;

final class CriteriaDoctrine
{
    final public static function apply(Criteria $criteria, QueryBuilder $queryBuilder, string $alias): void
    {
        foreach ($criteria->filters->filters as $filter) {
            self::getFilter($filter)->apply($filter, $alias, $queryBuilder);
        }

        $queryBuilder->orderBy($alias.'.'.$criteria->order->field->field, $criteria->order->order);
        $queryBuilder->setMaxResults($criteria->page->limit);
        $queryBuilder->setFirstResult($criteria->page->offset);
    }

    public static function getFilter(Filter $filter): DqlFilterType
    {
        $longClassName   = (new \ReflectionClass($filter->type))->getName();
        $shortClassName  = (new \ReflectionClass($filter->type))->getShortName();
        $filterClassName = str_replace($shortClassName, 'Dql'.$shortClassName, $longClassName);
        $filterClassName = str_replace('Domain', 'Infraestructure', $filterClassName);
        if (class_exists($filterClassName)) {
            return new $filterClassName();
        }
    }
}
